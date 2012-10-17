	/**
	 * add the product filter to collection
	 * @access public
	 * @param mixed (Mage_Catalog_Model_Product|int) $product
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addProductFilter($product){
		if ($product instanceof Mage_Catalog_Model_Product){
			$product = $product->getId();
		}
		if (!$this->_joinedFields){
			$this->getSelect()->join(
				array('related' => $this->getTable('{{module}}/{{entity}}_product')),
				'related.{{entity}}_id = main_table.entity_id',
				array('position')
			);
			$this->getSelect()->where('related.product_id = ?', $product);
			$this->_joinedFields = true;
		}
		return $this;
	}
