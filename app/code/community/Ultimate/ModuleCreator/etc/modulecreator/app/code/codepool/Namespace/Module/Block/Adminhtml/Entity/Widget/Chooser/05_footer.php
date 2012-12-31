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
}