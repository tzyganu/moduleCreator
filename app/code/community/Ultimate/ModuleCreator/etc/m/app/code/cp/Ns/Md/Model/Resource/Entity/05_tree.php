	/**
	 * Retrieve {{entityLabel}} tree object
	 * @access protected
	 * @return Varien_Data_Tree_Db
	 * {{qwertyuiop}}
	 */
	protected function _getTree(){
		if (!$this->_tree) {
			$this->_tree = Mage::getResourceModel('{{module}}/{{entity}}_tree')->load();
		}
		return $this->_tree;
	}
	/**
	 * Process {{entityLabel}} data before delete
	 * update children count for parent {{entityLabel}}
	 * delete child {{entitiesLabel}}
	 * @access protected
	 * @param Varien_Object $object
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}
	 * {{qwertyuiop}}
	 */
	protected function _beforeDelete(Mage_Core_Model_Abstract $object){
		parent::_beforeDelete($object);
		/**
		 * Update children count for all parent {{entitiesLabel}}
		 */
		$parentIds = $object->getParentIds();
		if ($parentIds) {
			$childDecrease = $object->getChildrenCount() + 1; // +1 is itself
			$data = array('children_count' => new Zend_Db_Expr('children_count - ' . $childDecrease));
			$where = array('entity_id IN(?)' => $parentIds);
			$this->_getWriteAdapter()->update( $this->getMainTable(), $data, $where);
		}
		$this->deleteChildren($object);
		return $this;
	}
	/**
	 * Delete children {{entitiesLabel}} of specific {{entityLabel}}
	 * @access public
	 * @param Varien_Object $object
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}
	 * {{qwertyuiop}}
	 */
	public function deleteChildren(Varien_Object $object){
		$adapter = $this->_getWriteAdapter();
		$pathField = $adapter->quoteIdentifier('path');
		$select = $adapter->select()
			->from($this->getMainTable(), array('entity_id'))
			->where($pathField . ' LIKE :c_path');
		$childrenIds = $adapter->fetchCol($select, array('c_path' => $object->getPath() . '/%'));
		if (!empty($childrenIds)) {
			$adapter->delete(
				$this->getMainTable(),
				array('entity_id IN (?)' => $childrenIds)
			);
		}
		/**
		 * Add deleted children ids to object
		 * This data can be used in after delete event
		 */
		$object->setDeletedChildrenIds($childrenIds);
		return $this;
	}
	/**
	 * Process {{entityLabel}} data after save {{entityLabel}} object
	 * @access protected
	 * @param Varien_Object $object
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}
	 * {{qwertyuiop}}
	 */
	protected function _afterSave(Mage_Core_Model_Abstract $object){
		if (substr($object->getPath(), -1) == '/') {
			$object->setPath($object->getPath() . $object->getId());
			$this->_savePath($object);
		}
		$oldStores = $this->lookupStoreIds($object->getId());
		$newStores = (array)$object->getStores();
		if (empty($newStores)) {
			$newStores = (array)$object->getStoreId();
		}
		$table  = $this->getTable('{{module}}/{{entity}}_store');
		$insert = array_diff($newStores, $oldStores);
		$delete = array_diff($oldStores, $newStores);
		if ($delete) {
			$where = array(
				'{{entity}}_id = ?' => (int) $object->getId(),
				'store_id IN (?)' => $delete
			);
			$this->_getWriteAdapter()->delete($table, $where);
		}
		if ($insert) {
			$data = array();
			foreach ($insert as $storeId) {
				$data[] = array(
					'{{entity}}_id'  => (int) $object->getId(),
					'store_id' => (int) $storeId
				);
			}
			$this->_getWriteAdapter()->insertMultiple($table, $data);
		}
		return parent::_afterSave($object);
	}

	/**
	 * Update path field
	 * @access protected
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} $object
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}
	 * {{qwertyuiop}}
	 */
	protected function _savePath($object){
		if ($object->getId()) {
			$this->_getWriteAdapter()->update(
				$this->getMainTable(),
				array('path' => $object->getPath()),
				array('entity_id = ?' => $object->getId())
			);
		}
		return $this;
	}

	/**
	 * Get maximum position of child {{entitiesLabel}} by specific tree path
	 * @access protected
	 * @param string $path
	 * @return int
	 * {{qwertyuiop}}
	 */
	protected function _getMaxPosition($path){
		$adapter = $this->getReadConnection();
		$positionField = $adapter->quoteIdentifier('position');
		$level   = count(explode('/', $path));
		$bind = array(
			'c_level' => $level,
			'c_path'  => $path . '/%'
		);
		$select  = $adapter->select()
			->from($this->getMainTable(), 'MAX(' . $positionField . ')')
			->where($adapter->quoteIdentifier('path') . ' LIKE :c_path')
			->where($adapter->quoteIdentifier('level') . ' = :c_level');
		
		$position = $adapter->fetchOne($select, $bind);
		if (!$position) {
			$position = 0;
		}
		return $position;
	}
	/**
	 * Get children {{entitiesLabel}} count
	 * @access public
	 * @param int ${{entity}}Id
	 * @return int
	 * {{qwertyuiop}}
	 */
	public function getChildrenCount(${{entity}}Id){
		$select = $this->_getReadAdapter()->select()
			->from($this->getMainTable(), 'children_count')
			->where('entity_id = :entity_id');
		$bind = array('entity_id' => ${{entity}}Id);
		return $this->_getReadAdapter()->fetchOne($select, $bind);
	}
	/**
	 * Check if {{entityLabel}} id exist
	 * @access public
	 * @param int $entityId
	 * @return bool
	 * {{qwertyuiop}}
	 */
	public function checkId($entityId){
		$select = $this->_getReadAdapter()->select()
			->from($this->getMainTable(), 'entity_id')
			->where('entity_id = :entity_id');
		$bind =  array('entity_id' => $entityId);
		return $this->_getReadAdapter()->fetchOne($select, $bind);
	}

	/**
	 * Check array of {{entitiesLabel}} identifiers
	 * @access public
	 * @param array $ids
	 * @return array
	 * {{qwertyuiop}}
	 */
	public function verifyIds(array $ids){
		if (empty($ids)) {
			return array();
		}
		$select = $this->_getReadAdapter()->select()
			->from($this->getMainTable(), 'entity_id')
			->where('entity_id IN(?)', $ids);
		
		return $this->_getReadAdapter()->fetchCol($select);
	}
