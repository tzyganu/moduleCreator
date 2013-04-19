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
 * attribute type timestamp
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Timestamp extends Ultimate_ModuleCreator_Model_Attribute_Type_Abstract{
	/**
	 * sql colum ddl type
	 * @var string
	 */
	protected $_typeDdl 	= 'TYPE_DATETIME';
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		return 'date';
	}
	/**
	 * get sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` datetime '.$this->getNullSql().' default \'0000-00-00\',';
	}
	/**
	 * get the text before the element in the admin form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPreElementText(){
		$text = '';
		$text .= '		$dateFormatIso = Mage::app()->getLocale()->getDateFormat('."\n";
		$text .= '			Mage_Core_Model_Locale::FORMAT_TYPE_SHORT'."\n";
		$text .= '		);'."\n";
		return $text;
	}
	/**
	 * get options for admin form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormOptions(){
		$options = parent::getFormOptions();
		$options .= '		\'image\'	 => $this->getSkinUrl(\'images/grid-cal.gif\'),'."\n";
		$options .= '		\'format\'	=> $dateFormatIso,'."\n";
		return $options;
	}
	/**
	 * get the grid column options
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getColumnOptions(){
		return "'type'	 	=> 'date',"."\n";
	}
}