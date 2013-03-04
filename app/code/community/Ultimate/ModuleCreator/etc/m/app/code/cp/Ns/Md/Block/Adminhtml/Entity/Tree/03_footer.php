		$item['allowDrop'] = true;
		$item['allowDrag'] = true;
		if ((int)$node->getChildrenCount()>0) {
			$item['children'] = array();
		}
		$isParent = $this->_isParentSelected{{Entity}}($node);
		if ($node->hasChildren()) {
			$item['children'] = array();
			if (!($this->getUseAjax() && $node->getLevel() > 1 && !$isParent)) {
				foreach ($node->getChildren() as $child) {
					$item['children'][] = $this->_getNodeJson($child, $level+1);
				}
			}
		}
		if ($isParent || $node->getLevel() < 1) {
			$item['expanded'] = true;
		}
		return $item;
	}
	/**
	 * Get node label
	 * @access public
	 * @param Varien_Object $node
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function buildNodeName($node){
		$result = $this->htmlEscape($node->get{{EntityNameMagicCode}}());
		return $result;
	}
	/**
	 * check if entity is movable
	 * @access protected
	 * @param Varien_Object $node
	 * @return bool
	 * {{qwertyuiop}}
	 */
	protected function _is{{Entity}}Moveable($node){
		return true;
	}
	/**
	 * check if parent is selected
	 * @access protected
	 * @param Varien_Object $node
	 * @return bool
	 * {{qwertyuiop}}
	 */
	protected function _isParentSelected{{Entity}}($node){
		if ($node && $this->get{{Entity}}()) {
			$pathIds = $this->get{{Entity}}()->getPathIds();
			if (in_array($node->getId(), $pathIds)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Check if page loaded by outside link to {{entityLabel}} edit
	 * @access public
	 * @return boolean
	 * {{qwertyuiop}}
	 */
	public function isClearEdit(){
		return (bool) $this->getRequest()->getParam('clear');
	}
	/**
	 * Check availability of adding root {{entityLabel}}
	 * @access public
	 * @return boolean
	 * {{qwertyuiop}}
	 */
	public function canAddRoot{{Entity}}(){
		return true;
	}
	/**
	 * Check availability of adding child {{entityLabel}}
	 * @access public
	 * @return boolean
	 */
	public function canAddChild(){
		return true;
	}
}