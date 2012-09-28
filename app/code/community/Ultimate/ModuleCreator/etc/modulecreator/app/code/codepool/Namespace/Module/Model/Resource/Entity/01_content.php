<?php
{{License}}
/**
 * {{EntityLabel}} resource model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}} extends Mage_Core_Model_Mysql4_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function _construct(){
		$this->_init('{{module}}/{{entity}}', 'entity_id');
	}
}