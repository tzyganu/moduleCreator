		$activeChildren = array();
		foreach ($children as $child) {
			if ($child->getStatus()) {
				$activeChildren[] = $child;
			}
		}
