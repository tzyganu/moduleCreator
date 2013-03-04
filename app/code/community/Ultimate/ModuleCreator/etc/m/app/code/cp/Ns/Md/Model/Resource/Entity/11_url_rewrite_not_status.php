	/**
	 * check url key
	 * @access public
	 * @param string $urlKey
	 * @return mixed
	 * {{qwertyuiop}}
	 */
	public function checkUrlKey($urlKey){
		$select = $this->_initCheckUrlKeySelect($urlKey);
		$select->reset(Zend_Db_Select::COLUMNS)
			->columns('main_table.entity_id')
			->limit(1);
		
		return $this->_getReadAdapter()->fetchOne($select);
	}
	/**
	 * init the check select
	 * @access protected
	 * @param string $urlKey
	 * @return Zend_Db_Select
	 * {{qwertyuiop}}
	 */
	protected function _initCheckUrlKeySelect($urlKey){
		$select = $this->_getReadAdapter()->select()
			->from(array('main_table' => $this->getMainTable()))
			->where('main_table.url_key = ?', $urlKey);
		return $select;
	}
	/**
	 * Check for unique URL key
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * {{qwertyuiop}}
	 */
	public function getIsUniqueUrlKey(Mage_Core_Model_Abstract $object){
		$select = $this->_initCheckUrlKeySelect($object->getData('url_key'));
		if ($object->getId()) {
			$select->where('main_table.entity_id <> ?', $object->getId());
		}
		if ($this->_getWriteAdapter()->fetchRow($select)) {
			return false;
		}
		return true;
	}
	/**
	 * Check if the URL key is numeric
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * {{qwertyuiop}}
	 */
	protected function isNumericUrlKey(Mage_Core_Model_Abstract $object){
		return preg_match('/^[0-9]+$/', $object->getData('url_key'));
	}
	/**
	 * Checkif the URL key is valid
	 * @access public
	 * @param Mage_Core_Model_Abstract $object
	 * @return bool
	 * {{qwertyuiop}}
	 */
	protected function isValidUrlKey(Mage_Core_Model_Abstract $object){
		return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('url_key'));
	}