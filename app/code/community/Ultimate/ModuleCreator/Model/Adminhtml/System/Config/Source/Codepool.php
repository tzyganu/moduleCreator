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
 * codepool source model
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Adminhtml_System_Config_Source_Codepool{
	/**
	 * get the list of available codepools - intentionally not translated
	 * @access public
	 * @param bool $withEmpty
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function toOptionArray($withEmpty = false){
		$options = array();
		if ($withEmpty){
			$options[] = array('value'=>'', 'label'=>Mage::helper('modulecreator')->__('Select a codepool'));
		}
		$options[] = array('value' => 'local', 		'label'=>'local');
		$options[] = array('value' => 'community', 	'label'=>'community');
		return $options;
	}
	/**
	 * get options as an array
	 * @access public
	 * @params bool $withEmpty
	 * @return array
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAllOptions($withEmpty = true){
		$options = array();
		foreach ($this->toOptionArray($withEmpty) as $key=>$option){
			$options[$option['value']] = $option['label'];
		}
		return $options;
	}
}