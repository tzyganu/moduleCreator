	/**
	 * Get count of active/not active children {{entitiesLabel}}
	 *
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @param bool $isActiveFlag
	 * @return int
	 * {{qwertyuiop}}
	 */
	public function getChildrenAmount(${{entity}}, $isActiveFlag = true){
		$bind = array(
			'active_flag'  => $isActiveFlag,
			'c_path'   => ${{entity}}->getPath() . '/%'
		);
		$select = $adapter->select()
			->from(array('m' => $this->getMainTable()), array('COUNT(m.entity_id)'))
			->where('m.path LIKE :c_path')
			->where('status' . ' = :active_flag');
		return $this->_getReadAdapter()->fetchOne($select, $bind);
	}
	/**
	 * Return parent {{entitiesLabel}} of {{entityLabel}}
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @return array
	 * {{qwertyuiop}}
	 */
	public function getParent{{Entities}}(${{entity}}){
		$pathIds = array_reverse(explode('/', ${{entity}}->getPath()));
		${{entities}} = Mage::getResourceModel('{{module}}/{{entity}}_collection')
			->addFieldToFilter('entity_id', array('in' => $pathIds))
			->addFieldToFilter('status', 1)
			->load()
			->getItems();
		return ${{entities}};
	}
	/**
	 * Return child {{entitiesLabel}}
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function getChildren{{Entities}}(${{entity}}){
		$collection = ${{entity}}->getCollection();
		$collection
			->addFilter('status', 1)
			->addIdFilter(${{entity}}->getChildren())
			->setOrder('position', Varien_Db_Select::SQL_ASC)
			->load();
		return $collection;
	}
	/**
	 * Return children ids of {{entityLabel}}
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @param boolean $recursive
	 * @return array
	 * {{qwertyuiop}}
	 */
	public function getChildren(${{entity}}, $recursive = true){
		$bind = array(
			'c_path'   => ${{entity}}->getPath() . '/%'
		);
		$select = $this->_getReadAdapter()->select()
			->from(array('m' => $this->getMainTable()), 'entity_id')
			->where('status = ?', 1)
			->where($this->_getReadAdapter()->quoteIdentifier('path') . ' LIKE :c_path');
		if (!$recursive) {
			$select->where($this->_getReadAdapter()->quoteIdentifier('level') . ' <= :c_level');
			$bind['c_level'] = ${{entity}}->getLevel() + 1;
		}
		return $this->_getReadAdapter()->fetchCol($select, $bind);
	}
