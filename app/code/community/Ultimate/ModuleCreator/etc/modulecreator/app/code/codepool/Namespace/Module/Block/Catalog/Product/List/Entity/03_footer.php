				->addProductFilter($product);
			$collection->getSelect()->order('position', 'ASC');
			$this->setData('{{entity}}_collection', $collection);
		}
		return $this->getData('{{entity}}_collection');
	}
}