	/**
	 * prepare grid collection
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Grid
	 * {{qwertyuiop}}
	 */
	protected function _prepareColumns(){
		$this->addColumn('entity_id', array(
			'header'	=> Mage::helper('{{module}}')->__('Id'),
			'index'		=> 'entity_id',
			'type'		=> 'number'
		));
