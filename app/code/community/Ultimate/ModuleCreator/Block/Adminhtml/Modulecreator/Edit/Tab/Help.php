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
 * help tab block
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Help extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{
	/**
	 * constructor
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function __construct(){
		parent::__construct();
		$this->setTemplate('ultimate_modulecreator/edit/tab/help.phtml');
	}
 	/**
	 * Return Tab label
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabLabel(){
		return Mage::helper('modulecreator')->__('Help');
	}
	/**
	 * Return Tab title
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabTitle(){
		return Mage::helper('modulecreator')->__('Help');
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
}