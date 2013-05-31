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
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Helper_Data extends Mage_Core_Helper_Data{
	const RELATION_TYPE_NONE 	= 0;
	const RELATION_TYPE_PARENT 	= 1;
	const RELATION_TYPE_CHILD 	= 2;
	const RELATION_TYPE_SIBLING = 3;
	/**
	 * restricted module names
	 * @var array()
	 */
	public static $_restrictedModuleNames = array();
	/**
	 * restricted entity names
	 * @var array()
	 */
	public static $_restrictedEntityNames = array(
		'resource', 'setup', 
		'attribute', 'system', 
		'flat', 'data', 
		'collection', 'adminhtml', 
		'widget', 'observer', 
		'tree', 'image',
		'node'
	);
	/**
	 * get a list with "special attribute" names and error messages
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSpecialAttributeNames(){
		$names 						= array();
		$names['created_at'] 		= $this->__('An attribute named "created_at" will be added by default to your entity');
		$names['updated_at'] 		= $this->__('An attribute named "updated_at" will be added by default to your entity');
		$names['status'] 			= $this->__('"status" is a reserved attribute name. If you want to add it set "Add Status field" to "Yes"');
		$names['in_rss']			= $this->__('"in_rss" is a reserved attribute name. If you want to add it set "Create RSS feed" to "Yes"');
		$names['meta_title']		= $this->__('"meta_title" is a reserved attribute name. If you want to add it set "Add SEO Attributes" to "Yes"');
		$names['meta_description']	= $this->__('"meta_description" is a reserved attribute name. If you want to add it set "Add SEO Attributes" to "Yes"');
		$names['meta_keywords']		= $this->__('"meta_keywords" is a reserved attribute name. If you want to add it set "Add SEO Attributes" to "Yes"');
		$names['parent_id']			= $this->__('"parent_id" is a reserved attribute name.');
		$names['level']				= $this->__('"level" is a reserved attribute name.');
		$names['children_count']	= $this->__('"children_count" is a reserved attribute name.');
		$names['path']				= $this->__('"path" is a reserved attribute name.');
		$names['url_key']			= $this->__('If you want to use URL keys set "Create URL rewrites for entity view page" to "Yes"');
		$names['node'] 				= $this->__('An attribute cannot be named %s', 'node');
		return $names;
	}
	/**
	 * get local extension packages path
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getLocalPackagesPath(){
		return $this->getLocalModulesDir().'package'.DS;
	}
	/**
	 * get local extension path
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getLocalModulesDir(){
		return Mage::getBaseDir('var').DS.'modulecreator'.DS;
	}
	/**
	 * get a list of attribute types
	 * @access public
	 * @param bool $withEmpty
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttributeTypes($withEmpty = true){
		$options = array();
		if ($withEmpty){
			$options[''] = Mage::helper('modulecreator')->__('Select type');
		}
		$options['text'] 		= Mage::helper('modulecreator')->__('Text');
		$options['int'] 		= Mage::helper('modulecreator')->__('Integer');
		$options['decimal']		= Mage::helper('modulecreator')->__('Decimal');
		$options['textarea']	= Mage::helper('modulecreator')->__('Textarea');
		$options['yesno']		= Mage::helper('modulecreator')->__('Yes/No');
		$options['timestamp']	= Mage::helper('modulecreator')->__('Timestamp');
		$options['file']		= Mage::helper('modulecreator')->__('File');
		$options['image']		= Mage::helper('modulecreator')->__('Image');
		$options['website']		= Mage::helper('modulecreator')->__('Website');
		$options['country']		= Mage::helper('modulecreator')->__('Country');
		return $options;
	}
	/**
	 * get a list of attribute scopes
	 * not used yet - maybe for EAV entities
	 * @access public
	 * @param bool $withEmpty
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getScopes($withEmpty = true){
		$options = array();
		if ($withEmpty){
			$options[''] = Mage::helper('modulecreator')->__('Select scope');
		}
		$options[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE] 	= Mage::helper('modulecreator')->__('Store View');
		$options[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE]	= Mage::helper('modulecreator')->__('Website');
		$options[Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL]	= Mage::helper('modulecreator')->__('Global');
		return $options;
	}
	/**
	 * load a module
	 * @access public
	 * @param string $module
	 * @return mixed (Varien_Simplexml_Element|bool)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function loadModule($module){
		$path = $this->getLocalPackagesPath();
		$xmlFile = $path . $module . '.xml';
		if (file_exists($xmlFile) && is_readable($xmlFile)) {
			$xml  = simplexml_load_file($xmlFile, 'Varien_Simplexml_Element');
			if (!empty($xml)) {
				return $xml;
			}
		}
		return false;
	}
	/**
	 * check if module can be installed directly
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function canInstall(){
		return !$this->isBetaRelease();
	}
	/**
	 * check if is beta release
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function isBetaRelease(){
		return Mage::getStoreConfigFlag('modulecreator/release/beta');
	}
	/**
	 * validate a sting for module name
	 * @access public
	 * @param string $string
	 * @param string $replacer
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getValidLowerString($string, $replacer = "_"){
		if (strlen($string) == 0){
			return '';
		}
		if (is_numeric($string[0])){
			return '';
		}
		$string = str_replace(' ', $replacer, $string);
		$string = strtolower($string);
		$string = trim($string, "$replacer ");
		return $string;
	}
	/**
	 * validate a module name
	 * @access public
	 * @param string $module
	 * @param string $currentExtension
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function validateModuleName($module, $currentExtension){
		if ($this->isBetaRelease()){
			$currentExtension = null;
		}
		$_module = $this->getValidLowerString($module, '');
		if (in_array($_module, self::$_restrictedModuleNames)){
			return $this->__('A module cannot be named %s', $module);
		}
		$parts = explode('_', $currentExtension);
		if (isset($parts[1])){
			if (strtolower($parts[1]) == $_module){
				return true;
			}
		}
		$config = Mage::getConfig()->getNode('global/models/'.$_module);
		if ($config){
			return $this->__('A module cannot be named %s', $module);
		}
		return true;
	}
	/**
	 * validate extension name
	 * @access public
	 * @param string $namespace
	 * @param string $module
	 * @param string $currentExtension
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function validateExtensionName($namespace, $module, $currentExtension){
		if ($this->isBetaRelease()){
			$currentExtension = null;
		}
		$namespace = ucfirst($this->getValidLowerString($namespace, ''));
		$module = ucfirst($this->getValidLowerString($module, ''));
		$modules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
		$extensionName = $namespace.'_'.$module;
		if ($extensionName == '_'){
			return $this->__('Extension name can not be empty.');
		}
		if ($extensionName == $currentExtension){
			return true;
		}
		foreach ($modules as $_module){
			if ($_module == $extensionName){
				return $this->__('Extension %s already exists', $extensionName);
			}
		}
		return true;
	}
	/**
	 * validate an entity name
	 * @access public
	 * @param string $module
	 * @param string $entity
	 * @param string $currentExtension
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function validateEntityName($module, $entity, $currentExtension){
		$module = $this->getValidLowerString($module, '');
		$entity = $this->getValidLowerString($entity, '');
		if (in_array($entity, self::$_restrictedEntityNames)){
			return $this->__('An entity cannot be named %s', $entity);
		}
		try{
			$model = Mage::getModel($module.'/'.$entity);
			$class = get_class($model);
			if ($class != ''){
				if (!empty($currentExtension) && substr($class, 0, strlen($currentExtension)) != $currentExtension){
					return $this->__('An entity cannot be named %s inside the module %s', $entity, $module);
				}
			}
		}
		catch (Exception $e){
			return true;
		}
		return true;
	}
	/**
	 * validate an attribute name
	 * @access public
	 * @param string $attribute
	 * @return mixed (bool|string)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function validateAttributeName($attribute){
		$origAttribute = $attribute;
		$methods = get_class_methods('Mage_Catalog_Model_Abstract');
		$start = array('get', 'set', 'has', 'uns');
		$attribute = $this->getValidLowerString($attribute);
		foreach ($methods as $method){
			if (in_array(substr($method, 0, 3), $start)){
				$key = strtolower(preg_replace('/(.)([A-Z])/', "$1_$2", substr($method,3)));
				if ($key == $attribute){
					return $this->__('An attribute cannot be named %s.', $origAttribute);
				}
			}
		}
		$specialNames = $this->getSpecialAttributeNames();
		foreach ($specialNames as $name=>$message){
			if ($name == $attribute){
				return $message;
			}
		}
		return true;
	}
	/**
	 * get available relation types
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAvailableRelations(){
		return array(
			self::RELATION_TYPE_NONE 	=> $this->__('--None--'),
			self::RELATION_TYPE_PARENT	=> $this->__('Is parent for'),
			self::RELATION_TYPE_CHILD	=> $this->__('Is child of'),
			self::RELATION_TYPE_SIBLING	=> $this->__('Is sibling with')
		);
	}
	/**
	 * parse xml to get entities
	 * @access public
	 * @param string $data
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getXmlEntities($data){
		$entities = array();
		if ($data){
			$xmlEntities = $data->descend('entities/entity');
			if ($xmlEntities){
				foreach ($xmlEntities as $xmlEntity){
					$entity = new Varien_Object();
					foreach ($xmlEntity as $tag=>$value){
						if ($tag != 'attributes'){
							$entity->setData($tag, (string)$value);
						}
						$attributes = array();
						foreach ($xmlEntity->descend('attributes/attribute') as $xmlAttribute){
							$attribute = $xmlAttribute->asArray();
							$attributes[] = $attribute;
						}
						$entity->setAttributes($attributes);
					}
					$entities[] = $entity;
				}
			}
		}
		return $entities;
	}
}