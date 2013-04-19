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
 * attribute type abstract
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Abstract extends Varien_Object{
	/**
	 * separator for options
	 * @var string
	 */
	const OPTION_SEPARATOR 	= "\t\t\t";
	/**
	 * attribute memebr
	 * @var mixed(null|Ultimate_ModuleCreator_Model_Attribute)
	 */
	protected $_attribute 	= null;
	/**
	 * sql colum ddl type
	 * @var string
	 */
	protected $_typeDdl 	= 'TYPE_TEXT';
	/**
	 * sql colum ddl size
	 * @var string
	 */
	protected $_sizeDdl 	= '255';
	/**
	 * set attribute
	 * @access public
	 * @param Ultimate_ModuleCreator_Model_Attribute $attribute
	 * @return Ultimate_ModuleCreator_Model_Attribute_Type_Abstract
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function setAttribute(Ultimate_ModuleCreator_Model_Attribute $attribute){
		$this->_attribute = $attribute;
		return $this;
	}
	/**
	 * get the attribute
	 * @access public
	 * @return mixed(null|Ultimate_ModuleCreator_Model_Attribute)
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAttribute(){
		return $this->_attribute;
	}
	/**
	 * get the grid column options
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getColumnOptions(){
		return "'type'	 	=> 'text',"."\n";
	}
	/**
	 * check if an attribute is in the admin grid
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAdminGrid(){
		return $this->getAttribute()->getData('admin_grid');
	}
	/**
	 * check if an attribute uses an editor
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getEditor(){
		return false;
	}
	/**
	 * check if an attribute is required
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRequired(){
		return $this->getAttribute()->getData('required');
	}
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		return 'text';
	}
	/**
	 * get the options for form input
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormOptions(){
		$options = '';
		$note = $this->getAttribute()->getNote();
		if ($note){
			$options .= self::OPTION_SEPARATOR."'note'	=> $"."this->__('".$note."'),"."\n";
		}
		if ($this->getRequired()){
			$options .= self::OPTION_SEPARATOR."'required'  => true,"."\n";
			$options .= self::OPTION_SEPARATOR."'class' => 'required-entry',"."\n";
		}
		return $options."\n";
	}
	/**
	 * get the text before the element in the admin form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getPreElementText(){
		return '';
	}
	/**
	 * get the sql column
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSqlColumn(){
		return '`'.$this->getAttribute()->getCode().'` varchar(255) '.$this->getNullSql().' default \'\',';
	}
	/**
	 * check if sql column can be null
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getNullSql(){
		if ($this->getAttribute()->getRequired()){
			return 'NOT NULL';
		}
		return 'NULL';
	}
	/**
	 * get the html for frontend
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendHtml(){
		return '<?php echo Mage::helper(\''.strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName()).'\')->__(\''.$this->getAttribute()->getLabel().'\');?>:<?php echo $_'.strtolower($this->getAttribute()->getEntity()->getNameSingular()).'->get'.$this->getAttribute()->getMagicMethodCode().'();?>'."\n";
	}
	/**
	 * get the text for RSS
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRssText(){
		return '			$'.'description .= $item->get'.$this->getAttribute()->getMagicMethodCode().'();';
	}
	/**
	 * get column ddl type
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTypeDdl(){
		return $this->_typeDdl;
	}
	/**
	 * get column ddl size
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSizeDdl(){
		return $this->_sizeDdl;
	}
}