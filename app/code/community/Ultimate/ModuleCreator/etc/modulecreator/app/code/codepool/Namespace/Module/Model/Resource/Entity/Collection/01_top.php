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
