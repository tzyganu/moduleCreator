		return parent::_prepareColumns();
	}
	/**
	 * get url for grid
	 * @access public
	 * @return string
	 * (non-PHPdoc)
	 * @see Mage_Adminhtml_Block_Widget_Grid::getGridUrl()
	 * {{qwertyuiop}}
	 */
	public function getGridUrl(){
		return $this->getUrl('adminhtml_{{entity}}_widget/chooser', array('_current' => true));
	}
}