		if (!Mage::app()->isSingleStoreMode()){
			$this->addTab('form_store_section', array(
				'label'		=> Mage::helper('{{module}}')->__('Store views'),
				'title'		=> Mage::helper('{{module}}')->__('Store views'),
				'content' 	=> $this->getLayout()->createBlock('{{module}}/adminhtml_{{entity}}_edit_tab_stores')->toHtml(),
			));
		}
