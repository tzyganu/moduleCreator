<?php
{{License}}
/**
 * {{EntityLabel}} tree resource model
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Tree extends Varien_Data_Tree_Dbp{
	const ID_FIELD		= 'entity_id';
	const PATH_FIELD  	= 'path';
	const ORDER_FIELD 	= 'order';
	const LEVEL_FIELD 	= 'level';
	/**
	 * {{EntitiesLabel}} resource collection
	 * @var {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 */
	protected $_collection;
