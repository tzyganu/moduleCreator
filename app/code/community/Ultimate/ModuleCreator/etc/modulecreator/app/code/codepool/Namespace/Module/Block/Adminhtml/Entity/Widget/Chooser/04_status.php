		$this->addColumn('chooser_status', array(
			'header'=> Mage::helper('{{module}}')->__('Status'),
			'index' => 'status',
			'type'  => 'options',
			'options'   => array(
				0 => Mage::helper('{{module}}')->__('Disabled'),
				1 => Mage::helper('{{module}}')->__('Enabled')
			),
		));
