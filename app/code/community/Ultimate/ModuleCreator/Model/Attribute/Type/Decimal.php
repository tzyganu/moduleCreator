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
 * attribute type decimal
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Decimal extends Ultimate_ModuleCreator_Model_Attribute_Type_Int{
	/**
	 * sql colum ddl type
	 * @var string
	 */
	protected $_typeDdl 	= 'TYPE_DECIMAL';
	/**
	 * sql colum ddl size
	 * @var string
	 */
	protected $_sizeDdl 	= "'12,4'";
	/**
	 * get the sql column format
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` decimal(12,4) '.$this->getNullSql().' default \'0\',';
	} 
}