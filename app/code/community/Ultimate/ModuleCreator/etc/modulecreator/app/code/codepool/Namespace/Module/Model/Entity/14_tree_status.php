	/**
	 * check if parents are enabled
	 * @access public
	 * @return bool
	 * {{qwertyuiop}}
	 */
	public function getStatusPath(){
		$parents = $this->getParent{{Entities}}();
		foreach ($parents as $parent){
			if (!$parent->getStatus()){
				return false;
			}
		}
		return $this->getStatus();
	}
