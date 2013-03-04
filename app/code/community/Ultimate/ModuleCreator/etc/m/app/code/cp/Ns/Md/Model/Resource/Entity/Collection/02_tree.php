	/**
	 * Add Id filter
	 * @access public
	 * @param array ${{entity}}Ids
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addIdFilter(${{entity}}Ids){
		if (is_array(${{entity}}Ids)) {
			if (empty(${{entity}}Ids)) {
				$condition = '';
			} 
			else {
				$condition = array('in' => ${{entity}}Ids);
			}
		} 
		elseif (is_numeric(${{entity}}Ids)) {
			$condition = ${{entity}}Ids;
		} 
		elseif (is_string(${{entity}}Ids)) {
			$ids = explode(',', ${{entity}}Ids);
			if (empty($ids)) {
				$condition = ${{entity}}Ids;
			} 
			else {
				$condition = array('in' => $ids);
			}
		}
		$this->addFieldToFilter('entity_id', $condition);
		return $this;
	}
	/**
	 * Add {{entityLabel}} path filter
	 * @access public
	 * @param string $regexp
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addPathFilter($regexp){
		$this->addFieldToFilter('path', array('regexp' => $regexp));
		return $this;
	}

	/**
	 * Add {{entityLabel}} path filter
	 * @access public
	 * @param array|string $paths
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addPathsFilter($paths){
		if (!is_array($paths)) {
			$paths = array($paths);
		}
		$write  = $this->getResource()->getWriteConnection();
		$cond   = array();
		foreach ($paths as $path) {
			$cond[] = $write->quoteInto('e.path LIKE ?', "$path%");
		}
		if ($cond) {
			$this->getSelect()->where(join(' OR ', $cond));
		}
		return $this;
	}
	/**
	 * Add {{entityLabel}} level filter
	 * @access public
	 * @param int|string $level
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function addLevelFilter($level){
		$this->addFieldToFilter('level', array('lteq' => $level));
		return $this;
	}
	/**
	 * Add root {{entityLabel}} filter
	 * @access public
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 */
	public function addRootLevelFilter(){
		$this->addFieldToFilter('path', array('neq' => '1'));
		$this->addLevelFilter(1);
		return $this;
	}
	/**
	 * Add order field
	 * @access public
	 * @param string $field
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 */
	public function addOrderField($field){
		$this->setOrder($field, self::SORT_ORDER_ASC);
		return $this;
	}
