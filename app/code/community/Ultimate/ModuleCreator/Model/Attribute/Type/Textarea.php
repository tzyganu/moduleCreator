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
 * attribute type textarea
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Textarea extends Ultimate_ModuleCreator_Model_Attribute_Type_Abstract{
	/**
	 * sql colum ddl size
	 * @var string
	 */
	protected $_sizeDdl 	= "'64k'";
	/**
	 * the textarea attributes are not allowed in the admin grid
	 * @access public
	 * @return bool
	 * @see Ultimate_ModuleCreator_Model_Attribute_Type_Abstract::getAdminGrid()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAdminGrid(){
		return false;
	}
	/**
	 * check if an attribute uses an editor
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEditor(){
		return $this->getAttribute()->getData('editor');
	}
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		if ($this->getEditor()){
			return 'editor';
		}
		return 'textarea';
	}
	/**
	 * get the options for form input
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormOptions(){
		$options = '';
		if ($this->getEditor() && !$this->getAttribute()->getEntity()->getIsTree()){
			$options = self::OPTION_SEPARATOR."'config'	=> "."$"."wysiwygConfig,\n";
		}
		$options .= parent::getFormOptions();
		return $options;
	}
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` TEXT '.$this->getNullSql().' default \'\',';
	} 
}