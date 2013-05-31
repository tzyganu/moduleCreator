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
	 * placeholders
	 * @var array
	 */
	protected $_placeholders		= array();
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
		$this->_placeholders = array();
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
					'rss', 'widget', 'link_product', 'show_on_product', 'show_products',
					'is_tree', 'url_rewrite', 'admin_search', 'create_api'
		);
	}
	/**
	 * get the placeholders for an entity
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPlaceholders(){
		if (!isset($this->_placeholders['entity'])){
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
			$placeholders['{{attributeDdlSql}}']			= $this->getAttributesDdlSql();
			
			$placeholders['{{menu_sort}}']					= $this->getPosition();
			$placeholders['{{defaults}}']					= $this->getConfigDefaults();
			$placeholders['{{systemAttributes}}']			= $this->getSystemAttributes();
			$placeholders['{{EntityListItem}}']				= $this->getListItemHtml();
			$placeholders['{{EntityViewAttributes}}']		= $this->getViewAttributesHtml();
			$placeholders['{{EntityViewWidgetAttributes}}'] = $this->getViewWidgetAttributesHtml();
			$placeholders['{{EntityViewRelationLayout}}'] 	= $this->getRelationLayoutXml();
			$placeholders['{{fks}}']						= $this->getParentEntitiesFks("\t\t");
			$placeholders['{{fksDdl}}']						= $this->getParentEntitiesFksDdl("\t");
			$placeholders['{{referenceHead}}']				= $this->getReferenceHeadLayout();
			//$placeholders['{{entityApiRelations}}']			= $this->getApiRelations();
			$placeholders['{{entityApiAdditional}}']		= $this->getApiAdditional();
			$placeholders['{{entityAdditionalApiAcl}}']		= $this->getAdditionalApiAcl();
			$placeholders['{{entityApiFaults}}']			= $this->getApiFaults();
			$placeholders['{{entityApiSortOrder}}']			= 110 + $this->getPosition();
			$placeholders['{{entityWsdlAttributes}}']		= $this->getWsdlAttributes();
			$placeholders['{{entityWsdlRelationTypes}}']	= $this->getWsdlRelationTypes();
			$placeholders['{{entityWsdlPortTypeRelation}}']	= $this->getWsdlPortTypeRelation();
			$placeholders['{{entityWsdlRelationBinding}}']	= $this->getWsdlRelationBinding();
			$placeholders['{{entityWsiRelationParamTypes}}']= $this->getWsiRelationParamTypes();
			$placeholders['{{entityWsiRelationMessages}}'] 	= $this->getWsiRelationMessages();
			$placeholders['{{entityWsiPortTypeRelation}}'] 	= $this->getWsiPortTypeRelation();
			$placeholders['{{entityWsiRelationBinding}}']	= $this->getWsiRelationBinding();
			$placeholders['{{entityWsiAttributes}}']		= $this->getWsiAttributes();
			$placeholders['{{entityWsiRelationTypes}}']		= $this->getWsiRelationTypes();
			$placeholders['{{entityWsdlMessages}}']			= $this->getWsdlMessages();
			$this->_placeholders['entity'] 					= $placeholders;
		}
		return $this->_placeholders['entity'];
	}
	/**
	 * get the placeholders for an entity as a sibling
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPlaceholdersAsSibling(){
		if (!isset($this->_placeholders['sibling'])){
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
			
			$this->_placeholders['sibling']						= $placeholders;
		}
		return $this->_placeholders['sibling'];
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
		$simulated = $this->_getSimulatedAttributes(null, false);
		foreach ($simulated as $attr){
			$content .= $padding.$attr->getSqlColumn()."\n";
		}
		return substr($content,0, strlen($content) - strlen("\n"));
	}
	/**
	 * get the ddl sql for attributes
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttributesDdlSql(){
		$padding = "\t";
		$content = '';
		$content.= $this->getParentEntitiesFkAttributes($padding, true);
		foreach ($this->getAttributes() as $attribute){
			$content .= $padding.$attribute->getDdlSqlColumn()."\n";
		}
		$simulated = $this->_getSimulatedAttributes(null, false);
		foreach ($simulated as $attr){
			$content .= $padding.$attr->getDdlSqlColumn()."\n";
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
			$content .= $padding.'<recursion>0</recursion>'."\n";
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
		if ($this->getIsTree() && $this->getWidget()){
			$content .= $padding.'<recursion translate="label" module="'.strtolower($this->getModule()->getModuleName()).'">'."\n";
			$content .= $padding.$tab.'<label>Recursion level</label>'."\n";
			$content .= $padding.$tab.'<frontend_type>text</frontend_type>'."\n";
			$content .= $padding.$tab.'<sort_order>'.$position.'</sort_order>'."\n";
			$content .= $padding.$tab.'<show_in_default>1</show_in_default>'."\n";
			$content .= $padding.$tab.'<show_in_website>1</show_in_website>'."\n";
			$content .= $padding.$tab.'<show_in_store>1</show_in_store>'."\n";
			$content .= $padding.'</recursion>'."\n";
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
	public function getParentEntitiesFkAttributes($padding, $ddl = false){
		$parents = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		$content = '';
		foreach ($parents as $parent){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode($parent->getNameSingular().'_id');
			$attr->setLabel($parent->getLabelSingular());
			$attr->setType('int');
			if ($ddl){
				$content .= $padding.$attr->getDdlSqlColumn()."\n";
			}
			else{
				$content .= $padding.$attr->getSqlColumn()."\n";
			}
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
	 * get foreign keys for sql (Ddl)
	 * @access public
	 * @param string $padding
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getParentEntitiesFksDdl($padding){
		$parents = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		$content = '';
		
		$module = strtolower($this->getModule()->getModuleName());
		foreach ($parents as $parent){
			$parentName = strtolower($parent->getNameSingular());
			$content .= "\n".$padding."->addIndex($"."this->getIdxName('".$module.'/'.$parentName."', array('".$parentName."_id')), array('".$parentName."_id'))";
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
	/**
	 * check if admin search is set
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAdminSearch(){
		return !$this->getIsTree() && $this->getData('admin_search');
	}
	/**
	 * get API xml for entity relations
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getApiRelations(){
		$string 		= '';
		$prefix 		= "\t\t\t\t\t";
		$eol			= "\n";
		$module 		= strtolower($this->getModule()->getModuleName());
		$entity 		= strtolower($this->getNameSingular());
		$entityLabelUc 	= ucfirst($this->getLabelSingular());
		$entityLabel 	= strtolower($this->getLabelSingular());
		if ($this->getLinkProduct()){
			$string .= $prefix. '<assignProduct translate="title" module="'.$module.'">'.$eol;
			$string .= $prefix."\t". '<title>Assign product to '.$entityLabelUc.'</title>'.$eol;
			$string .= $prefix."\t". '<acl>'.$module.'/'.$entity.'/update</acl>'.$eol;
			$string .= $prefix. '</assignProduct>'.$eol;

			$string .= $prefix. '<unassignProduct translate="title" module="'.$module.'">'.$eol;
			$string .= $prefix."\t". '<title>Remove product from '.$entityLabel.'}</title>'.$eol;
			$string .= $prefix."\t". '<acl>'.$module.'/'.$entity.'/update</acl>'.$eol;
			$string .= $prefix. '</unassignProduct>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$string .= $prefix.'<assign'.$siblingNameUc.' translate="title" module="'.$module.'">'.$eol;
			$string .= $prefix."\t".'<title>Assign '.$siblingLabel.' to '.$entityLabel.'</title>'.$eol;
			$string .= $prefix."\t".'<acl>'.$module.'/'.$entity.'/update</acl>'.$eol;
			$string .= $prefix.'</assign'.$siblingNameUc.'>'.$eol;
			
			$string .= $prefix.'<unassign'.$siblingNameUc.' translate="title" module="'.$module.'">'.$eol;
			$string .= $prefix."\t".'<title>Remove '.$siblingLabel.' from '.$entityLabel.'</title>'.$eol;
			$string .= $prefix."\t".'<acl>'.$module.'/'.$entity.'/update</acl>'.$eol;
			$string .= $prefix.'</unassign'.$siblingNameUc.'>'.$eol;
		}
		$string .= "\t\t\t\t";
		return $string;
	}
	/**
	 * get list of faults for API
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getApiFaults(){
		$string 		= '';
		$prefix 		= "\t\t\t\t\t";
		$eol			= "\n";
		$code 			= 105;
		$entity 		= strtolower($this->getNameSingular());
		$entityLabelUc 	= ucfirst($this->getLabelSingular());
		$entityLabel 	= strtolower($this->getLabelSingular());
		if ($this->getIsTree()){
			$string .= $prefix.'<not_moved>'.$eol;
			$string .= $prefix."\t".'<code>'.$code.'</code>'.$eol;
			$string .= $prefix."\t".'<message>'.$entityLabelUc.' not moved. Details in error message.</message>'.$eol;
			$string .= $prefix.'</not_moved>'.$eol;
			$code++;
		}
		if ($this->getLinkProduct()){
			$string .= $prefix.'<product_not_exists>'.$eol;
			$string .= $prefix."\t".'<code>'.$code.'</code>'.$eol;
			$string .= $prefix."\t".'<message>Product does not exist.</message>'.$eol;
			$string .= $prefix.'</product_not_exists>'.$eol;
			$code++;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			$siblingLabelUc	= ucfirst($sibling->getLabelSingular());
			
			$string .= $prefix.'<'.$entity.'_'.$siblingName.'_not_exists>'.$eol;
			$string .= $prefix."\t".'<code>'.$code.'</code>'.$eol;
			$string .= $prefix."\t".'<message>'.$siblingLabelUc.' does not exist.</message>'.$eol;
			$string .= $prefix.'</'.$entity.'_'.$siblingName.'_not_exists>'.$eol;
			$code++;
		}
		$string .= "\t\t\t\t";
		return $string;
	}
	/**
	 * get attributes format for wsdl
	 * @access public
	 * @param bool $wsi
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlAttributes($wsi = false){
		$parents = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD);
		$padding = "\t\t\t\t\t";
		$content = '';
		foreach ($parents as $parent){
			$attr = Mage::getModel('modulecreator/attribute');
			$attr->setCode($parent->getNameSingular().'_id');
			$attr->setLabel($parent->getLabelSingular());
			$attr->setType('int');
			$content .= $padding.$attr->getWsdlFormat($wsi)."\n";
		}
		foreach ($this->getAttributes() as $attribute){
			$content .= $padding.$attribute->getWsdlFormat($wsi)."\n";
		}
		$simulated = $this->_getSimulatedAttributes(null, false);
		foreach ($simulated as $attr){
			if (!$attr->getIgnoreApi()){
				$content .= $padding.$attr->getWsdlFormat($wsi)."\n";
			}
		}
		return $content;
	}
	/**
	 * get attributes format for wsi
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiAttributes(){
		return $this->getWsdlAttributes(true);
	}
	/**
	 * get simulated attribtues
	 * @access public
	 * @param mixed $type
	 * @param bool $ignoreSettings
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _getSimulatedAttributes($type = null, $ignoreSettings = false){
		$attributes = array();
		if (is_null($type)){
			return array_merge(
				$this->_getSimulatedAttributes('url_rewrite', $ignoreSettings),
				$this->_getSimulatedAttributes('status', $ignoreSettings),
				$this->_getSimulatedAttributes('tree', $ignoreSettings),
				$this->_getSimulatedAttributes('rss', $ignoreSettings),
				$this->_getSimulatedAttributes('seo', $ignoreSettings)
			);
		}
		switch ($type){
			case 'url_rewrite':
				if ($this->getUrlRewrite() || $ignoreSettings){
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('url_key');
					$attr->setLabel('URL key');
					$attr->setType('text');
					$attributes[] = $attr;
				}
			break;
			case 'status' : 
				if($this->getAddStatus() || $ignoreSettings){
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('status');
					$attr->setLabel('Status');
					$attr->setType('yesno');
					$attributes[] = $attr;
				}
				break;
			case 'tree' : 
				if ($this->getIsTree() || $ignoreSettings){
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('parent_id');
					$attr->setLabel('Parent id');
					$attr->setType('int');
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('path');
					$attr->setLabel('Path');
					$attr->setType('text');
					$attr->setIgnoreApi(true);
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('position');
					$attr->setLabel('Position');
					$attr->setType('int');
					$attr->setIgnoreApi(true);
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('level');
					$attr->setLabel('Level');
					$attr->setType('int');
					$attr->setIgnoreApi(true);
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('children_count');
					$attr->setLabel('Children count');
					$attr->setType('int');
					$attr->setIgnoreApi(true);
					$attributes[] = $attr;
				}
				break;
			case 'rss':
				if($this->getRss() || $ignoreSettings){
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('in_rss');
					$attr->setLabel('In RSS');
					$attr->setType('yesno');
					$attributes[] = $attr;
				}
				break;
			case 'seo':
				if ($this->getFrontendAddSeo() || $ignoreSettings){
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('meta_title');
					$attr->setLabel('Meta title');
					$attr->setType('text');
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('meta_keywords');
					$attr->setLabel('Meta keywords');
					$attr->setType('textarea');
					$attributes[] = $attr;
					
					$attr = Mage::getModel('modulecreator/attribute');
					$attr->setCode('meta_description');
					$attr->setLabel('Meta description');
					$attr->setType('textarea');
					$attributes[] = $attr;
				}
				break;
			default: 
				break;
		}
		return $attributes;
	}
	/**
	 * get entity WSDL relation types
	 * @access public
	 * @param bool $wsi
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlRelationTypes($wsi = false){
		$content 	= '';
		$padding 	= "\t\t\t";
		$mainTag 	= ($wsi) ? 'xsd:complexType':'complexType';
		$subtag 	= ($wsi) ? 'xsd:sequence' : 'all';
		$element 	= ($wsi) ? 'xsd:element' : 'element';
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		if ($this->getIsTree()){
			$content .= $padding.'<'.$mainTag .' name="'.$module.$entityUc.'MoveEntity">'.$eol;
			$content .= $padding."\t".'<'.$subtag.'>'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$entity.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="parent_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="after_id" type="xsd:string"'.((!$wsi)?' minOccurs="0"':'').' />'.$eol;
			$content .= $padding."\t".'</'.$subtag.'>'.$eol;
			$content .= $padding.'</'.$mainTag.'>'.$eol;
		}
		
		if ($this->getLinkProduct()){
			$content .= $padding.'<'.$mainTag .' name="'.$module.$entityUc.'AssignProductEntity">'.$eol;
			$content .= $padding."\t".'<'.$subtag.'>'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$entity.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="product_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="position" type="xsd:string"'.((!$wsi)?' minOccurs="0"':'').' />'.$eol;
			$content .= $padding."\t".'</'.$subtag.'>'.$eol;
			$content .= $padding.'</'.$mainTag.'>'.$eol;
			
			$content .= $padding.'<'.$mainTag .' name="'.$module.$entityUc.'UnassignProductEntity">'.$eol;
			$content .= $padding."\t".'<'.$subtag.'>'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$entity.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="product_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'</'.$subtag.'>'.$eol;
			$content .= $padding.'</'.$mainTag.'>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<'.$mainTag .' name="'.$module.$entityUc.'Assign'.$siblingNameUc.'Entity">'.$eol;
			$content .= $padding."\t".'<'.$subtag.'>'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$entity.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$siblingName.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="position" type="xsd:string"'.((!$wsi)?' minOccurs="0"':'').' />'.$eol;
			$content .= $padding."\t".'</'.$subtag.'>'.$eol;
			$content .= $padding.'</'.$mainTag.'>'.$eol;
			
			$content .= $padding.'<'.$mainTag .' name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'Entity">'.$eol;
			$content .= $padding."\t".'<'.$subtag.'>'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$entity.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'<'.$element.' name="'.$siblingName.'_id" type="xsd:string"'.((!$wsi)?' minOccurs="1"':'').' />'.$eol;
			$content .= $padding."\t".'</'.$subtag.'>'.$eol;
			$content .= $padding.'</'.$mainTag.'>'.$eol;
		}
		$content .= "\t\t";
		return $content;
	}
	/**
	 * get entity WSI relation types
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiRelationTypes(){
		return $this->getWsdlRelationTypes(true);
	}
	
	/**
	 * get entity WSDL messages for relations
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlMessages(){
		$content 	= '';
		$padding 	= "\t\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		if ($this->getIsTree()){
			$content .= $padding.'<message name="'.$module.$entityUc.'MoveRequest">'.$eol;
			$content .= $padding."\t".'<part name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="parentId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="afterId" type="xsd:string" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			
			$content .= $padding.'<message name="'.$module.$entityUc.'MoveResponse">'.$eol;
			$content .= $padding."\t".'<part name="id" type="xsd:boolean"/>'.$eol;
			$content .= $padding.'</message>'.$eol;
		}
		if ($this->getLinkProduct()){
			$content .= $padding.'<message name="'.$module.$entityUc.'AssignProductRequest">'.$eol;
			$content .= $padding."\t".'<part name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="productId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="position" type="xsd:string" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'AssignProductResponse">'.$eol;
			$content .= $padding."\t".'<part name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'UnassignProductRequest">'.$eol;
			$content .= $padding."\t".'<part name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="productId" type="xsd:string" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'UnassignProductResponse">'.$eol;
			$content .= $padding."\t".'<part name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding.'</message>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<message name="'.$module.$entityUc.'Assign'.$siblingNameUc.'Request">'.$eol;
			$content .= $padding."\t".'<part name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$siblingName.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="position" type="xsd:string" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'Assign'.$siblingNameUc.'Response">'.$eol;
			$content .= $padding."\t".'<part name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'Request">'.$eol;
			$content .= $padding."\t".'<part name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t".'<part name="'.$siblingName.'Id" type="xsd:string" />'.$eol;
			$content .= $padding.'</message>'.$eol;
			$content .= $padding.'<message name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'Response">'.$eol;
			$content .= $padding."\t".'<part name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding.'</message>'.$eol;
		}
		$content .= "\t";
		return $content;
	}
	/**
	 * get entity WSDL port type for relations
	 * @access public
	 * @param bool $wsi
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlPortTypeRelation($wsi = false){
		$content 	= '';
		$padding 	= "\t\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		$label		= strtolower($this->getLabelSingular()); 
		
		$tagPrefix = ($wsi) ? 'wsdl:':'';
		
		if ($this->getIsTree()){
			$content .= $padding.'<'.$tagPrefix.'operation name="'.$module.$entityUc.'Move">'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'documentation>Move '.$label.' in tree</'.$tagPrefix.'documentation>'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'input message="typens:'.$module.$entityUc.'MoveRequest" />'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'output message="typens:'.$module.$entityUc.'MoveResponse" />'.$eol;
			$content .= $padding.'</'.$tagPrefix.'operation>'.$eol;
			
		}
		
		if ($this->getLinkProduct()){
			$content .= $padding.'<'.$tagPrefix.'operation name="'.$module.$entityUc.'AssignProduct">'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'documentation>Assign product to '.$label.'</'.$tagPrefix.'documentation>'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'input message="typens:'.$module.$entityUc.'AssignProductRequest" />'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'output message="typens:'.$module.$entityUc.'AssignProductResponse" />'.$eol;
			$content .= $padding.'</'.$tagPrefix.'operation>'.$eol;
			$content .= $padding.'<'.$tagPrefix.'operation name="'.$module.$entityUc.'UnassignProduct">'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'documentation>Remove product from '.$label.'</'.$tagPrefix.'documentation>'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'input message="typens:'.$module.$entityUc.'UnassignProductRequest" />'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'output message="typens:'.$module.$entityUc.'UnassignProductResponse" />'.$eol;
			$content .= $padding.'</'.$tagPrefix.'operation>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<'.$tagPrefix.'operation name="'.$module.$entityUc.'Assign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'documentation>Assign '.$siblingLabel.' to '.$label.'</'.$tagPrefix.'documentation>'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'input message="typens:'.$module.$entityUc.'Assign'.$siblingNameUc.'Request" />'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'output message="typens:'.$module.$entityUc.'Assign'.$siblingNameUc.'Response" />'.$eol;
			$content .= $padding.'</'.$tagPrefix.'operation>'.$eol;
			$content .= $padding.'<'.$tagPrefix.'operation name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'documentation>Remove '.$siblingLabel.' from '.$label.'</'.$tagPrefix.'documentation>'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'input message="typens:'.$module.$entityUc.'Unassign'.$siblingNameUc.'Request" />'.$eol;
			$content .= $padding."\t".'<'.$tagPrefix.'output message="typens:'.$module.$entityUc.'Unassign'.$siblingNameUc.'Response" />'.$eol;
			$content .= $padding.'</'.$tagPrefix.'operation>'.$eol;
		
		}
		$content .="\t";
		return $content;
	}
	/**
	 * get entity WSI port type for relations
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiPortTypeRelation(){
		return $this->getWsdlPortTypeRelation(true); 
	}
	/**
	 * get WSDL relation binding
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlRelationBinding(){
		$content 	= '';
		$padding 	= "\t\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		$label		= strtolower($this->getLabelSingular()); 
		if ($this->getIsTree()){
			$content .= $padding.'<operation name="'.$module.$entityUc.'Move">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="urn:{{var wsdl.handler}}Action" />'.$eol;
			$content .= $padding."\t".'<input>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</input>'.$eol;
			$content .= $padding."\t".'<output>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</output>'.$eol;
			$content .= $padding.'</operation>'.$eol;
		}
		if ($this->getLinkProduct()){
			$content .= $padding.'<operation name="'.$module.$entityUc.'AssignProduct">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="urn:{{var wsdl.handler}}Action" />'.$eol;
			$content .= $padding."\t".'<input>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</input>'.$eol;
			$content .= $padding."\t".'<output>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</output>'.$eol;
			$content .= $padding.'</operation>'.$eol;
			
			$content .= $padding.'<operation name="'.$module.$entityUc.'UnassignProduct">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="urn:{{var wsdl.handler}}Action" />'.$eol;
			$content .= $padding."\t".'<input>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</input>'.$eol;
			$content .= $padding."\t".'<output>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</output>'.$eol;
			$content .= $padding.'</operation>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<operation name="'.$module.$entityUc.'Assign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="urn:{{var wsdl.handler}}Action" />'.$eol;
			$content .= $padding."\t".'<input>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</input>'.$eol;
			$content .= $padding."\t".'<output>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</output>'.$eol;
			$content .= $padding.'</operation>'.$eol;
			
			$content .= $padding.'<operation name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="urn:{{var wsdl.handler}}Action" />'.$eol;
			$content .= $padding."\t".'<input>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</input>'.$eol;
			$content .= $padding."\t".'<output>'.$eol;
			$content .= $padding."\t\t".'<soap:body namespace="urn:{{var wsdl.name}}" use="encoded" encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />'.$eol;
			$content .= $padding."\t".'</output>'.$eol;
			$content .= $padding.'</operation>'.$eol;
		}
		$content .= "\t";
		return $content;
	}
	/**
	 * get WSI relation binding
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiRelationBinding(){
		$content 	= '';
		$padding 	= "\t\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		$label		= strtolower($this->getLabelSingular()); 
		
		if ($this->getIsTree()){
			$content .= $padding.'<wsdl:operation name="'.$module.$entityUc.'Move">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="" />'.$eol;
			$content .= $padding."\t".'<wsdl:input>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:input>'.$eol;
			$content .= $padding."\t".'<wsdl:output>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:output>'.$eol;
			$content .= $padding.'</wsdl:operation>'.$eol;
		}
		
		if ($this->getLinkProduct()){
			$content .= $padding.'<wsdl:operation name="'.$module.$entityUc.'AssignProduct">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="" />'.$eol;
			$content .= $padding."\t".'<wsdl:input>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:input>'.$eol;
			$content .= $padding."\t".'<wsdl:output>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:output>'.$eol;
			$content .= $padding.'</wsdl:operation>'.$eol;
			
			$content .= $padding.'<wsdl:operation name="'.$module.$entityUc.'UnassignProduct">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="" />'.$eol;
			$content .= $padding."\t".'<wsdl:input>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:input>'.$eol;
			$content .= $padding."\t".'<wsdl:output>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:output>'.$eol;
			$content .= $padding.'</wsdl:operation>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<wsdl:operation name="'.$module.$entityUc.'Assign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="" />'.$eol;
			$content .= $padding."\t".'<wsdl:input>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:input>'.$eol;
			$content .= $padding."\t".'<wsdl:output>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:output>'.$eol;
			$content .= $padding.'</wsdl:operation>'.$eol;
			
			$content .= $padding.'<wsdl:operation name="'.$module.$entityUc.'Unssign'.$siblingNameUc.'">'.$eol;
			$content .= $padding."\t".'<soap:operation soapAction="" />'.$eol;
			$content .= $padding."\t".'<wsdl:input>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:input>'.$eol;
			$content .= $padding."\t".'<wsdl:output>'.$eol;
			$content .= $padding."\t\t".'<soap:body use="literal" />'.$eol;
			$content .= $padding."\t".'</wsdl:output>'.$eol;
			$content .= $padding.'</wsdl:operation>'.$eol;
		}
		$content .= "\t";
		return $content;
	}
	/**
	 * get entity WSI relation param types
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiRelationParamTypes(){
		$content 	= '';
		$padding 	= "\t\t\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		$label		= strtolower($this->getLabelSingular()); 
		
		if ($this->getIsTree()){
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'MoveRequestParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="parent_d" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="0" maxOccurs="1" name="after_id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'AssignProductResponseParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
		}
		
		if ($this->getLinkProduct()){
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'AssignProductRequestParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="productId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="0" maxOccurs="1" name="position" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'AssignProductResponseParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
 			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'UnassignProductRequestParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="productId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'UnassignProductResponseParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'Assign'.$siblingNameUc.'RequestParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$siblingName.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="0" maxOccurs="1" name="position" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'Assign'.$siblingNameUc.'ResponseParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
 			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'RequestParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="sessionId" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$entity.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="'.$siblingName.'Id" type="xsd:string" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
			
			$content .= $padding.'<xsd:element name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'ResponseParam">'.$eol;
			$content .= $padding."\t".'<xsd:complexType>'.$eol;
			$content .= $padding."\t\t".'<xsd:sequence>'.$eol;
			$content .= $padding."\t\t\t".'<xsd:element minOccurs="1" maxOccurs="1" name="result" type="xsd:boolean" />'.$eol;
			$content .= $padding."\t\t".'</xsd:sequence>'.$eol;
 			$content .= $padding."\t".'</xsd:complexType>'.$eol;
			$content .= $padding.'</xsd:element>'.$eol;
		}
		$content .= "\t\t";
		return $content;
	}
	/**
	 * get entity WSI relation messages
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsiRelationMessages(){
		$content 	= '';
		$padding 	= "\t";
		$eol		= "\n";
		$module 	= strtolower($this->getModule()->getModuleName());
		$entity		= $this->getNameSingular();
		$entityUc 	= ucfirst($this->getNameSingular());
		$label		= strtolower($this->getLabelSingular()); 
		
		if ($this->getIsTree()){
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'MoveRequest">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'MoveRequestParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'MoveResponse">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'MoveResponseParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
		}
		
		if ($this->getLinkProduct()){
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'AssignProductRequest">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'AssignProductRequestParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'AssignProductResponse">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'AssignProductResponseParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'UnassignProductRequest">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'UnassignProductRequestParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'UnassignProductResponse">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'UnassignProductResponseParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
		}
		$siblings = $this->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING);
		foreach ($siblings as $sibling){
			$siblingName 	= strtolower($sibling->getNameSingular());
			$siblingNameUc 	= ucfirst($sibling->getNameSingular());
			$siblingLabel	= strtolower($sibling->getLabelSingular());
			
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'Assign'.$siblingNameUc.'Request">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'Assign'.$siblingNameUc.'RequestParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'Assign'.$siblingNameUc.'Response">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'Assign'.$siblingNameUc.'ResponseParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'Request">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'Unassign'.$siblingNameUc.'RequestParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
			$content .= $padding.'<wsdl:message name="'.$module.$entityUc.'Unassign'.$siblingNameUc.'Response">'.$eol;
			$content .= $padding."\t".'<wsdl:part name="parameters" element="typens:'.$module.$entityUc.'Unassign'.$siblingNameUc.'ResponseParam" />'.$eol;
			$content .= $padding.'</wsdl:message>'.$eol;
		}
		return $content; 
	}
	/**
	 * get additional api xml
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getApiAdditional(){
		$content = $this->getApiTree();
		$content .= $this->getApiRelations();
		return $content;
	}
	/**
	 * get additional api xml for tree entities
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getApiTree(){
		$content 	= '';
		$prefix 	= "\t\t\t\t\t";
		$eol		= "\n";
		if ($this->getIsTree()){
			$module 		= strtolower($this->getModule()->getModuleName());
			$entity 		= strtolower($this->getNameSingular());
			$entityLabelUc 	= ucfirst($this->getLabelSingular());
			$entityLabel 	= strtolower($this->getLabelSingular());
			$entitiesLabel 	= strtolower($this->getLabelPlural());
			$content  = $prefix.'<level translate="title" module="'.$entity.'">'.$eol;
			$content .= $prefix."\t".'<title>Retrieve one level of '.$entitiesLabel.'</title>'.$eol;
			$content .= $prefix."\t".'<acl>'.$module.'/'.$entity.'/info</acl>'.$eol;
			$content .= $prefix.'</level>'.$eol;
			$content .= $prefix.'<move translate="title" module="catalog">'.$eol;
			$content .= $prefix."\t".'<title>Move '.$entityLabel.' in tree</title>'.$eol;
			$content .= $prefix."\t".'<acl>'.$module.'/'.$entity.'/move</acl>'.$eol;
			$content .= $prefix.'</move>'.$eol;
		}
		return $content;
	}
	public function getAdditionalApiAcl(){
		$content 	= '';
		$prefix 	= "\t\t\t\t\t\t";
		$eol		= "\n";
		if ($this->getIsTree()){
			$module 		= strtolower($this->getModule()->getModuleName());
			$entity 		= strtolower($this->getNameSingular());
			$entityLabelUc 	= ucfirst($this->getLabelSingular());
			$entityLabel 	= strtolower($this->getLabelSingular());
			$content 		.= $prefix.'<move translate="title" module="'.$module.'">'.$eol;
			$content 		.= $prefix."\t".'<title>Move</title>'.$eol;
			$content 		.= $prefix.'</move>'.$eol;
		}
		$content .= "\t\t\t\t\t";
		return $content;
	}
}
