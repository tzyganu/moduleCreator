	/**
	 * Add active {{entityLabel}} filter
	 * @access public
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 */
	public function addStatusFilter(){
		$this->addFieldToFilter('status', 1);
		return $this;
	}
