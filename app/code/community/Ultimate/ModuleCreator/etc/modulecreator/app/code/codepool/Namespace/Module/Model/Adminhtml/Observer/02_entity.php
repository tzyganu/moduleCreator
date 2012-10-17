	/**
	 * add the {{entity}} tab to products
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return {{Namespace}}_{{Module}}_Model_Adminhtml_Observer
	 * {{qwertyuiop}}
	 */
	public function add{{Entity}}Block($observer){
		$block = $observer->getEvent()->getBlock();
		$product = Mage::registry('product');
		if ($block instanceof Mage_Adminhtml_Block_Catalog_Product_Edit_Tabs && $product->getAttributeSetId()){
			$block->addTab('{{entities}}', array(
				'label' => Mage::helper('{{module}}')->__('{{Entities}}'),
				'url'   => Mage::helper('adminhtml')->getUrl('adminhtml/{{entity}}_catalog_product/{{entities}}', array('_current' => true)),
				'class' => 'ajax',
			));
		}
		return $this;
	}
	/**
	 * save {{entity}} - product relation
	 * @access public
	 * @param Varien_Event_Observer $observer
	 * @return {{Namespace}}_{{Module}}_Model_Adminhtml_Observer
	 * {{qwertyuiop}}
	 */
	public function save{{Entity}}Data($observer){
		$post = Mage::app()->getRequest()->getPost('{{entities}}', -1);
		if ($post != '-1') {
			$post = Mage::helper('adminhtml/js')->decodeGridSerializedInput($post);
			$product = Mage::registry('product');
			${{entity}}Product = Mage::getResourceSingleton('{{module}}/{{entity}}_product')->saveProductRelation($product, $post);
		}
		return $this;
	}
