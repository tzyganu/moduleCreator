	/**
	 * get the url to the {{entityLabel}} details page
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function get{{Entity}}Url(){
		if ($this->getUrlKey()){
			return Mage::getUrl('', array('_direct'=>$this->getUrlKey()));
		}
		return Mage::getUrl('{{module}}/{{entity}}/view', array('id'=>$this->getId()));
	}
	/**
	 * check URL key
	 * @access public
	 * @param string $urlKey
	 * @return mixed
	 * {{qwertyuiop}}
	 */
	public function checkUrlKey($urlKey){
		return $this->_getResource()->checkUrlKey($urlKey);
	}
