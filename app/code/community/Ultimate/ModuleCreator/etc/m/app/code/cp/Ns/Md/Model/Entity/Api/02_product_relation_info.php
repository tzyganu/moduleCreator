		//related products
		$result['products'] = array();
		$relatedProductsCollection = ${{entity}}->getSelectedProductsCollection();
		foreach ($relatedProductsCollection as $product) {
			$result['products'][$product->getId()] = $product->getPosition();
		}
