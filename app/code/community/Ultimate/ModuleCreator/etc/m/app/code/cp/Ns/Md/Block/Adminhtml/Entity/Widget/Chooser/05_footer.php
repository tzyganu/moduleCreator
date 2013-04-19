		return parent::_prepareColumns();
	}
	/**
	 * get url for grid
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getGridUrl(){
		return $this->getUrl('adminhtml/{{module}}_{{entity}}_widget/chooser', array('_current' => true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Widget_Chooser
	 * {{qwertyuiop}}
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
}