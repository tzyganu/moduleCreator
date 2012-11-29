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
class Ultimate_ModuleCreator_Model_Abstract extends Varien_Object{
	/**
	 * to array
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function __toArray(array $arrAttributes = array()){
		if (empty($arrAttributes)) {
			$arrAttributes = array_keys($this->_data);
		}
		$arrRes = array();
		foreach ($arrAttributes as $attribute) {
			$arrRes[$attribute] = $this->getDataUsingMethod($attribute);
		}
		return $arrRes;
	}	
}