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
 * relations tab block
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */  
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Relation extends Mage_Adminhtml_Block_Widget implements Mage_Adminhtml_Block_Widget_Tab_Interface{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function __construct(){
		parent::__construct();
		$this->setTemplate('ultimate_modulecreator/edit/tab/relation.phtml');
	}
 	/**
	 * Return Tab label
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabLabel(){
		return Mage::helper('modulecreator')->__('Entity Relations');
	}
	/**
	 * Return Tab title
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabTitle(){
		return Mage::helper('modulecreator')->__('Entity Relations');
	}
	/**
	 * Can show tab in tabs
	 * @access public
	 * @return boolean
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function canShowTab(){
		return true;
	}

	/**
	 * Tab is hidden
	 * @access public
	 * @return boolean
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function isHidden(){
		return count($this->getRelations()) > 0;
	}
	/**
	 * select with relations
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelationSelect($id, $name, $selected){
		$options 	= array();
		$relations 	= Mage::helper('modulecreator')->getAvailableRelations();
		foreach ($relations as $key=>$relation){
			if ($selected == $key){
				$options[$key] = array('selected'=>'selected');
			}
			else {
				$options[$key] = array();
			}
		}
		$select = $this->getLayout()->createBlock('adminhtml/html_select')
			->setData(array(
				'class' => 'select',
				'id'	=> $id,
				'name'	=> $name
			));
		foreach ($relations as $key=>$relation){
			$select->addOption($key, $relation, $options[$key]); 
		}
		return $select->toHtml();
	}
	/**
	 * get the list of relations
	 * @access public
	 * @return array()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getRelations(){
		if (!$this->hasData('relations')){
			$data = Mage::registry('current_module');
			$entities = Mage::helper('modulecreator')->getXmlEntities($data);
			$relations = array();
			if ($data){
				$xmlRelations = $data->descend('relations');
				if ($xmlRelations){
					foreach ($xmlRelations->children() as $key =>$xmlRelation){
						foreach ($xmlRelation->asArray() as $key=>$value){
							$parts = explode('_', $key);
							if (count($parts) != 2){
								continue;
							}
							$found0 = -1;
							$found1 = -1;
							$title0 = '';
							$title1 = '';
							foreach ($entities as $ek=>$entity){
								if ($entity->getNameSingular() == $parts[0]){
									$found0 = $ek;
									$title0 = $entity->getLabelSingular();
								}
								if ($entity->getNameSingular() == $parts[1]){
									$found1 = $ek;
									$title1 = $entity->getLabelSingular();
								}
							}
							if ($found0  != -1 && $found1 != -1){
								$val = array('t0'=>$title0, 't1'=>$title1, 'val'=>(string)$value);
								$relations[$found0][$found1] = new Varien_Object($val);
							}
						}
					}
				}
			}
			$this->setData('relations', $relations);
		}
		return $this->getData('relations');
	}
}
