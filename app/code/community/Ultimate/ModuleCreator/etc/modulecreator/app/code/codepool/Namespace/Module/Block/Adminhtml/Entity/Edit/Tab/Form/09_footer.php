		if (Mage::getSingleton('adminhtml/session')->get{{Entity}}Data()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->get{{Entity}}Data());
			Mage::getSingleton('adminhtml/session')->set{{Entity}}Data(null);
		}
		elseif (Mage::registry('{{entity}}_data')){
			$form->setValues(Mage::registry('{{entity}}_data')->getData());
		}
		return parent::_prepareForm();
	}
}