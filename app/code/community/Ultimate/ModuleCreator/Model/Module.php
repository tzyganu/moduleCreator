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
	 * entity relations
	 * @var array
	 */
	protected $_relations	= array();
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
		if ($entity->getIsTree()){
			$this->setHasTree(true);
		}
		if ($entity->getEditor()){
			$this->setEditor(true);
		}
		if ($entity->getUrlRewrite()){
			$this->setUrlRewrite(true);
		}
		if ($entity->getAdminSearch()){
			$this->setAdminSearch(true);
		}
		if ($entity->getCreateApi()){
			$this->setCreateApi(true);
		}
		return $this;
	}
	/**
	 * get a module entity
	 * @access public
	 * @param string $code
	 * @return mixed(Ultimate_ModuleCreator_Model_Entity|null)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEntity($code){
		if (isset($this->_entities[$code])){
			return $this->_entities[$code];
		}
		return null;
	}
	/**
	 * it does something I don't want to tell you what
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
		$xml .= '<relations>';
		foreach ($this->getRelations() as $relation){
			$xml .= $relation->toXml(array(), 'relation', false, $addCdata);
		}
		$xml .= '</relations>';
		if (!empty($rootName)) {
			$xml.= '</'.$rootName.'>'."\n";
		}
		return $xml;
	}
	/**
	 * get the data attributes saved in the xml
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
			$entity->setFlat(true);//just flat entities for now - EAV will follow
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
	 * get the log file path
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getLogPath(){
		return Mage::helper('modulecreator')->getLocalPackagesPath().$this->getNamespace()."_".$this->getModuleName().'.log';
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
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function buildModule(){
		$messages = array();
		$config = $this->getConfig();
		$files = $config->descend('files/file');
		foreach ($files as $file){
			$this->_createFile($file);
		}
		if ($this->getInstall()){
			$existingFiles = $this->_checkExistingFiles();
			if (count($existingFiles) > 0){
				$this->setInstall(false);
				$messages[] = Mage::helper('modulecreator')->__('The following files already exist. They were NOT overwritten. The extension was not installed. You can download it from the list of extensions and install it manually: %s', implode('<br />', $existingFiles));
			}
		}
		$this->_writeFiles();
		if (!$this->getInstall()){
			$contents = array();
			foreach ($this->_files as $filename=>$file){
				$contents[] = $this->getRelativeBasePath().$filename;
			}
			$_writer = Mage::getModel('modulecreator/writer',$contents);
			$_writer->setNamePackage(Mage::getBaseDir('var').DS.'modulecreator'.DS.$this->getNamespace().'_'.$this->getModuleName());
			$_writer->composePackage()->archivePackage();
			$this->_io->rmdir($this->getBasePath(), true);
		}
		return $messages;
	}
	/**
	 * check if some files already exist so it won't be overwritten
	 * @access protected
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _checkExistingFiles(){
		$existingFiles = array();
		$io = $this->getIo();
		$basePath = $this->getBasePath();
		foreach ($this->_files as $name=>$content){
			if ($io->fileExists($basePath.$name)){
				$existingFiles[] = $basePath.$name;
			}
		}
		return $existingFiles;
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
		$this->_writeLog();
		return $this;
	}
	/**
	 * write a log with the files that were created
	 * @access protected
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _writeLog(){
		$filesToWrite = array_keys($this->_files);
		asort($filesToWrite);
		$filesToWrite = array_values($filesToWrite);
		$text = implode("\n", $filesToWrite);
		$this->_writeFile($this->getLogPath(), $text);
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
			case 'siblings' : 
				$this->_buildSiblingFile($config);
				break;
			case 'children' : 
				$this->_buildChildrenFile($config);
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
				elseif($scope == 'siblings'){
					foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $relation){
						$entities 		= $relation->getEntities();
						$replaceEntity 	= $entities[0]->getPlaceholders();
						$replaceSibling = $entities[1]->getPlaceholdersAsSibling();
						$replace 		= array_merge($replaceEntity, $replaceSibling);
						$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
					}
				}
				elseif($scope == 'siblings_both_tree'){
					foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $relation){
						$entities 		= $relation->getEntities();
						if ($entities[0]->getIsTree() || $entities[1]->getIsTree()){
							if ($entities[0]->getIsTree()){
								$tree = $entities[0];
								$sibling = $entities[1];
							}
							else{
								$tree = $entities[1];
								$sibling = $entities[0];
							}
							$replaceEntity 	= $tree->getPlaceholders();
							$replaceSibling = $sibling->getPlaceholdersAsSibling();
							$replace 		= array_merge($replaceEntity, $replaceSibling);
							$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
						}
					}
				}
				elseif($scope == 'siblings_both_not_tree'){
					foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $relation){
						$entities 		= $relation->getEntities();
						if ($entities[0]->getIsTree() || $entities[1]->getIsTree()){
							continue;
						}
						$replaceEntity 	= $entities[0]->getPlaceholders();
						$replaceSibling = $entities[1]->getPlaceholdersAsSibling();
						$replace 		= array_merge($replaceEntity, $replaceSibling);
						$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
						
						$replaceEntity 	= $entities[1]->getPlaceholders();
						$replaceSibling = $entities[0]->getPlaceholdersAsSibling();
						$replace 		= array_merge($replaceEntity, $replaceSibling);
						$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
					}
				}
				elseif ($scope == 'children'){
					foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD) as $relation){
						$entities 		= $relation->getEntities();
						$replaceEntity 	= $entities[0]->getPlaceholders();
						$replaceSibling = $entities[1]->getPlaceholdersAsSibling();
						$replace 		= array_merge($replaceEntity, $replaceSibling);
						$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
					}
					foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_PARENT) as $relation){
						$entities 		= $relation->getEntities();
						$replaceEntity 	= $entities[1]->getPlaceholders();
						$replaceSibling = $entities[0]->getPlaceholdersAsSibling();
						$replace 		= array_merge($replaceEntity, $replaceSibling);
						$content .= $this->_filterString($sourceContent, $filetype, $replace, true);
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
				elseif($scope == 'siblings'){
					foreach ($entity->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $related){
						$placeholders 	= $entity->getPlaceholders();
						$replaceSibling = $related->getPlaceholdersAsSibling();
						$replace 		= array_merge($placeholders, $replaceSibling);
						$content 		.= $this->_filterString($sourceContent, $filetype, $replace, true);
					}
				}
				elseif($scope == 'siblings_not_tree'){
					foreach ($entity->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $related){
						if ($related->getNotIsTree()){
							$placeholders 	= $entity->getPlaceholders();
							$replaceSibling = $related->getPlaceholdersAsSibling();
							$replace 		= array_merge($placeholders, $replaceSibling);
							$content 		.= $this->_filterString($sourceContent, $filetype, $replace, true);
						}
					}
				}
				elseif($scope == 'siblings_tree'){
					foreach ($entity->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $related){
						if ($related->getIsTree()){
							$placeholders 	= $entity->getPlaceholders();
							$replaceSibling = $related->getPlaceholdersAsSibling();
							$replace 		= array_merge($placeholders, $replaceSibling);
							$content 		.= $this->_filterString($sourceContent, $filetype, $replace, true);
						}
					}
				}
				elseif($scope == 'parents'){
					foreach ($entity->getRelatedEntities(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD) as $related){
						$placeholders 	= $entity->getPlaceholders();
						$replaceSibling = $related->getPlaceholdersAsSibling();
						$replace 		= array_merge($placeholders, $replaceSibling);
						$content 		.= $this->_filterString($sourceContent, $filetype, $replace, true);
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
	 * create files for sibling relations
	 * @access protected
	 * @param Varien_Simplexml_Element
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _buildSiblingFile($config){
		foreach ($this->getRelations(Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_SIBLING) as $relation){
			$entities = $relation->getEntities();
			foreach ($entities as $index=>$entity){
				$depend = $config->depend;
				$build = true;
				if ($depend){
					foreach ($depend->asArray() as $condition=>$value){
						if (!$relation->getDataUsingMethod($condition, $index)){
							$build = false;
							break;
						}
					}
				}
				if (!$build){
					continue;
				}
				$placeholders = array_merge($entities[$index]->getPlaceholders(), $entities[1 - $index]->getPlaceholdersAsSibling());
				$filetype = $config->filetype;
				$sourceFolder = $this->getSourceFolder().$this->_filterString((string)$config->from, $filetype);
				$destinationFile = $this->_filterString((string)$config->to, $filetype, $placeholders, true);
				$content = '';
				foreach ($config->descend('content/file') as $file){
					$sourceContent = $this->getFileContents($sourceFolder.(string)$file->name);
					$content .= $this->_filterString($sourceContent, $filetype, $placeholders, true);
				}
				$this->_addFile($destinationFile, $content);
			}
		}
		return $this;
	}

	/**
	 * create files for children relations
	 * @access protected
	 * @param Varien_Simplexml_Element
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _buildChildrenFile($config){
		foreach ($this->getRelations() as $relation){
			$type = $relation->getType();
			$entities = $relation->getEntities();
			$parent = false;
			$child = false;
			if ($type == Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_PARENT){
				$parent = $entities[0];
				$child = $entities[1];
			}
			elseif ($type == Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_CHILD){
				$parent = $entities[1];
				$child = $entities[0];
			}
			if ($parent && $child){
				
				$depend = $config->depend;
				$build = true;
				if ($depend){
					foreach ($depend->asArray() as $condition=>$value){
						if (!$relation->getDataUsingMethod($condition)){
							$build = false;
							break;
						}
					}
				}
				if (!$build){
					continue;
				}
				$placeholders = array_merge($parent->getPlaceholders(), $child->getPlaceholdersAsSibling());
				$filetype = $config->filetype;
				$sourceFolder = $this->getSourceFolder().$this->_filterString((string)$config->from, $filetype);
				$destinationFile = $this->_filterString((string)$config->to, $filetype, $placeholders, true);
				$content = '';
				foreach ($config->descend('content/file') as $file){
					$sourceContent = $this->getFileContents($sourceFolder.(string)$file->name);
					$content .= $this->_filterString($sourceContent, $filetype, $placeholders, true);
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
			$this->_sourceFolder = Mage::getConfig()->getModuleDir('etc', 'Ultimate_ModuleCreator').DS.'m'.DS;
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
	/**
	 * add relation to module
	 * @access public
	 * @param Ultimate_ModuleCreator_Model_Relation $relation
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addRelation(Ultimate_ModuleCreator_Model_Relation $relation){
		$this->_relations[] = $relation;
		return $this;
	}
	/**
	 * get module relations
	 * @access public
	 * @param mixed $type
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelations($type = null){
		if (is_null($type)){
			return $this->_relations;
		}
		$relations = array();
		foreach ($this->_relations as $relation){
			if ($relation->getType() == $type){
				$relations[] = $relation;
			}
		}
		return $relations;
	}
	/**
	 * get use ddl
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getUseDdl(){
		return Mage::getStoreConfigFlag('modulecreator/settings/use_ddl');
	}
	/**
	 * get not use ddl
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNotUseDdl(){
		return !$this->getUseDdl();
	}
}