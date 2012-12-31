<?php
{{License}}
/**
 * {{EntityLabel}} admin tree block
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Tree extends {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function __construct(){
		parent::__construct();
		$this->setTemplate('{{namespace}}_{{module}}/{{entity}}/tree.phtml');
		$this->setUseAjax(true);
		$this->_withProductCount = true;
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Block_Adminhtml_{{Entity}}_Tree
	 * {{qwertyuiop}}
	 */
	protected function _prepareLayout(){
		$addUrl = $this->getUrl("*/*/add", array(
			'_current'=>true,
			'id'=>null,
			'_query' => false
		));
		
		$this->setChild('add_sub_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('{{module}}')->__('Add Child {{EntityLabel}}'),
					'onclick'   => "addNew('".$addUrl."', false)",
					'class' => 'add',
					'id'=> 'add_child_{{entity}}_button',
					'style' => $this->canAddChild() ? '' : 'display: none;'
				))
		);
		
		$this->setChild('add_root_button',
			$this->getLayout()->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('{{module}}')->__('Add Root {{EntityLabel}}'),
					'onclick'   => "addNew('".$addUrl."', true)",
					'class' => 'add',
					'id'=> 'add_root_{{entity}}_button'
				))
		);
		return parent::_prepareLayout();
	}
	/**
	 * get the {{entityLabel}} collection
	 * @access public
	 * @return {{Namespace}}_{{Module}}_Model_Resource_{{Entity}}_Collection
	 * {{qwertyuiop}}
	 */
	public function get{{Entity}}Collection(){
		$collection = $this->getData('{{entity}}_collection');
		if (is_null($collection)) {
			$collection = Mage::getModel('{{module}}/{{entity}}')->getCollection();
			$this->setData('{{entity}}_collection', $collection);
		}
		return $collection;
	}
	/**
	 * get html for add root button
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getAddRootButtonHtml(){
		return $this->getChildHtml('add_root_button');
	}
	/**
	 * get html for add child button
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getAddSubButtonHtml(){
		return $this->getChildHtml('add_sub_button');
	}
	/**
	 * get html for expand button
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getExpandButtonHtml(){
		return $this->getChildHtml('expand_button');
	}
	/**
	 * get html for add collapse button
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getCollapseButtonHtml(){
		return $this->getChildHtml('collapse_button');
	}
	/**
	 * get url for tree load
	 * @access public
	 * @param mxed $expanded
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getLoadTreeUrl($expanded=null){
		$params = array('_current'=>true, 'id'=>null,'store'=>null);
		if ((is_null($expanded) && Mage::getSingleton('admin/session')->get{{Entity}}IsTreeWasExpanded())|| $expanded == true) {
			$params['expand_all'] = true;
		}
		return $this->getUrl('*/*/{{entities}}Json', $params);
	}
	/**
	 * get url for loading nodes
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getNodesUrl(){
		return $this->getUrl('*/{{module}}_{{entities}}/jsonTree');
	}
	/**
	 * check if tree is expanded
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getIsWasExpanded(){
		return Mage::getSingleton('admin/session')->get{{Entity}}IsTreeWasExpanded();
	}
	/**
	 * get url for moving {{entityLabel}}
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getMoveUrl(){
		return $this->getUrl('*/{{module}}_{{entity}}/move');
	}
	/**
	 * get the tree as json
	 * @access public
	 * @param mixed $parentNode{{Entity}}
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getTree($parentNode{{Entity}} = null){
		$rootArray = $this->_getNodeJson($this->getRoot($parentNode{{Entity}}));
		$tree = isset($rootArray['children']) ? $rootArray['children'] : array();
		return $tree;
	}
	/**
	 * get the tree as json
	 * @access public
	 * @param mixed $parentNode{{Entity}}
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getTreeJson($parentNode{{Entity}} = null){
		$rootArray = $this->_getNodeJson($this->getRoot($parentNode{{Entity}}));
		$json = Mage::helper('core')->jsonEncode(isset($rootArray['children']) ? $rootArray['children'] : array());
		return $json;
	}

	/**
	 * Get JSON of array of {{entitiesLabel}}, that are breadcrumbs for specified {{entityLabel}} path
	 * @access public
	 * @param string $path
	 * @param string $javascriptVarName
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getBreadcrumbsJavascript($path, $javascriptVarName){
		if (empty($path)) {
			return '';
		}
	
		${{entities}} = Mage::getResourceSingleton('{{module}}/{{entity}}_tree')->loadBreadcrumbsArray($path);
		if (empty(${{entities}})) {
			return '';
		}
		foreach (${{entities}} as $key => ${{entity}}) {
			${{entities}}[$key] = $this->_getNodeJson(${{entity}});
		}
		return
			'<script type="text/javascript">'
			. $javascriptVarName . ' = ' . Mage::helper('core')->jsonEncode(${{entities}}) . ';'
			. ($this->canAddChild() ? '$("add_child_{{entity}}_button").show();' : '$("add_child_{{entity}}_button").hide();')
			. '</script>';
	}

	/**
	 * Get JSON of a tree node or an associative array
	 * @access protected
	 * @param Varien_Data_Tree_Node|array $node
	 * @param int $level
	 * @return string
	 * {{qwertyuiop}}
	 */
	protected function _getNodeJson($node, $level = 0){
		// create a node from data array
		if (is_array($node)) {
			$node = new Varien_Data_Tree_Node($node, 'entity_id', new Varien_Data_Tree);
		}
		$item = array();
		$item['text'] 	= $this->buildNodeName($node);
		$rootForStores 	= in_array($node->getEntityId(), $this->getRootIds());
		$item['id']  	= $node->getId();
		$item['path'] 	= $node->getData('path');
		$item['cls'] 	= 'folder';
