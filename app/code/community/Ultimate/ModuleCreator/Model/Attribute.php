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
class Ultimate_ModuleCreator_Model_Attribute extends Ultimate_ModuleCreator_Model_Abstract{
	/**
	 * entity object
	 * @var mixed(null|Ultimate_ModuleCreator_Model_Entity)
	 */
	protected $_entity 			= null;
	/**
	 * attribyte type instance
	 * @var mixed(null|Ultimate_ModuleCreator_Model_Attribute_Type_Abstract)
	 */
	protected $_typeInstance 	= null;
	/**
	 * set the model entity
	 * @access public
	 * @param  Ultimate_ModuleCreator_Model_Entity $entity
	 * @return Ultimate_ModuleCreator_Model_Attribute
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function setEntity(Ultimate_ModuleCreator_Model_Entity $entity){
		$this->_entity = $entity;
		return $this;
	}
	/**
	 * get the attribute entity
	 * @access public
	 * @return mixed (Ultimate_ModuleCreator_Model_Entity|null)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEntity(){
		return $this->_entity;
	}
	/**
	 * get placeholders
	 * @access publoc
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPlaceholders(){
		$placeholders['{{attributeLabel}}'] 		= $this->getLabel();
		$placeholders['{{AttributeMagicCode}}'] 	= $this->getMagicMethodCode();
		$placeholders['{{attributeCode}}'] 			= $this->getCode();
		$placeholders['{{attributeColumnOptions}}'] = $this->getColumnOptions();
		$placeholders['{{attributeFormType}}']		= $this->getFormType();
		$placeholders['{{attributeFormOptions}}']	= $this->getFormOptions();
		$placeholders['{{attributePreElementText}}']= $this->getPreElementText();
		$placeholders['{{attributeRssText}}']		= $this->getRssText();
		$placeholders['{{attributeNote}}']			= $this->getNote();
		return $placeholders;
	}
	/**
	 * get the magic function code for attribute
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getMagicMethodCode(){
		$code = $this->getCode();
		return $this->_camelize($code);
	}
	/**
	 * get attribute the type instance
	 * @access public
	 * @return Ultimate_ModuleCreator_Model_Attribute_Type_Abstract
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTypeInstance(){
		if (!$this->_typeInstance){
			if (!$this->getType()){
				$type = 'abstract';
			}
			else{
				$type = $this->getType();
			}
			try{
				$this->_typeInstance = Mage::getModel('modulecreator/attribute_type_'.$type);
				$this->_typeInstance->setAttribute($this);
			}
			catch (Exception $e){
				throw new Ultimate_ModuleCreator_Exception("Invalid attribute type: ". $type);
			}
		}
		return $this->_typeInstance;
	}
	/**
	 * get the admin grid column options
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getColumnOptions(){
		return $this->getTypeInstance()->getColumnOptions();
	}
	/**
	 * check if an attribute is in the admin grid
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAdminGrid(){
		if ($this->getIsName()){
			return true;
		}
		return $this->getTypeInstance()->getAdminGrid();
	}
	/**
	 * check if an attribute can use an editor
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEditor(){
		return $this->getTypeInstance()->getEditor();
	}
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		return $this->getTypeInstance()->getFormType();
	}
	/**
	 * get the additional data for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormOptions(){
		return $this->getTypeInstance()->getFormOptions();
	}
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return $this->getTypeInstance()->getSqlColumn();
	}
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getDdlSqlColumn(){
		$ddl = '';
		$ddl .= "->addColumn('{$this->getCode()}', Varien_Db_Ddl_Table::".$this->getTypeDdl().", ".$this->getSizeDdl().", array(\n";
		if ($this->getRequired()){
			$ddl .= "\t\t"."'nullable'  => false,\n";
		}
		if ($this->getType() == 'int'){
			$ddl .= "\t\t"."'unsigned'  => true,\n";
		}
		$ddl .= "\t\t), '".$this->getLabel()."')\n";
		return $ddl; 
	}
	/**
	 * get column ddl type
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTypeDdl(){
		return $this->getTypeInstance()->getTypeDdl();
	}
	/**
	 * get column ddl size
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSizeDdl(){
		return $this->getTypeInstance()->getSizeDdl();
	}
	/**
	 * get the frontend html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendHtml(){
		return $this->getTypeInstance()->getFrontendHtml();
	}
	/**
	 * get text before the element in the admin grid
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPreElementText(){
		return $this->getTypeInstance()->getPreElementText();
	}
	/**
	 * get RSS feed text
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRssText(){
		return $this->getTypeInstance()->getRssText();
	}
	/**
	 * gcheck if attribute is required
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRequired(){
		if ($this->getIsName()){
			return true;
		}
		return $this->getTypeInstance()->getRequired();
	}
	/**
	 * get wsdl format for attribute
	 * @access public
	 * @param bool $wsi
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getWsdlFormat($wsi = false){
		if ($wsi){
			return '<xsd:element name="'.$this->getCode().'" type="xsd:string" />';	
		}
		return '<element name="'.$this->getCode().'" type="xsd:string" minOccurs="'.(int)$this->getRequired().'" />';
	}
}