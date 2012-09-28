		$this->getMassactionBlock()->addItem('status', array(
			'label'=> Mage::helper('{{module}}')->__('Change status'),
			'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
			'additional' => array(
				'status' => array(
						'name' => 'status',
						'type' => 'select',
						'class' => 'required-entry',
						'label' => Mage::helper('{{module}}')->__('Status'),
						'values' => array(
								'1' => Mage::helper('{{module}}')->__('Enabled'),
								'0' => Mage::helper('{{module}}')->__('Disabled'),
						)
				)
			)
		));
