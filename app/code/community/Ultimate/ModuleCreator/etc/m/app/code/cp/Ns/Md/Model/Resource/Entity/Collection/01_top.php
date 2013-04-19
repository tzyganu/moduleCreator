<?php
{{License}}
/**
 * {{EntityLabel}} collection resource model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
	protected $_joinedFields = array();
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('{{module}}/{{entity}}');
		$this->_map['fields']['store'] = 'store_table.store_id';
	}
	/**
	 * get {{entities}} as array
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @param array $additional
	 * @return array
	 * {{qwertyuiop}}
	 */
	protected function _toOptionArray($valueField='entity_id', $labelField='{{nameAttribute}}', $additional=array()){
		return parent::_toOptionArray($valueField, $labelField, $additional);
	}
	/**
	 * get options hash
	 * @access protected
	 * @param string $valueField
	 * @param string $labelField
	 * @return array
	 * {{qwertyuiop}}
	 */
	protected function _toOptionHash($valueField='entity_id', $labelField='{{nameAttribute}}'){
		return parent::_toOptionHash($valueField, $labelField);
	}
	/**
	 * Add filter by store
	 * @access public
	 * @param int|Mage_Core_Model_Store $store
	 * @param bool $withAdmin
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addStoreFilter($store, $withAdmin = true){
		if (!isset($this->_joinedFields['store'])){
			if ($store instanceof Mage_Core_Model_Store) {
				$store = array($store->getId());
			}
			if (!is_array($store)) {
				$store = array($store);
			}
			if ($withAdmin) {
				$store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
			}
			$this->addFilter('store', array('in' => $store), 'public');
			$this->_joinedFields['store'] = true;
		}
		return $this;
	}
	/**
	 * Join store relation table if there is store filter
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	protected function _renderFiltersBefore(){
		if ($this->getFilter('store')) {
			$this->getSelect()->join(
				array('store_table' => $this->getTable('{{module}}/{{entity}}_store')),
				'main_table.entity_id = store_table.{{entity}}_id',
				array()
			)->group('main_table.entity_id');
			/*
			 * Allow analytic functions usage because of one field grouping
			 */
			$this->_useAnalyticFunction = true;
		}
		return parent::_renderFiltersBefore();
	}
	/**
	 * Get SQL for get record count.
	 * Extra GROUP BY strip added.
	 * @access public
	 * @return Varien_Db_Select
	 * {{qwertyuiop}}
	 */
	public function getSelectCountSql(){
		$countSelect = parent::getSelectCountSql();
		$countSelect->reset(Zend_Db_Select::GROUP);
		return $countSelect;
	}
