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
 * layout source model
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 

class Ultimate_ModuleCreator_Model_Adminhtml_System_Config_Source_Layout{
	/**
	 * get the list of available layouts
	 * @access public
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function toOptionArray(){
		$options = array();
		$layouts = Mage::getSingleton('page/config')->getPageLayouts();
		foreach ($layouts as $layout){
			$options[] = array(
					'value'=>$layout->getTemplate(),
					'label'=>$layout->getLabel()
			);
		}
		return $options;
	}
	/**
	 * get options as an array
	 * @access public
	 * @param bool $includeEmpty
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAllOptions($includeEmpty = true){
		$options = array();
		foreach ($this->toOptionArray() as $key=>$option){
			if (!$includeEmpty && $key == 0){
				continue;
			}
			$options[$option['value']] = $option['label'];
		}
		return $options;
	}
}