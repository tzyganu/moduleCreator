		$this->addColumn('status', array(
			'header'	=> Mage::helper('{{module}}')->__('Status'),
			'index'		=> 'status',
			'type'		=> 'options',
			'options'	=> array(
				'1' => Mage::helper('{{module}}')->__('Enabled'),
				'0' => Mage::helper('{{module}}')->__('Disabled'),
			)
		));
