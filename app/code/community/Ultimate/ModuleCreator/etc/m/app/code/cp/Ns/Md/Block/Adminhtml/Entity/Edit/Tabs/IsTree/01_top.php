<?php
{{License}}
/**
 * {{EntityLabel}} admin edit tabs
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs{
	/**
	 * Initialize Tabs
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
 	*/
	public function __construct(){
		parent::__construct();
		$this->setId('{{entity}}_info_tabs');
		$this->setDestElementId('{{entity}}_tab_content');
		$this->setTitle(Mage::helper('{{module}}')->__('{{EntityLabel}}'));
		$this->setTemplate('widget/tabshoriz.phtml');
	}
	/**
	 * Retrieve {{entityLabel}} entity
	 * @access public
	 * @return {{Namespace}}_{{Module}}_Model_{{Entity}}
	 * {{qwertyuiop}}
	 */
	public function get{{Entity}}(){
		return Mage::registry('current_{{entity}}');
	}
	/**
	 * Prepare Layout Content
	 * @access public 
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Edit_Tabs
	 */
	protected function _prepareLayout(){
		$this->addTab('form_{{entity}}', array(
			'label'		=> Mage::helper('{{module}}')->__('{{EntityLabel}}'),
			'title'		=> Mage::helper('{{module}}')->__('{{EntityLabel}}'),
			'content' 	=> $this->getLayout()->createBlock('{{module}}/adminhtml_{{entity}}_edit_tab_form')->toHtml(),
		));
