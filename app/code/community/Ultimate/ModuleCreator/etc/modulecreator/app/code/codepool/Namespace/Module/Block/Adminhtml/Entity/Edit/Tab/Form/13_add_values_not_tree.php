		if (Mage::getSingleton('adminhtml/session')->get{{Entity}}Data()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->get{{Entity}}Data());
			Mage::getSingleton('adminhtml/session')->set{{Entity}}Data(null);
		}
		elseif (Mage::registry('current_{{entity}}')){
			$form->setValues(Mage::registry('current_{{entity}}')->getData());
		}
		return parent::_prepareForm();
	}
