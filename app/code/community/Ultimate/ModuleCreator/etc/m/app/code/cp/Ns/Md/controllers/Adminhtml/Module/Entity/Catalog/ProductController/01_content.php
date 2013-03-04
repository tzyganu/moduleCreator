<?php
{{License}}
/**
 * {{Entity}} product admin controller
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class {{Namespace}}_{{Module}}_Adminhtml_{{Module}}_{{Entity}}_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * construct
	 * @access protected
	 * @return void
	 * {{qwertyuiop}}
	 */
	protected function _construct(){
		// Define module dependent translate
		$this->setUsedModuleName('{{Namespace}}_{{Module}}');
	}
	/**
	 * {{entities}} in the catalog page
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{entities}}Action(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.{{entity}}')
			->setProduct{{Entities}}($this->getRequest()->getPost('product_{{entities}}', null));
		$this->renderLayout();
	}
	/**
	 * {{entities}} grid in the catalog page
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{entities}}GridAction(){
		$this->_initProduct();
		$this->loadLayout();
		$this->getLayout()->getBlock('product.edit.tab.{{entity}}')
			->setProduct{{Entities}}($this->getRequest()->getPost('product_{{entities}}', null));
		$this->renderLayout();
	}
}