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
 * attribute type int
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Int extends Ultimate_ModuleCreator_Model_Attribute_Type_Abstract{
	/**
	 * sql colum ddl type
	 * @var string
	 */
	protected $_typeDdl 	= 'TYPE_INTEGER';
	/**
	 * sql colum ddl size
	 * @var string
	 */
	protected $_sizeDdl 	= 'null';
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` int(10) '.$this->getNullSql().' default \'0\',';
	} 
}