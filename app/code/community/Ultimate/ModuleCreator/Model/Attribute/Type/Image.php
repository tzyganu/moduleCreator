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
 * attribute type image
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Model_Attribute_Type_Image extends Ultimate_ModuleCreator_Model_Attribute_Type_Abstract{
	/**
	 * get the type for the form
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFormType(){
		return 'image';
	}
	/**
	 * check if an attribute is in the admin grid
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getAdminGrid(){
		return false;
	}
	/**
	 * check if an attribute is required
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRequired(){
		return false;
	}
	/**
	 * get the html for frontend
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getFrontendHtml(){
		$content = '';
		$entityName = strtolower($this->getAttribute()->getEntity()->getNameSingular());
		$ucEntity = ucfirst($entityName);
		$module = strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName());
		$content .= '<?php if ($_'.$entityName.'->get'.$this->getAttribute()->getMagicMethodCode().'()) :?>'."\n";
		$content .= '		<img src="<?php echo Mage::helper(\''.$module.'/'.$entityName.'_image\')->init($_'.$entityName.', \''.$this->getAttribute()->getCode().'\')->resize(75);?>" alt="<?php echo $this->htmlEscape($_'.$entityName.'->get'.$this->getAttribute()->getEntity()->getNameAttributeMagicCode().'());?>" />'."\n\t";
		$content .= '	<?php endif;?>'."\n";
		return $content;
	}
	/**
	 * get the text for RSS
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRssText(){
		$content = '';
		$entityName = strtolower($this->getAttribute()->getEntity()->getNameSingular());
		$ucEntity = ucfirst($entityName);
		$module = strtolower($this->getAttribute()->getEntity()->getModule()->getModuleName());
		$content .= '			if ($item->get'.$this->getAttribute()->getMagicMethodCode().'()) {'."\n";
		$content .= '				$description .= \'<img src="\'.Mage::helper(\''.$module.'/'.$entityName.'_image\')->init($item, \''.$this->getAttribute()->getCode().'\')->resize(75).\'" alt="\'.$this->htmlEscape($item->get'.$this->getAttribute()->getEntity()->getNameAttributeMagicCode().'()).\'" />\';'."\n";
		$content .= '			}';
		return $content;
	}
	
}