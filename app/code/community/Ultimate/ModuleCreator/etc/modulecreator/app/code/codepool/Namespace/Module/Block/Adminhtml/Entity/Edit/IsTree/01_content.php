<?php
{{License}}
/**
 * {{EntityLabel}} admin edit form
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function __construct(){
		$this->_objectId	= 'entity_id';
		$this->_blockGroup	= '{{module}}';
		$this->_controller  = 'adminhtml_{{entity}}';
		$this->_mode		= 'edit';
		parent::__construct();
		$this->setTemplate('{{namespace}}_{{module}}/{{entity}}/edit.phtml');
	}
}
