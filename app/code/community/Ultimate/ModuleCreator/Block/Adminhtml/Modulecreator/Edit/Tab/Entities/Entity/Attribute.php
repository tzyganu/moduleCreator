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
 * attribute block
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Entities_Entity_Attribute extends Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Entities_Entity{
	/**
	 * get the field id
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFieldId(){
		return 'attribute';
	}
	/**
	 * get the select with the attribute types
	 * @param string $id
	 * @param string $name
	 * @param string $selected
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttributeTypeSelect($id, $name, $selected){
		$types = Mage::helper('modulecreator')->getAttributeTypes();
		$select = $this->getLayout()->createBlock('adminhtml/html_select')
			->setData(array(
				'class' => 'select required-entry',
				'id'	=> $id,
				'name'	=> $name
			));
		foreach ($types as $key=>$type){
			if ($key === $selected){
				$options = array('selected'=>'selected');
			}
			else{
				$options = array();
			}
			$select->addOption($key, $type, $options);
		}
		return $select->getHtml();
	}
	/**
	 * get the select for the attribute scope
	 * not used yet... maybe used in the future for EAV entities
	 * @param string $id
	 * @param string $name
	 * @param string $selected
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getScopeSelect($id, $name, $selected){
		$scopes = Mage::helper('modulecreator')->getScopes();
		$select = $this->getLayout()->createBlock('adminhtml/html_select')
			->setData(array(
				'class' => 'select required-entry',
				'id'	=> $id,
				'name'	=> $name
			));
		foreach ($scopes as $key=>$scope){
			if ($key === $selected){
				$options = array('selected'=>'selected');
			}
			else{
				$options = array();
			}
			$select->addOption($key, $scope, $options);
		}
		return $select->getHtml();
	}
}