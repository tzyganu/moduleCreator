		;
		${{entities}}->getSelect()->order('main_table.position');
		$this->set{{Entities}}(${{entities}});
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_{{Entity}}_List
	 * {{qwertyuiop}}
	 */
	protected function _prepareLayout(){
		parent::_prepareLayout();
		$this->get{{Entities}}()->addFieldToFilter('level', 1);
		if ($this->_getDisplayMode() == 0){
			$pager = $this->getLayout()->createBlock('page/html_pager', '{{module}}.{{entities}}.html.pager')
				->setCollection($this->get{{Entities}}());
			$this->setChild('pager', $pager);
			$this->get{{Entities}}()->load();
		}
		return $this;
	}
	/**
	 * get the pager html
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	/**
	 * get the display mode
	 * @access protected
	 * @return int
	 * {{qwertyuiop}}
	 */
	protected function _getDisplayMode(){
		return Mage::getStoreConfigFlag('{{module}}/{{entity}}/tree');
	}
	/**
	 * draw {{entityLabel}}
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}}
	 * @param int $level
	 * @return int
	 * {{qwertyuiop}}
	 */
	public function draw{{Entity}}(${{entity}}, $level = 0){
		$html = '';
		$recursion = $this->getRecursion();
		if ($recursion !== '0' && $level >= $recursion){
			return '';
		}
		$storeIds = Mage::getResourceSingleton('{{module}}/{{entity}}')->lookupStoreIds(${{entity}}->getId());
		$validStoreIds = array(0, Mage::app()->getStore()->getId());
		if (!array_intersect($storeIds, $validStoreIds)){
			continue;
		}
