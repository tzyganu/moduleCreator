<?php 
{{License}}
/**
 * {{EntityLabel}} - {{SiblingLabel}} relation model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_{{Sibling}} extends Mage_Core_Model_Mysql4_Abstract{
/**
	 * initialize resource model
	 * @access protected
	 * @return void
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 * {{qwertyuiop}}
	 */
	protected function  _construct(){
		$this->_init('{{module}}/{{entity}}_{{sibling}}', 'rel_id');
	}
	/**
	 * Save {{entity}} - {{sibling}} relations
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}} ${{entity}}
	 * @param array $data
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_{{Sibling}}
	 * {{qwertyuiop}}
	 */
	public function save{{Entity}}Relation(${{entity}}, $data){
		if (!is_array($data)) {
			$data = array();
		}
		$deleteCondition = $this->_getWriteAdapter()->quoteInto('{{entity}}_id=?', ${{entity}}->getId());
		$this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

		foreach ($data as ${{sibling}}Id => $info) {
			$this->_getWriteAdapter()->insert($this->getMainTable(), array(
				'{{entity}}_id'  	=> ${{entity}}->getId(),
				'{{sibling}}_id' 	=> ${{sibling}}Id,
				'position'  	=> @$info['position']
			));
		}
		return $this;
	}
}