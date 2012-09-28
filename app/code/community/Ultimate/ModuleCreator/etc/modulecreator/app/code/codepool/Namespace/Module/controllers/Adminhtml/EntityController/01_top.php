<?php
{{License}}
/**
 * {{EntityLabel}} admin controller
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Adminhtml_{{Entity}}Controller extends {{Namespace}}_{{Module}}_Controller_Adminhtml_{{Module}}{
 	/**
	 * default action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function indexAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function gridAction() {
		$this->loadLayout()->renderLayout();
	}
	/**
	 * edit {{entityLabel}} - action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function editAction() {
		${{entity}}Id	= $this->getRequest()->getParam('id');
		${{entity}}  	= Mage::getModel('{{module}}/{{entity}}')->load(${{entity}}Id);
		if (${{entity}}Id && !${{entity}}->getId()) {
			$this->_getSession()->addError(Mage::helper('{{module}}')->__('This {{entityLabel}} no longer exists.'));
			$this->_redirect('*/*/');
			return;
		}
		$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		if (!empty($data)) {
			${{entity}}->setData($data);
		}
		Mage::register('{{entity}}_data', ${{entity}});
		$this->loadLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) { 
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true); 
		}
		$this->renderLayout();
	}
	/**
	 * new {{entityLabel}} action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function newAction() {
		$this->_forward('edit');
	}
	/**
	 * save {{entityLabel}} - action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			try {
				${{entity}} = Mage::getModel('{{module}}/{{entity}}');		
				${{entity}}->setData($data)->setId($this->getRequest()->getParam('id'));
