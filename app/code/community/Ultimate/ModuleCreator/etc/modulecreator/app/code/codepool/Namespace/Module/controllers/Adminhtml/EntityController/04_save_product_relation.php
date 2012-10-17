				if (isset($data['products'])) {
					${{entity}}->setProductsData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($data['products']));
					${{entity}}->unsData('products');
				}
