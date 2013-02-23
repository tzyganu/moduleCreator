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
 * entities tab
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Entities extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function __construct(){
		parent::__construct();
		$this->setTemplate('ultimate_modulecreator/edit/tab/entities.phtml');
	}
 	/**
	 * Return Tab label
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabLabel(){
		return Mage::helper('modulecreator')->__('Entities');
	}
	/**
	 * Return Tab title
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabTitle(){
		return Mage::helper('modulecreator')->__('Entities');
	}
	/**
	 * Can show tab in tabs
	 * @access public
	 * @return boolean
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function canShowTab(){
		return true;
	}

	/**
	 * Tab is hidden
	 * @access public
	 * @return boolean
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function isHidden(){
		return false;
	}
	/**
	 * get the "add entity" button html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAddButtonHtml($suffix = ""){
		$button = $this->getLayout()->createBlock('adminhtml/widget_button')->setData(array(
			'label' 	=> Mage::helper('modulecreator')->__('Add entity'),
			'onclick'   => 'addEntity();',
			'class'   	=> 'add',
			'id'		=> 'add_entity_button'.$suffix
		));
		return $button->toHtml();
	}
	/**
	 * get the url for adding an entity
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAddEntityUrl(){
		return $this->getUrl('adminhtml/modulecreator/addEntity');
	}
	/**
	 * get the url for adding an attribute
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAddAttributeUrl(){
		return $this->getUrl('adminhtml/modulecreator/addAttribute');
	}
	/**
	 * get the list of entities
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEntities(){
		$data = Mage::registry('current_module');
		return Mage::helper('modulecreator')->getXmlEntities($data);
	}
}