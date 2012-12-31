<?php
{{License}}
/**
 * {{EntityLabel}} - product controller
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */ 
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class {{Namespace}}_{{Module}}_Adminhtml_{{Module}}_{{Entity}}_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController{
	/**
	 * {{entitiesLabel}} action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{entities}}Action(){
		$this->_initProduct();
		$this->loadLayout();
		$this->renderLayout();
	}
	/**
	 * {{entitiesLabel}} json action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function {{entities}}JsonAction(){
		$product = $this->_initProduct();
		$this->getResponse()->setBody(
		$this->getLayout()->createBlock('{{module}}/adminhtml_catalog_product_edit_tab_{{entity}}')
			->get{{Entity}}ChildrenJson($this->getRequest()->getParam('{{entity}}'))
		);
	}
}
