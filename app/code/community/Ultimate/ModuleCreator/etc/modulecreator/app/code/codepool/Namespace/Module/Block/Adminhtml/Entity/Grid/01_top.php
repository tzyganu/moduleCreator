<?php
{{License}}
/**
 * {{EntityLabel}} admin grid block
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Grid extends Mage_Adminhtml_Block_Widget_Grid{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function __construct(){
		parent::__construct();
		$this->setId('{{entity}}Grid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}
	/**
	 * prepare collection
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Grid
	 * {{qwertyuiop}}
	 */
	protected function _prepareCollection(){
		$collection = Mage::getModel('{{module}}/{{entity}}')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
