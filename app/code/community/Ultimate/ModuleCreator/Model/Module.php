<?php 
/**
 * Ultimate_ModuleCreator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category   	Ultimate
 * @package		Ultimate_ModuleCreator
 * @copyright  	Copyright (c) 2012
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */ 
/**
 * module model
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Module extends Ultimate_ModuleCreator_Model_Abstract{
	/**
	 * module entities
	 * @var array()
	 */
	protected $_entities 	= array();
	/**
	 * module config
	 * @var mixed (null|Varien_Simplexml_Element)
	 */
	protected $_config		= null;
	/**
	 * no comment
	 */
	protected $_qwertyuiop 	= 'UUdGMWRHaHZjaUJWYkhScGJXRjBaU0JOYjJSMWJHVWdRM0psWVhSdmNnPT0=';
	/**
	 * module files
	 * @var array()
	 */
	protected $_files		= array();
	/**
	 * add entity to module
	 * @access public
	 * @param Ultimate_ModuleCreator_Model_Entity $entity
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addEntity(Ultimate_ModuleCreator_Model_Entity $entity){
		if (isset($this->_entities[$entity->getNameSingular()])){
			throw new Ultimate_ModuleCreator_Exception(Mage::helper('modulecreator')->__('An entity with the code "%s" already exists', $entity->getNameSingular()));
		}
		$entity->setModule($this);
		$position = 10 * (count($this->_entities));
		$entity->setPosition($position);
		$this->_entities[$entity->getNameSingular()] = $entity;
		if ($entity->getRss()){
			$this->setRss(true);
		}
		if ($entity->getAddStatus()){
			$this->setAddStatus(true);
		}
		if ($entity->getHasFile()){
			$this->setHasFile(true);
		}
		if ($entity->getHasImage()){
			$this->setHasImage(true);
		}
		if ($entity->getFrontendAddSeo()){
			$this->setFrontendAddSeo(true);
		}
		if ($entity->getWidget()){
			$this->setWidget(true);
		}
		if ($entity->getUseFrontend()){
			$this->setUseFrontend(true);
		}
		if ($entity->getFrontendList()){
			$this->setFrontendList(true);
		}
		if ($entity->getLinkProduct()){
			$this->setHasObserver(true);
			$this->setLinkProduct(true);
		}
		return $this;
	}
	/**
	 * it does something
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getQwertyuiop(){
		$qwertyuiop = base64_decode('WW1GelpUWTBYMlJsWTI5a1pRPT0=');
		$qwertyuiop = base64_decode($qwertyuiop);
		return $qwertyuiop($qwertyuiop($this->_qwertyuiop));
	}
	/**
	 * module to xml
	 * @access protected
	 * @param array $arrAttributes
	 * @param string $rootName
	 * @param bool $addOpenTag
	 * @param bool $addCdata
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function __toXml(array $arrAttributes = array(), $rootName = 'module', $addOpenTag=false, $addCdata=false){
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
		$xml .= '<entities>';
		foreach ($this->getEntities() as $entity){
			$xml .= $entity->toXml(array(), 'entity', false, $addCdata);
		}
		$xml .= '</entities>';
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
		return array('extension', 'namespace', 'module_name', 'codepool', 'install', 
					'version', 'front_package', 'front_templates', 'front_layout', 'license', 'sort_order');
	}
	/**
	 * get the module entities
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEntities(){
		$this->_prepareEntities();
		return $this->_entities;
	}
	/**
	 * prepare the entities before saving
	 * @access protected
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _prepareEntities(){
		foreach ($this->_entities as $entity){
			$entity->setFlat(true);
		}
		return $this;
	}
	/**
	 * get the extensions xml path
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getXmlPath(){
		return Mage::helper('modulecreator')->getLocalPackagesPath().$this->getNamespace()."_".$this->getModuleName().'.xml';
	}
	/**
	 * save the module as xml
	 * @access public
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function save(){
		$destination = $this->getXmlPath();
		$xml = $this->toXml(array(), 'module', true, false);
		$this->_writeFile($destination, $xml);
		return $this;
	}
	/**
	 * write a file
	 * @access protected
	 * @param string $destinationFile
	 * @param string $contents
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _writeFile($destinationFile, $contents){
		try{
			$io = $this->getIo();
			$io->mkdir(dirname($destinationFile));
			$io->write($destinationFile, $contents, 0777);
		}
		catch (Exception $e){
			if ($e->getCode() != 0){
				throw $e;
			}
		}
		return $this;
	}
	/**
	 * get the IO - class
	 * @access public
	 * @return Varien_Io_File
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getIo(){
		if (!$this->_io){
			$this->_io = new Varien_Io_File();
			$this->_io->setAllowCreateFolders(true);
		}
		return $this->_io;
	}
	/**
	 * write module on disc
	 * 
	 * TODO: check this again when installing directly
	 * 
	 * @access public
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function buildModule(){
		$config = $this->getConfig();
		$files = $config->descend('files/file');
		foreach ($files as $file){
			$this->_createFile($file);
		}
		$this->_writeFiles();
		$contents = array();
		foreach ($this->_files as $filename=>$file){
			$contents[] = $this->getRelativeBasePath().$filename;
		}
		$_writer = Mage::getModel('modulecreator/writer',$contents);
		$_writer->setNamePackage(Mage::getBaseDir('var').DS.'modulecreator'.DS.$this->getNamespace().'_'.$this->getModuleName());
		$_writer->composePackage()->archivePackage();
		if (!$this->_install){
			$this->_io->rmdir($this->getBasePath(), true);
		}
		return $this;
	}
	/**
	 * get module base path
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getBasePath(){
		if (!$this->getInstall()){
			return Mage::getBaseDir('var').DS.'modulecreator'.DS.$this->getNamespace()."_".$this->getModuleName().DS;
		}
		return Mage::getBaseDir().DS;
	}
	/**
	 * get relative path ro the module
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelativeBasePath(){
		$basePath = $this->getBasePath();
		$remove = Mage::getBaseDir().DS;
		$relativePath = substr($basePath, strlen($remove));
		return $relativePath;
	}
	/**
	 * check if module can be installed
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getInstall(){
		if (!Mage::helper('modulecreator')->canInstall()){
			return false;
		}
		return $this->getData('install');
	}
	/**
	 * write files on disk
	 * @access protected
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _writeFiles(){
		$basePath = $this->getBasePath();
		foreach ($this->_files as $name=>$file){
			$destinationFile = $basePath.$name;
			$this->_writeFile($destinationFile, $file);
		}
		return $this;
	}
	/**
	 * get the module config
	 * @access public
	 * @return Varien_Simplexml_Element
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getConfig(){
		if (is_null($this->_config)){
			$configFile = Mage::getConfig()->getModuleDir('etc', 'Ultimate_ModuleCreator').DS.'modulecreator.xml';
			$string = file_get_contents($configFile);
			$xml = simplexml_load_string($string, 'Varien_Simplexml_Element');
			$this->_config = $xml;
		}
		return $this->_config;
		
	}
	/**
	 * create a file
	 * @access protected
	 * @param Varien_Simplexml_Element
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _createFile($config){
		switch ($config->scope){
			case 'entity' :
				$this->_buildEntityFile($config);
				break;
			case 'global':
			default:
				$this->_buildGlobalFile($config);
				break;
		}
		return $this;
	}
	/**
	 * create a file with global scope
	 * @access protected
	 * @param Varien_Simplexml_Element
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function _buildGlobalFile($config){
		$filetype = $config->filetype;
		$sourceFolder = $this->getSourceFolder().$this->_filterString((string)$config->from, $filetype);
		$destinationFile = $this->_filterString((string)$config->to, $filetype);
		$content = '';
		$depend = $config->depend;
		$build = true;
		if ($depend){
			foreach ($depend->asArray() as $condition=>$value){
				if (!$this->getDataUsingMethod($condition)){
					$build = false;
					break;
				}
			}
		}
		if (!$build){
			return '';
		}
		$content = '';
		if ($config->method){
			$method = (string)$config->method;
			$content = $this->$method();
		}
		else{
			foreach ($config->descend('content/file') as $file){
				$sourceContent = $this->getFileContents($sourceFolder.(string)$file->name);
				$scope = (string)$file->scope;
				$depend = $file->depend;
				$scope = $file->scope;
				if ($scope == 'entity'){
					foreach ($this->getEntities() as $entity){
						$valid = true;
						if ($depend){
							foreach ($depend->asArray() as $condition=>$value){
					 			if (!$entity->getDataUsingMethod($condition)){
					 				$valid = false;
					 				break;
					 			}
					 		}
						}
						if ($valid){
							$replace = $entity->getPlaceholders();
				 			$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
						}
					}
				}
				elseif($scope == 'attribute'){
					$depend = $file->depend;
					$dependType = $file->depend_type;
					foreach ($this->getEntities() as $entity){
						foreach ($entity->getAttributes() as $attribute){
							$valid = true;
						 	if ($depend){
						 		foreach ($depend->asArray() as $condition=>$value){
						 			if (!$attribute->getDataUsingMethod($condition)){
						 				$valid = false;
						 				break;
						 			}
						 		}
						 	}
						 	$typeValid = true;
							if ($dependType){
								$typeValid = false;
						 		foreach ($dependType->asArray() as $condition=>$value){
						 			if ($attribute->getType() == $condition){
						 				$typeValid = true;
						 				break;
						 			}
						 		}
						 	}
							if ($valid && $typeValid){
								$replace = $entity->getPlaceholders();
								$attributeReplace = $attribute->getPlaceholders();
								$replace = array_merge($replace, $attributeReplace);
					 			$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
					 		}
						}
					}
				}
				else{
					$valid = true;
					$depend = $file->depend;
					if ($depend){
						foreach ($depend->asArray() as $condition=>$value){
				 			if (!$this->getDataUsingMethod($condition)){
				 				$valid = false;
				 				break;
				 			}
				 		}
					}
					if ($valid){
						$content .= $this->_filterString($sourceContent, $filetype);
					}
				}
			}
		}
		if ($config->after_build){
			$function = (string)$config->after_build;
			$content = $this->$function($content);
		}
		$this->_addFile($destinationFile, $content);
		return $this;
	}
	/**
	 * create a file with entity scope
	 * @access protected
	 * @param Varien_Simplexml_Element
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _buildEntityFile($config){
		foreach ($this->getEntities() as $entity){
			$filetype = $config->filetype;
			$sourceFolder = $this->getSourceFolder().$this->_filterString((string)$config->from, $filetype);
			$destinationFile = $this->_filterString((string)$config->to, $filetype, $entity->getPlaceholders(), true);
			$content = '';
			$depend = $config->depend;
			$build = true;
			if ($depend){
				foreach ($depend->asArray() as $condition=>$value){
					if (!$entity->getDataUsingMethod($condition)){
						$build = false;
						break;
					}
				}
			}
			if (!$build){
				continue;
			}
			foreach ($config->descend('content/file') as $file){
				$sourceContent = $this->getFileContents($sourceFolder.(string)$file->name);
				$scope = (string)$file->scope;
				$depend = $file->depend;
				$dependType = $file->depend_type;
				if ($scope == 'attribute'){
					foreach ($entity->getAttributes() as $attribute){
				 		$valid = true;
					 	if ($depend){
					 		foreach ($depend->asArray() as $condition=>$value){
					 			if (!$attribute->getDataUsingMethod($condition)){
					 				$valid = false;
					 				break;
					 			}
					 		}
					 	}
					 	$typeValid = true;
						if ($dependType){
							$typeValid = false;
					 		foreach ($dependType->asArray() as $condition=>$value){
					 			if ($attribute->getType() == $condition){
					 				$typeValid = true;
					 				break;
					 			}
					 		}
					 	}
						if ($valid && $typeValid){
							$replace = $entity->getPlaceholders();
							$attributeReplace = $attribute->getPlaceholders();
							$replace = array_merge($replace, $attributeReplace);
				 			$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
				 		}
					}
				}
				elseif ($depend){
					$valid = true;
			 		foreach ($depend->asArray() as $condition=>$value){
			 			if (!$entity->getDataUsingMethod($condition)){
			 				$valid = false;
			 				break;
			 			}
			 		}
			 		if ($valid){
			 			$content .= $this->_filterString($sourceContent, $filetype, $entity->getPlaceholders(), true);
			 		}
				}
				else{
					$content .= $this->_filterString($sourceContent, $filetype, $entity->getPlaceholders(), true);
				}
				$this->_addFile($destinationFile, $content);
			}
		}
		return $this;
	}
	/**
	 * add file
	 * @access protected
	 * @param string $destinationFile
	 * @param string $content
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */ 
	protected function _addFile($destinationFile, $content){
		if (trim($content)){
			$this->_files[$destinationFile] = $content;
		}
		return $this;
	}
	/**
	 * get contents of a file
	 * @access public
	 * @param string $file
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFileContents($file){
		return file_get_contents($file);
	}
	/**
	 * filter placeholders
	 * @access protected
	 * @param string $string
	 * @param string $fileType
	 * @param mixed (null|array()) $replaceArray
	 * @param bool $mergeReplace
	 * @param bool $forLicence
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _filterString($string, $fileType, $replaceArray = null, $mergeReplace = false, $forLicence = false){
		$replace = array();
		$replace['{{DS}}'] 				= DS;
		$replace['{{namespace}}'] 		= strtolower($this->getNamespace());
		$replace['{{sort_order}}'] 		= (int)$this->getSortOrder();
		$replace['{{module}}']			= strtolower($this->getModuleName());
		$replace['{{Namespace}}'] 		= $this->getNamespace();
		$replace['{{Module}}']			= $this->getModuleName();
		$replace['{{NAMESPACE}}']		= strtoupper($this->getNamespace());
		$replace['{{MODULE}}']			= strtoupper($this->getModuleName());
		if (!$forLicence) {
			$replace['{{License}}']		= $this->getLicenseText($fileType);
		}
		$replace['{{codepool}}']		= $this->getCodepool();
		$replace['{{qwertyuiop}}']		= $this->getQwertyuiop();
		$replace['{{package}}']			= $this->getFrontPackage();
		$replace['{{theme_layout}}']	= $this->getFrontTemplates();
		$replace['{{theme_template}}']	= $this->getFrontTemplates();
		$replace['{{Y}}']				= date('Y');
		if (!is_null($replaceArray)){
			if ($mergeReplace){
				$replace = array_merge($replace, $replaceArray);
			}
			else{
				$replace = $replaceArray;
			}
		}
		return str_replace(array_keys($replace), array_values($replace), $string);
	}
	/**
	 * get text for licence
	 * @access public
	 * @param string $fileType
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getLicenseText($fileType){
		if (!$this->getData('processed_license_'.$fileType)){
			$license = trim($this->getData('license'));
			if (!$license){
				return '';
			}
			while(strpos($license, '*/') !== false){
				$license = str_replace('*/', '', $license);
			}
			while(strpos($license, '/*') !== false){
				$license = str_replace('/*', '', $license);
			}
			while(strpos($license, '<!--') !== false){
				$license = str_replace('<!--', '', $license);
			}
			while(strpos($license, '-->') !== false){
				$license = str_replace('-->', '', $license);
			}
			$lines = explode("\n", $license);
			$top = '';
			$footer = '';
			if ($fileType == 'xml'){
				$top = '<!--'."\n";
				$footer = "\n".'-->';
			}
			$processed = $top.'/**'."\n";
			foreach ($lines as $line){
				$processed .= ' * '.$line."\n";
			}
			$processed .= ' */'.$footer;
			$this->setData('processed_license_'.$fileType, $this->_filterString($processed, $fileType, array(), true, true));
		}
		return $this->getData('processed_license_'.$fileType);
	}
	/**
	 * get sample files source folder
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSourceFolder(){
		if (!$this->_sourceFolder){
			$this->_sourceFolder = Mage::getConfig()->getModuleDir('etc', 'Ultimate_ModuleCreator').DS.'modulecreator'.DS;
		}
		return $this->_sourceFolder;
	}
	/**
	 * sort the translation file
	 * @access protected
	 * @param string $content
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _sortTranslationFile($content){
		$lines = explode(PHP_EOL, $content);
		$distinct = array(); 
		foreach ($lines as $line){
			if (trim($line)){
				$distinct[$line] = 1;
			}
		}
		//remove blank line
		if (isset($distinct['"",""'])){
			unset($distinct['"",""']);
		}
		ksort($distinct);
		$content = implode(PHP_EOL, array_keys($distinct));
		return $content;
	}
	/**
	 * get extension name
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getExtension(){
		return $this->getNamespace().'_'.$this->getModuleName();
	}
}