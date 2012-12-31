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
 * admin controller
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Adminhtml_ModulecreatorController extends Mage_Adminhtml_Controller_Action{
	/**
	 * default action
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function indexAction(){
		$this->_title($this->__('Ultimate module creator'));
		$this->loadLayout();
		$this->renderLayout();
	}
	/**
	 * grid action
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function gridAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	/**
	 * new action
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function newAction(){
		$this->_forward('edit');
	}
	/**
	 * edit action
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function editAction(){
		$data = $this->_initModule();
		$this->_title($this->__('Ultimate module creator'));
		if ($data){
			$this->_getSession()->addNotice(Mage::helper('modulecreator')->__('You are editing the module: %s',(string)$data->extension));
			$this->_title((string)$data->descend('config/module'));
		}
		else{
			$this->_title($this->__('Add module'));	
		}
		$this->loadLayout();
		$this->renderLayout();
	}
	/**
	 * init module
	 * @access protected
	 * @return mixed
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _initModule(){
		$packageName = base64_decode(strtr($this->getRequest()->getParam('id'), '-_,', '+/='));
		if ($packageName){
			try {
				$data = Mage::helper('modulecreator')->loadModule($packageName);
				Mage::register('current_module', $data);
				return $data;
			}
			catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
				$this->_redirect('*/*/index');
			}
		}
		return false;
	}
	/**
	 * add new entity - action
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addEntityAction(){
		$increment 	= $this->getRequest()->getParam('increment', 0);
		$entity 	= Mage::getModel('modulecreator/entity');
		$settings 	= Mage::getStoreConfig('modulecreator/entity_defaults');
		$entity->addData($settings);
		$response 	= Mage::app()->getLayout()
						->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_entities_entity')
						->setTemplate('ultimate_modulecreator/edit/tab/entities/entity.phtml')
						->setEntity($entity)
						->setIncrement($increment)
						->toHtml();
		$this->getResponse()->setBody($response);
	}
	/**
	 * add new attribute/field
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function addAttributeAction(){
		$increment 	= $this->getRequest()->getParam('increment', 0);
		$entityId 	= $this->getRequest()->getParam('entity', 0);
		$response 	= Mage::app()->getLayout()
						->createBlock('modulecreator/adminhtml_modulecreator_edit_tab_entities_entity_attribute')
						->setTemplate('ultimate_modulecreator/edit/tab/entities/entity/attribute.phtml')
						->setAttributeInstance(Mage::getModel('modulecreator/attribute'))
						->setIncrement($increment)
						->setEntityId($entityId)
						->toHtml();
		$this->getResponse()->setBody($response);
	}
	/**
	 * validate module before saving
	 * @access public 
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function validateAction(){
		$errors = array();
		$response = new Varien_Object();
		$response->setError(false);
		$data = $this->getRequest()->getPost();
		$entities = $this->getRequest()->getPost('entity');
		$settings = $this->getRequest()->getPost('settings');
		if (empty($settings['namespace'])){
			$error = new Varien_Object();
			$error->setField('settings_namespace');
			$error->setMessage(Mage::helper('modulecreator')->__('Fill in the Namespace'));
			$errors[] = $error->toArray();
		}
		if (empty($settings['module_name'])){
			$error = new Varien_Object();
			$error->setField('settings_module_name');
			$error->setMessage(Mage::helper('modulecreator')->__('Fill in the Module name'));
			$errors[] = $error->toArray();
		}
		else{
			$validModule = Mage::helper('modulecreator')->validateModuleName($settings['module_name'], $settings['current_extension']);
			if (is_string($validModule)){
				$error = new Varien_Object();
				$error->setMessage($validModule);
				$error->setField('settings_module_name');
				$errors[] = $error->toArray();
			}
		}
		$validExtension = Mage::helper('modulecreator')->validateExtensionName($settings['namespace'], $settings['module_name'], $settings['current_extension']);
		if (is_string($validExtension)){
			$error = new Varien_Object();
			$error->setMessage($validExtension);
			$errors[] = $error->toArray();
		}
		if (empty($entities)){
			$error = new Varien_Object();
			$error->setMessage(Mage::helper('modulecreator')->__('Add at least one entity'));
			$errors[] = $error->toArray();
		}
		else{
			//validate each entity
			$noAttributeEntities = false;
			$noNameEntities = false;
			foreach ($entities as $key=>$entity){
				if (empty($entity['name_singular'])){
					$error = new Varien_Object();
					$error->setMessage(Mage::helper('modulecreator')->__('This is a required field.'));
					$error->setField('entity_'.$key.'_name_singular');
					$errors[] = $error->toArray();
				}
				if (empty($entity['name_plural'])){
					$error = new Varien_Object();
					$error->setMessage(Mage::helper('modulecreator')->__('This is a required field.'));
					$error->setField('entity_'.$key.'_name_plural');
					$errors[] = $error->toArray();
				}
				if (!isset($entity['attributes']) && !$noAttributeEntities){
					$error = new Varien_Object();
					$error->setMessage(Mage::helper('modulecreator')->__('There are entities without attribtues. Add attributes or remove them before continuing.'));
					$errors[] = $error->toArray();
					$noAttributeEntities = true;
				}
				elseif (isset($entity['attributes'])){
					//validate attributes
					foreach ($entity['attributes'] as $attrKey=>$attribute){
						if (is_numeric($attrKey)){
							$validAttribute = Mage::helper('modulecreator')->validateAttributeName($attribute['code']);
							if (is_string($validAttribute)){
								$error = new Varien_Object();
								$error->setMessage($validAttribute);
								$error->setField('attribute_'.$key.'_'.$attrKey.'_code');
								$errors[] = $error->toArray();
							}
						}
					}
				}
				if ((!isset($entity['attributes']) || is_null($entity['attributes']['is_name'])) && !$noNameEntities){
					$error = new Varien_Object();
					$error->setMessage(Mage::helper('modulecreator')->__('Each entity must have an attribute set to behave as "Name"'));
					$errors[] = $error->toArray();
					$noNameEntities = true;
				}
				$validEntity = Mage::helper('modulecreator')->validateEntityName($settings['module_name'], @$entity['name_singular'], $settings['current_extension']);
				if (is_string($validEntity)){
					$error = new Varien_Object();
					$error->setMessage($validEntity);
					$error->setField('entity_'.$key.'_name_singular');
					$errors[] = $error->toArray();
				}
				
			}
		}
		try{
			$module = $this->_initModuleFromData($data);
		}
		catch (Exception $e){
			$error = new Varien_Object();
			$error->setMessage($e->getMessage());
			$errors[] = $error->toArray();
		}
		if (count($errors) > 0){
			$response->setError(true);
			$response->setErrors($errors);
		}
		$this->getResponse()->setBody($response->toJson());
	}
	/**
	 * init a module from an array
	 * @access public 
	 * @param array $data
	 * @return Ultimate_ModuleCreator_Model_Module
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _initModuleFromData($data){
		$entitiesByIndex = array();
		$module = Mage::getModel('modulecreator/module');
		if (isset($data['settings'])){
			$module->addData($data['settings']);
		}
		if (isset($data['entity'])){
			$entities = $data['entity'];
			if (is_array($entities)){
				foreach ($entities as $key=>$entityData){
					$entity = Mage::getModel('modulecreator/entity');
					$entity->addData($entityData);
					if (isset($entityData['attributes']) && is_array($entityData['attributes'])){
						if (isset($entityData['attributes']['is_name'])){
							$isName = $entityData['attributes']['is_name'];
							unset($entityData['attributes']['is_name']);
						}
						if (isset($entityData['attributes'][$isName])){
							$entityData['attributes'][$isName]['is_name'] = 1;
						}
						foreach ($entityData['attributes'] as $attributeData){
							$attribute = Mage::getModel('modulecreator/attribute');
							$attribute->addData($attributeData);
							$entity->addAttribute($attribute);
						}
					}
					$module->addEntity($entity);
					$entitiesByIndex[$key] = $entity;
				}
			}
			if (isset($data['relation'])){
				foreach($data['relation'] as $index=>$values){
					foreach ($values as $jndex=>$type){
						if (isset($entitiesByIndex[$index]) && isset($entitiesByIndex[$jndex])){
							//Many to many relations between tree entities is not supported yet
							//ignore these relations
							if ($entitiesByIndex[$index]->getIsTree() && $entitiesByIndex[$jndex]->getIsTree()){
								$type = Ultimate_ModuleCreator_Helper_Data::RELATION_TYPE_NONE;
							}
							$relation = Mage::getModel('modulecreator/relation');
							$relation->setEntities($entitiesByIndex[$index], $entitiesByIndex[$jndex], $type);
							$module->addRelation($relation);
						}
					}
				}
			}
		}
		return $module;
	}
	/**
	 * save module
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function saveAction(){
		$redirectBack = $this->getRequest()->getParam('back', false);
		try{
			$module = $this->_initModuleFromData($this->getRequest()->getPost());
			$messages = $module->buildModule();
			$module->save();
			foreach ($messages as $message){
				$this->_getSession()->addNotice($message);
			}
			$this->_getSession()->addSuccess(Mage::helper('modulecreator')->__('Your extension has been created!'));
		}
		catch (Exception $e){
			$this->_getSession()->addError($e->getMessage());
			$redirectBack = true;
		}
		if ($redirectBack) {
			$this->_redirect('*/*/edit', array(
				'id'	=> strtr(base64_encode($module->getNamespace().'_'.$module->getModuleName()), '+/=', '-_,'),
				'_current'	=> true
			));
		}
		else {
			$this->_redirect('*/*/');
		}
	}
	/**
	 * action for menu order select
	 * @access public 
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function menuOrderAction(){
		$menu = Mage::getSingleton('admin/config')->getAdminhtmlConfig()->getNode('menu');
		$items = array();
		foreach ($menu->children() as $key=>$values){
			if (1 == $values->disabled) {
				continue;
			}
			$item = array('label'=>(string)$values->title, 'sort_order'=>(int)$values->sort_order);
			$items[(int)$values->sort_order][] = $item;
		}
		ksort($items);
		$response = array();
		foreach ($items as $order=>$orderedItems){
			foreach ($orderedItems as $item){
				$response[] = $item;
			}
		}
		$this->getResponse()->setBody(json_encode($response));
	}
	/**
	 * download module action
	 * @access public 
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function downloadAction(){
		$packageName = base64_decode(strtr($this->getRequest()->getParam('id'), '-_,', '+/='));
		$path = Mage::helper('modulecreator')->getLocalModulesDir();
		$file = $path . $packageName . '.tgz';
		if (file_exists($file) && is_readable($file)) {
			$content = file_get_contents($file);
			$this->_prepareDownloadResponse(basename($file), $content);
		}
		else{
			$this->_getSession()->addError(Mage::helper('modulecreator')->__('Your extension archive was not created or is not readable'));
			$this->_redirect('*/*');
		}
	}
}