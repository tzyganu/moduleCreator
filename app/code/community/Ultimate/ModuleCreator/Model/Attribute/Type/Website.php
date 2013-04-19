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
 * attribute type website
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Website extends Ultimate_ModuleCreator_Model_Attribute_Type_Abstract{
	/**
	 * sql colum ddl type
	 * @var string
	 */
	protected $_typeDdl 	= 'TYPE_INTEGER';
	/**
	 * sql colum ddl size
	 * @var string
	 */
	protected $_sizeDdl 	= 'null';
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		return 'select';
	}
	/**
	 * get the options for form input
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormOptions(){
		$options = parent::getFormOptions();
		$module = strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName());
		$options .= self::OPTION_SEPARATOR."'values'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteValuesForForm(),\n";
		return $options;
	}
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` INT(11) '.$this->getNullSql().' default \'0\',';
	}
	/**
	 * get html for frontend
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendHtml(){
		$entityName = strtolower($this->getAttribute()->getEntity()->getNameSingular());
		$ucEntity = ucfirst($entityName);
		$module = strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName());
		return '<?php echo Mage::helper(\''.$module.'\')->__("'.$this->getAttribute()->getLabel().'");?>:<?php echo ($_'.$entityName.'->get'.$this->getAttribute()->getMagicMethodCode().'()) ? Mage::getModel(\'core/website\')->load($_'.$entityName.'->get'.$this->getAttribute()->getMagicMethodCode().'())->getName():Mage::helper(\''.$module.'\')->__(\'None\') ?>'."\n";
	}
	/**
	 * get the grid column options
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getColumnOptions(){
		$text = '';
		$text .= "'type'		=> 'options',\n";
		$text .= self::OPTION_SEPARATOR."'options'	=> Mage::getResourceSingleton('core/website_collection')->toOptionHash(),\n";
		return $text;
	}
	/**
	 * get the RSS feed text
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRssText(){
		$entityName = strtolower($this->getAttribute()->getEntity()->getNameSingular());
		$ucEntity = ucfirst($entityName);
		$module = strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName());
		return '			$description .= Mage::helper(\''.$module.'\')->__("'.$this->getAttribute()->getLabel().'").\':\'.(($item->get'.$this->getAttribute()->getMagicMethodCode().'()) ? Mage::getModel(\'core/website\')->load($item->get'.$this->getAttribute()->getMagicMethodCode().'())->getName():Mage::helper(\''.$module.'\')->__(\'None\'));';
	}	
}