		$this->addTab('form_meta_section', array(
			'label'		=> Mage::helper('{{module}}')->__('Meta'),
			'title'		=> Mage::helper('{{module}}')->__('Meta'),
			'content' 	=> $this->getLayout()->createBlock('{{module}}/adminhtml_{{entity}}_edit_tab_meta')->toHtml(),
		));
