		${{siblings}} = Mage::getResourceModel('{{module}}/{{sibling}}_collection')->toOptionHash();
		$this->addColumn('{{sibling}}_id', array(
			'header'	=> Mage::helper('{{module}}')->__('{{SiblingLabel}}'),
			'index'		=> '{{sibling}}_id',
			'type'		=> 'options',
			'options'	=> ${{siblings}}
		));
