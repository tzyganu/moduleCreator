		$activeChildren = array();
		if ($recursion == 0 || $level < $recursion-1){
			foreach ($children as $child) {
				$childStoreIds = Mage::getResourceSingleton('{{module}}/{{entity}}')->lookupStoreIds($child->getId());
				$validStoreIds = array(0, Mage::app()->getStore()->getId());
				if (!array_intersect($childStoreIds, $validStoreIds)){
					continue;
				}
				if ($child->getStatus()) {
					$activeChildren[] = $child;
				}
			}
		}
