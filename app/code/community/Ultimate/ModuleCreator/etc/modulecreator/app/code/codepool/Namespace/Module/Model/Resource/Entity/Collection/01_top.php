<?php
{{License}}
/**
 * {{EntityLabel}} collection resource model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
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
