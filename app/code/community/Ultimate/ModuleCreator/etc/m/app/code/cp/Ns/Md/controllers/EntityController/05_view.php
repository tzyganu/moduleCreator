	/**
 	 * view {{entityLabel}} action
 	 * @access public
 	 * @return void
 	 * {{qwertyuiop}}
 	 */
	public function viewAction(){
		${{entity}}Id 	= $this->getRequest()->getParam('id', 0);
		${{entity}} 	= Mage::getModel('{{module}}/{{entity}}')
						->setStoreId(Mage::app()->getStore()->getId())
						->load(${{entity}}Id);
		if (!${{entity}}->getId()){
			$this->_forward('no-route');
		}
