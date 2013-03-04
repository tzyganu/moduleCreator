<?php
{{License}}
/**
 * {{EntityLabel}} admin block
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}} extends Mage_Adminhtml_Block_Widget_Grid_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function __construct(){
		$this->_controller 		= 'adminhtml_{{entity}}';
		$this->_blockGroup 		= '{{module}}';
		$this->_headerText 		= Mage::helper('{{module}}')->__('{{EntityLabel}}');
		$this->_addButtonLabel 	= Mage::helper('{{module}}')->__('Add {{EntityLabel}}');
		parent::__construct();
	}
}