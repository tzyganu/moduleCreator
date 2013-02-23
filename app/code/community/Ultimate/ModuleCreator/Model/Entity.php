<?php 
/**
 * Ultimate_ModuleCreator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE_UMC.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   	Ultimate
 * @package		Ultimate_ModuleCreator
 * @copyright  	Copyright (c) 2012
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */ 
/**
 * entity model
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Entity extends Ultimate_ModuleCreator_Model_Abstract{
	/**
	 * entity attributes
	 * @var array
	 */
	protected $_attribtues 			= array();
	/**
	 * entity module
	 * @var Ultimate_ModuleCreator_Model_Module
	 */
	protected $_module 				= null;
	/**
	 * attribute that behaves as name
	 * @var Ultimate_ModuleCreator_Model_Attribute
	 */
	protected $_nameAttribute 		= null;
	/**
	 * remember if attributes were prepared
	 * @var bool
	 */
	protected $_preparedAttributes 	= null;
	/**
	 * related entities
	 * @var array()
	 */
	protected $_relatedEntities 	= array();
	/**
	 * set the entity module
	 * @access public
	 * @param Ultimate_ModuleCreator_Model_Module $module
	 * @return Ultimate_ModuleCreator_Model_Entity
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function setModule(Ultimate_ModuleCreator_Model_Module $module){
		$this->_module = $module;
		return $this;
	}
	/**
	 * get the entity module
	 * @access public
	 * @return mixed (Ultimate_ModuleCreator_Model_Module|null)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getModule(){
		return $this->_module;
	}
	/**
	 * add new attribute
	 * @access public
	 * @param Ultimate_ModuleCreator_Model_Attribute $attribute
	 * @return Ultimate_ModuleCreator_Model_Entity
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addAttribute(Ultimate_ModuleCreator_Model_Attribute $attribute){
		$attribute->setEntity($this);
		if (isset($this->_attribtues[$attribute->getCode()])){
			throw new Ultimate_ModuleCreator_Exception(Mage::helper('modulecreator')->__('An attribute with the code "%s" already exists for entity "%s"', $attribute->getCode(), $this->getNameSingular()));
		}
		$this->_preparedAttributes = false;
		$this->_attribtues[$attribute->getCode()] = $attribute;
		$allowedTypes = array('text'=>'Text', 'int'=>'Integer', 'decimal'=>'Decimal');
		if ($attribute->getIsName()){
			if (!in_array($attribute->getType(), array_keys($allowedTypes))){
				throw new Ultimate_ModuleCreator_Exception(Mage::helper('modulecreator')->__('An attribute that acts as name must have the type %s.', implode(', ', array_values($allowedTypes))));
			}
			$this->_nameAttribute = $attribute;
		}
		if ($attribute->getEditor()){
			$this->setEditor(true);
		}
		return $this;
	}
	/**
	 * prepare attributes 
	 * @access protected
	 * @return Ultimate_ModuleCreator_Model_Entity
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _prepareAttributes(){
		if ($this->_preparedAttributes){
			return $this;
		}
		$attributesByPosition = array();
		foreach ($this->_attribtues as $key=>$attribute){
			$attributesByPosition[$attribute->getPosition()][] = $attribute;
		}
		ksort($attributesByPosition);
		$attributes = array();
		foreach ($attributesByPosition as $position=>$attributeList){
			foreach ($attributeList as $attribute){
				$attributes[$attribute->getCode()] = $attribute;
			}
		}
		$this->_attribtues = $attributes;
		$this->_preparedAttributes = true;
		return $this;
	}
	/**
	 * ge the entity attribtues
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttributes(){
		if (!$this->_preparedAttributes){
			$this->_prepareAttributes();
		}
		return $this->_attribtues;
	}
	/**
	 * entity to xml
	 * @access protected
	 * @param array $arrAttributes
	 * @param string $rootName
	 * @param bool $addOpenTag
	 * @param bool $addCdata
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function __toXml(array $arrAttributes = array(), $rootName = 'entity', $addOpenTag=false, $addCdata=false){
		$xml = '';
		if ($addOpenTag) {
			$xml.= '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		}
		if (!empty($rootName)) {
			$xml.= '<'.$rootName.'>'."\n";
		}
		$start = '';
		$end = '';
		if ($addCdata){
			$start = '<![CDATA[';
			$end = ']]>';
		}
		$xml .= parent::__toXml($this->getXmlAttributes(), '', false, $addCdata);
		$xml .= '<attributes>';
		foreach ($this->getAttributes() as $attribute){
			$xml .= $attribute->toXml(array(), 'attribute', false, $addCdata);
		}
		$xml .= '</attributes>';
		if (!empty($rootName)) {
			$xml.= '</'.$rootName.'>'."\n";
		}
		return $xml;
	}
	/**
	 * get the attributes saved in the xml
	 * @access public
	 * @return array();
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getXmlAttributes(){
		return array('label_singular', 'label_plural', 'name_singular', 'name_plural', 'created_to_grid', 
					'updated_to_grid', 'add_status', 'use_frontend', 'frontend_list', 
					'frontend_list_template', 'frontend_view', 'frontend_view_template', 'frontend_add_seo',
					'rss', 'widget', 'link_product', 'show_on_product', 'show_products','is_tree', 'url_rewrite'
		);
	}
	/**
	 * get the placeholders for an entity
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPlaceholders(){
		$placeholders = array();
		$placeholders['{{EntityLabel}}'] 				= ucfirst($this->getLabelSingular());
		$placeholders['{{entityLabel}}'] 				= strtolower($this->getLabelSingular());
		$placeholders['{{EntitiesLabel}}'] 				= ucfirst($this->getLabelPlural());
		$placeholders['{{entitiesLabel}}'] 				= strtolower($this->getLabelPlural());
		$placeholders['{{entity}}'] 					= strtolower($this->getNameSingular());
		$placeholders['{{Entity}}'] 					= ucfirst($this->getNameSingular());
		$placeholders['{{ENTITY}}'] 					= strtoupper($this->getNameSingular());
		$placeholders['{{Entities}}'] 					= ucfirst($this->getNamePlural());
		$placeholders['{{entities}}'] 					= $this->getNamePlural();
		$placeholders['{{listLayout}}'] 				= $this->getFrontendListTemplate();
		$placeholders['{{viewLayout}}'] 				= $this->getFrontendViewTemplate();
		$nameAttribute 									= $this->getNameAttribute();
		$placeholders['{{EntityNameMagicCode}}']		= $this->getNameAttributeMagicCode();
		$placeholders['{{nameAttribute}}'] 				= $nameAttribute->getCode();
		$placeholders['{{nameAttributeLabel}}'] 		= $nameAttribute->getLabel();
		$placeholders['{{firstImageField}}']			= $this->getFirstImageField();
		$placeholders['{{attributeSql}}']				= $this->getAttributesSql();
		$placeholders['{{menu_sort}}']					= $this->getPosition();
		$placeholders['{{defaults}}']					= $this->getConfigDefaults();
		$placeholders['{{systemAttributes}}']			= $this->getSystemAttributes();
		$placeholders['{{EntityListItem}}']				= $this->getListItemHtml();
		$placeholders['{{EntityViewAttributes}}']		= $this->getViewAttributesHtml();
		$placeholders['{{EntityViewWidgetAttributes}}'] = $this->getViewWidgetAttributesHtml();
		$placeholders['{{EntityViewRelationLayout}}'] 	= $this->getRelationLayoutXml();
		$placeholders['{{fks}}']						= $this->getParentEntitiesFks("\t\t");
		$placeholders['{{referenceHead}}']				= $this->getReferenceHeadLayout();
		return $placeholders;
	}
	/**
	 * get the placeholders for an entity as a sibling
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPlaceholdersAsSibling(){
		$placeholders = array();
		$placeholders['{{SiblingLabel}}'] 					= ucfirst($this->getLabelSingular());
		$placeholders['{{siblingLabel}}'] 					= strtolower($this->getLabelSingular());
		$placeholders['{{SiblingsLabel}}'] 					= ucfirst($this->getLabelPlural());
		$placeholders['{{siblingsLabel}}'] 					= strtolower($this->getLabelPlural());
		$placeholders['{{sibling}}'] 						= strtolower($this->getNameSingular());
		$placeholders['{{Sibling}}'] 						= ucfirst($this->getNameSingular());
		$placeholders['{{SIBLING}}'] 						= strtoupper($this->getNameSingular());
		$placeholders['{{Siblings}}'] 						= ucfirst($this->getNamePlural());
		$placeholders['{{siblings}}'] 						= $this->getNamePlural();
		$placeholders['{{siblingListLayout}}'] 				= $this->getFrontendListTemplate();
		$placeholders['{{siblingViewLayout}}'] 				= $this->getFrontendViewTemplate();
		$nameAttribute 										= $this->getNameAttribute();
		$placeholders['{{SiblingNameMagicCode}}']			= $this->getNameAttributeMagicCode();
		$placeholders['{{siblingNameAttribute}}'] 			= $nameAttribute->getCode();
		$placeholders['{{siblingNameAttributeLabel}}'] 		= $nameAttribute->getLabel();
		$placeholders['{{siblingFirstImageField}}']			= $this->getFirstImageField();
		$placeholders['{{siblingAttributeSql}}']			= $this->getAttributesSql();
		$placeholders['{{sibling_menu_sort}}']				= $this->getPosition();
		$placeholders['{{sibling_defaults}}']				= $this->getConfigDefaults();
		$placeholders['{{siblingSystemAttributes}}']		= $this->getSystemAttributes();
		$placeholders['{{SiblingListItem}}']				= $this->getListItemHtml();
		$placeholders['{{SiblingViewAttributes}}']			= $this->getViewAttributesHtml();
		$placeholders['{{SiblingViewWidgetAttributes}}'] 	= $this->getViewWidgetAttributesHtml();
		$placeholders['{{SiblingViewRelationLayout}}'] 		= $this->getRelationLayoutXml();
		$placeholders['{{siblingFks}}']						= $this->getParentEntitiesFks("\t\t");
		return $placeholders;
	}
	/**
	 * get magic function code for the name attribute
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNameAttributeMagicCode(){
		$nameAttribute = $this->getNameAttribute();
		if ($nameAttribute){
			$entityNameMagicCode = $nameAttribute->getMagicMethodCode();
		}
		else{
			$entityNameMagicCode = 'Name';
		}
		return $entityNameMagicCode;
	}
	/**
	 * get the name attribute
	 * @access public
	 * @return mixed(null|Ultimate_ModuleCreator_Model_Attribute)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNameAttribute(){
		return $this->_nameAttribute;
	}
	/**
	 * check if the entity has file attributes
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getHasFile(){
		foreach ($this->getAttributes() as $attribute){
			if ($attribute->getType() == 'file'){
				return true;
			}
		}
		return false;
	}
	/**
	 * check if the entity has image attributes
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getHasImage(){
		foreach ($this->getAttributes() as $attribute){
			if ($attribute->getType() == 'image'){
				return true;
			}
		}
		return false;
	}
	/**
	 * check if the entity has upload attributes
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getHasUpload(){
		return $this->getHasFile() || $this->getHasImage();
	}
	/**
	 * get the first image attribute code
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFirstImageField(){
		foreach ($this->getAttributes() as $attribute){
			if ($attribute->getType() == 'image'){
				return $attribute->getCode();
			}
		}
		return '';
	}
	/**
	 * get the sql for attributes
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttributesSql(){
		$padding = "\t\t";
		$content = '';
		$content.= $this->getParentEntitiesFkAttributes($padding);
		foreach ($this->getAttributes() as $attribute){
			$content .= $padding.$attribute->getSqlColumn()."\n";
		}
		if ($this->getUrlRewrite()){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('url_key');
			$attr->setLabel('URL key');
			$attr->setType('text');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		if($this->getAddStatus()){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('status');
			$attr->setLabel('Status');
			$attr->setType('yesno');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		if ($this->getIsTree()){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('parent_id');
			$attr->setLabel('Parent id');
			$attr->setType('int');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('path');
			$attr->setLabel('Path');
			$attr->setType('text');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('position');
			$attr->setLabel('Position');
			$attr->setType('int');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('level');
			$attr->setLabel('Level');
			$attr->setType('int');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('children_count');
			$attr->setLabel('Children count');
			$attr->setType('int');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		if($this->getRss()){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('in_rss');
			$attr->setLabel('In RSS');
			$attr->setType('yesno');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		if ($this->getFrontendAddSeo()){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('meta_title');
			$attr->setLabel('Meta title');
			$attr->setType('text');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('meta_keywords');
			$attr->setLabel('Meta keywords');
			$attr->setType('textarea');
			$content .= $padding.$attr->getSqlColumn()."\n";
			
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode('meta_description');
			$attr->setLabel('Meta description');
			$attr->setType('textarea');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		return substr($content,0, strlen($content) - strlen("\n"));
	}
	/**
	 * get the default settings for config
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getConfigDefaults(){
		$content = '';
		$padding = str_repeat("\t", 4);
		if ($this->getRss()){
			$content .= $padding.'<rss>1</rss>'."\n"; 
		}
		if ($this->getFrontendAddSeo() && $this->getFrontendList()){
			$content .= $padding.'<meta_title>'.ucfirst($this->getLabelPlural()).'</meta_title>'."\n";
		}
		if ($this->getIsTree()){
			$content .= $padding.'<tree>1</tree>'."\n";
		}
		return substr($content,0, strlen($content) - strlen("\n"));
	}
	/**
	 * get the system attributes
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSystemAttributes(){
		$position = 20;
		$content = '';
		$tab = "\t";
		$padding = str_repeat($tab, 6);
		if ($this->getRss()){
			$content .= $padding.'<rss translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Enable rss</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>select</frontend_type>'."\n";
			$content .= $padding.$tab.'<source_model>adminhtml/system_config_source_yesno</source_model>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</rss>'."\n";
			$position += 10;
		}
		if ($this->getIsTree() && $this->getFrontendList()){
			$content .= $padding.'<tree translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Display as tree</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>select</frontend_type>'."\n";
			$content .= $padding.$tab.'<source_model>adminhtml/system_config_source_yesno</source_model>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</tree>'."\n";
			$position += 10;
		}
		if ($this->getFrontendAddSeo() && $this->getFrontendList()){
			$content .= $padding.'<meta_title translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Meta title for '.strtolower($this->getLabelPlural()).' list page</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>text</frontend_type>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</meta_title>'."\n";
			$position += 10;
			
			$content .= $padding.'<meta_description translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Meta description for '.strtolower($this->getLabelPlural()).' list page</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>textarea</frontend_type>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</meta_description>'."\n";
			$position += 10;
			
			$content .= $padding.'<meta_keywords translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Meta keywords for '.strtolower($this->getLabelPlural()).' list page</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>textarea</frontend_type>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</meta_keywords>'."\n";
		}
		return substr($content,0, strlen($content) - strlen("\n"));
	}
	/**
	 * get the html for list view
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getListItemHtml(){
		$tab = "\t";
		$padding = str_repeat($tab, 3);
		$content = '';
		$start = '';
		if ($this->getFrontendView()){
			$content.= $padding.'<a href="<?php echo $'.'_'.$this->getNameSingular().'->get'.ucfirst($this->getNameSingular()).'Url();?>" title="<?php echo $this->htmlEscape($_'.$this->getNameSingular().'->get'.$this->getNameAttributeMagicCode().'()) ?>">'."\n";
			$start = $tab;
		}
		$content .= $padding.$start.'<?php echo $_'.$this->getNameSingular().'->get'.$this->getNameAttributeMagicCode().'(); ?>'. "\n";
		if ($this->getFrontendView()){
			$content.= $padding.'</a>'."\n";
		}
		return $content;
	}
	/**
	 * get the html for attributes in view page
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getViewAttributesHtml(){
		$content = '';
		$padding = "\t";
		foreach ($this->getAttributes() as $attribute){
			if ($attribute->getFrontend()){
				$content .= $padding.'<div class="'.$this->getNameSingular().'-'.$attribute->getCode().'">'."\n";
				$content .= "\t".$padding.$attribute->getFrontendHtml();
				$content .= $padding.'</div>'."\n";
			}
		}
		return $content;
	}
	/**
	 * get the html for attributes for the view widget
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getViewWidgetAttributesHtml(){
		$content = '';
		$padding = "\t\t\t";
		$tab = "\t";
		foreach ($this->getAttributes() as $attribute){
			if ($attribute->getWidget()){
				$content .= $padding.$attribute->getFrontendHtml();
			}
		}
		return $content;
	}
	/**
	 * get the attribute name for plural
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNamePlural(){
		$plural = $this->getData('name_plural');
		if ($plural == $this->getNameSingular()){
			if ($plural == ""){
				return "";
			}
			$plural = $this->getNameSingular().'s';
		}
		return $plural;
	}
	/**
	 * check if frontend list files must be created
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendList(){
		return $this->getUseFrontend() && $this->getData('frontend_list');
	}
	/**
	 * check if frontend view files must be created
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendView(){
		return $this->getUseFrontend() && $this->getData('frontend_view');
	}
	/**
	 * check if widget list files must be created
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWidget(){
		return $this->getUseFrontend() && $this->getData('widget');
	}
	/**
	 * check if SEO attributes should be added
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendAddSeo(){
		return $this->getUseFrontend() && $this->getData('frontend_add_seo');
	}
	/**
	 * check if the frontend list block can be created
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getCanCreateListBlock(){
		if ($this->getFrontendList()){
			return true;
		}
		//check for sibligns with frontend view
		$related = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($related as $r){
			if ($r->getFrontendView()){
				return true;
			}
		}
		//check for parents with frontend view
		$related = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		foreach ($related as $r){
			if ($r->getFrontendView()){
				return true;
			}
		}
		return false;
	}
	/**
	 * check if SEO attributes should be added
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRss(){
		return $this->getUseFrontend() && $this->getData('rss');
	}
	/**
	 * check if products are listed in the entity view page
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getShowProducts(){
		return $this->getLinkProduct() && $this->getData('show_products');
	}
	/**
	 * check if url rewrites are added
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getUrlRewrite(){
		return $this->getFrontendView() && $this->getData('url_rewrite');
	}
	/**
	 * check if url rewrites are not
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNotUrlRewrite(){
		return !$this->getUrlRewrite();
	}
	/**
	 * get layout xml for relation to product
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelationLayoutXml(){
		$content = "\t\t";
		if ($this->getShowProducts()){
			$content .= "\t".'<block type="'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'_catalog_product_list" name="'.strtolower($this->getNameSingular()).'.info.products" as="'.strtolower($this->getNameSingular()).'_products" template="'.strtolower($this->getModule()->getNamespace()).'_'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'/catalog/product/list.phtml" />'."\n\t\t";
		}
		if ($this->getIsTree()){
			$content .= "\t".'<block type="'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'_children" name="'.strtolower($this->getNameSingular()).'_children" template="'.strtolower($this->getModule()->getNamespace()).'_'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'/children.phtml" />'."\n\t\t";
		}
		$childred = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_PARENT);
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach (array_merge($childred, $siblings) as $entity){
			$content .= "\t".'<block type="'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'_'.strtolower($entity->getNameSingular()).'_list" name="'.strtolower($this->getNameSingular()).'.'.strtolower($entity->getNameSingular()).'_list" as="'.strtolower($this->getNameSingular()).'_'.strtolower($this->getNamePlural()).'" template="'.strtolower($this->getModule()->getNamespace()).'_'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'/'.strtolower($entity->getNameSingular()).'/list.phtml" />'."\n\t\t";
		}
		return $content;
	}
	/**
	 * get layout xml head reference
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getReferenceHeadLayout(){
		$content = "\t\t";
		if ($this->getIsTree()){
			$content .= '<reference name="head">'."\n";
			$content .= "\t\t\t".'<action method="addItem" ifconfig="'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'/tree"><type>skin_js</type><js>js/'.strtolower($this->getModule()->getNamespace()).'_'.strtolower($this->getModule()->getModuleName()).'/tree.js</js></action>'."\n";
			$content .= "\t\t\t".'<action method="addCss" ifconfig="'.strtolower($this->getModule()->getModuleName()).'/'.strtolower($this->getNameSingular()).'/tree"><js>css/'.strtolower($this->getModule()->getNamespace()).'_'.strtolower($this->getModule()->getModuleName()).'/tree.css</js></action>'."\n";
			$content .= "\t\t".'</reference>'."\n";
			$content .= "\t\t";
		}
		return $content;
	}
	/**
	 * check if entity list is shown on product page
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getShowOnProduct(){
		return $this->getLinkProduct() && $this->getData('show_on_product');
	}
	/**
	 * add related entities
	 * @access public
	 * @param string $type
	 * @param Ultimate_ModuleCreator_Model_Entity $entity
	 * @return Ultimate_ModuleCreator_Model_Entity
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addRelatedEntity($type, $entity){
		$this->_relatedEntities[$type][] = $entity;
		return $this;
	}
	/**
	 * get the related entities
	 * @access public
	 * @param mixed $type
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelatedEntities($type = null){
		if (is_null($type)){
			return $this->_relatedEntities;
		}
		if (isset($this->_relatedEntities[$type])){
			return $this->_relatedEntities[$type];
		}
		return array();
	}
	/**
	 * get foreign keys for parents
	 * @access public
	 * @param string $padding
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getParentEntitiesFkAttributes($padding){
		$parents = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		$content = '';
		foreach ($parents as $parent){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode($parent->getNameSingular().'_id');
			$attr->setLabel($parent->getLabelSingular());
			$attr->setType('int');
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		return $content;
	}
	/**
	 * get foreign keys for sql
	 * @access public
	 * @param string $padding
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getParentEntitiesFks($padding){
		$parents = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		$content = '';
		foreach ($parents as $parent){
			$content .= ', '."\n".$padding."KEY `FK_".strtoupper($this->getModule()->getModuleName())."_".strtoupper($this->getNameSingular())."_".strtoupper($parent->getNameSingular())."` (`".$parent->getNameSingular()."_id`)\n";
		}
		return $content;
	}
	/**
	 * check if entity does not behave as tree
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNotIsTree(){
		return !$this->getIsTree();
	}
	/**
	 * check if there is no status attribute
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNotAddStatus(){
		return !$this->getAddStatus();
	}
}