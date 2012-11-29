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
 * entity block
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Entities_Entity extends Mage_Adminhtml_Block_Abstract{
	/**
	 * get the field id
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFieldId(){
		return 'entity';
	}
	/**
	 * get a yes/no select
	 * @param string $id
	 * @param string $name
	 * @param int $selected
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getYesNoSelect($id, $name, $selected){
		$options[(int)($selected == 1)] = array('selected'=>'selected');
		$options[1 - (int)($selected == 1)] = array();
		$select = $this->getLayout()->createBlock('adminhtml/html_select')
			->setData(array(
				'class' => 'select required-entry',
				'id'	=> $id,
				'name'	=> $name
			))
			->addOption(1, Mage::helper('modulecreator')->__('Yes'), $options[1])
			->addOption(0, Mage::helper('modulecreator')->__('No'), $options[0]);
		return $select->getHtml();
	}
	/**
	 * get a page template select
	 * @param string $id
	 * @param string $name
	 * @param string $selected
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTemplateSelect($id, $name, $selected){
		$options = array();
		$layouts = Mage::getSingleton('page/config')->getPageLayouts();
		foreach ($layouts as $layout){
			if ($selected == $layout->getTemplate()){
				$options[$layout->getTemplate()] = array('selected'=>'selected');
			}
			else {
				$options[$layout->getTemplate()] = array();
			}
		}
		$select = $this->getLayout()->createBlock('adminhtml/html_select')
			->setData(array(
				'class' => 'select required-entry',
				'id'	=> $id,
				'name'	=> $name
			));
		foreach ($layouts as $layout){
			$select->addOption($layout->getTemplate(), $layout->getLabel(), $options[$layout->getTemplate()]); 
		}
		return $select->toHtml();
	}
}