	/**
	 * mass status change - action
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function massStatusAction(){
		${{entity}}Ids = $this->getRequest()->getParam('{{entity}}');
		if(!is_array(${{entity}}Ids)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('{{module}}')->__('Please select {{entitiesLabel}}.'));
		} 
		else {
			try {
				foreach (${{entity}}Ids as ${{entity}}Id) {
				${{entity}} = Mage::getSingleton('{{module}}/{{entity}}')->load(${{entity}}Id)
							->setStatus($this->getRequest()->getParam('status'))
							->setIsMassupdate(true)
							->save();
				}
				$this->_getSession()->addSuccess($this->__('Total of %d {{entitiesLabel}} were successfully updated.', count(${{entity}}Ids)));
			}
			catch (Mage_Core_Exception $e){
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('{{module}}')->__('There was an error updating {{entitiesLabel}}.'));
				Mage::logException($e);
			}
		}
		$this->_redirect('*/*/index');
	}
