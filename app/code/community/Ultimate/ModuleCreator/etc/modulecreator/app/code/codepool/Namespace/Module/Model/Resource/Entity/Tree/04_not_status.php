	/**
	 * add collection data
	 * @access public
	 * @param {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection $collection
	 * @param boolean $sorted
	 * @param array $exclude
	 * @param boolean $toLoad
	 * @return {{Namespace}}_{{Module}}_Model_Resource_Category_Tree
	 * {{qwertyuiop}}
	 */
	public function addCollectionData($collection = null, $sorted = false, $exclude = array(), $toLoad = true){
		if (is_null($collection)) {
			$collection = $this->getCollection($sorted);
		} else {
			$this->setCollection($collection);
		}
		if (!is_array($exclude)) {
			$exclude = array($exclude);
		}
		$nodeIds = array();
		foreach ($this->getNodes() as $node) {
			if (!in_array($node->getId(), $exclude)) {
				$nodeIds[] = $node->getId();
			}
		}
		$collection->addIdFilter($nodeIds);
		if ($toLoad) {
			$collection->load();
			foreach ($collection as ${{entity}}) {
				if ($this->getNodeById(${{entity}}->getId())) {
					$this->getNodeById(${{entity}}->getId())->addData(${{entity}}->getData());
				}
			}
			foreach ($this->getNodes() as $node) {
				if (!$collection->getItemById($node->getId()) && $node->getParent()) {
					$this->removeNode($node);
				}
			}
		}
		return $this;
	}
