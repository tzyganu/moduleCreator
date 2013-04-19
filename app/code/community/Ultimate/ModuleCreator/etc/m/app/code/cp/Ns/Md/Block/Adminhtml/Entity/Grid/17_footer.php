		return $this;
	}
	/**
	 * get the row url
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_{{Entity}}
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getRowUrl($row){
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
	/**
	 * get the grid url
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getGridUrl(){
		return $this->getUrl('*/*/grid', array('_current'=>true));
	}
	/**
	 * after collection load
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Grid
	 * {{qwertyuiop}}
	 */
	protected function _afterLoadCollection(){
		$this->getCollection()->walk('afterLoad');
		parent::_afterLoadCollection();
	}
	/**
	 * filter store column
	 * @access protected
	 * @param {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection $collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Grid
	 * {{qwertyuiop}}
	 */
	protected function _filterStoreCondition($collection, $column){
		if (!$value = $column->getFilter()->getValue()) {
        	return;
		}
		$collection->addStoreFilter($value);
		return $this;
    }
}