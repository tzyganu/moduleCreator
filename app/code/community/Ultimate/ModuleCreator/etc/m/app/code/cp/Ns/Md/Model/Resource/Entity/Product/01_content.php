<?php 
{{License}}
/**
 * {{EntityLabel}} - product relation model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Product extends Mage_Core_Model_Resource_Db_Abstract{
/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * {{qwertyuiop}}
	 */
	protected function  _construct(){
		$this->_init('{{module}}/{{entity}}_product', 'rel_id');
	}
	/**
	 * Save {{entity}} - product relations
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @param array $data
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Product
	 * {{qwertyuiop}}
	 */
	public function save{{Entity}}Relation(${{entity}}, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('{{entity}}_id=?', ${{entity}}->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as $productId => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'{{entity}}_id'  	=> ${{entity}}->getId(),
				'product_id' 	=> $productId,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}
	/**
	 * Save  product - {{entity}} relations
	 * @access public
	 * @param Mage_Catalog_Model_Product $prooduct
	 * @param array $data
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Product
	 * @{{qwertyuiop}}
	 */
	public function saveProductRelation($product, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);
		
		foreach ($data as ${{entity}}Id => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'{{entity}}_id' => ${{entity}}Id,
				'product_id' => $product->getId(),
				'position'   => @$info['position']
			));
		}
		return $this;
	}
}