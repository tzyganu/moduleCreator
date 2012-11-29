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
class Ultimate_ModuleCreator_Helper_Adminhtml extends Mage_Core_Helper_Abstract{
	/**
	 * tooltip block
	 * @var Mage_Adminhtml_Block_Template
	 */
	protected $_tooltipBlock = null;
	/**
	 * get the tooltip html
	 * @access public
	 * @param string $title
	 * @param string $text
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTooltipHtml($title, $text){
		return $this->getTooltipBlock()->setTitle($title)->setMessage($text)->toHtml();
	}
	/**
	 * get the tooltip block for help messages
	 * @access public
	 * @return Mage_Adminhtml_Block_Template
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTooltipBlock(){
		if (is_null($this->_tooltipBlock)){
			$this->_tooltipBlock = Mage::app()->getLayout()->createBlock('adminhtml/template')->setTemplate('ultimate_modulecreator/tooltip.phtml');
		}
		return $this->_tooltipBlock;
	}
}
