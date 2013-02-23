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
 * admin edit block.
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */ 
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit extends Mage_Adminhtml_Block_Widget_Form_Container{
	/**
	 * construct
	 * @access public
	 * @return void
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function __construct(){
		parent::__construct();
		$this->_blockGroup = 'adminhtml';
		$this->_controller = 'modulecreator';
		$this->setTemplate('ultimate_modulecreator/edit.phtml');
	}
	/**
	 * get header text
	 * @access public
	 * @return string
	 * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getHeaderText(){
		$data = Mage::registry('current_module');
		if ($data){
			return Mage::helper('modulecreator')->__('Edit "%s" module', $data->extension);
		}
		return Mage::helper('modulecreator')->__('Create Module');
	}
	/**
	 * prepare the layout
	 * @access protected
	 * @return Ultimate_ModuleCreator_Block_Adminhtml_ModuleCreator_Edit
	 * @see Mage_Adminhtml_Block_Widget_Form_Container::_prepareLayout()
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _prepareLayout(){
		$this->setChild('back_button',
			$this->getLayout()
				->createBlock('adminhtml/widget_button')
				->setData(array(
						'label' => Mage::helper('modulecreator')->__('Back'),
						'onclick'   => 'setLocation(\''.$this->getUrl('*/*/').'\')',
						'class' => 'back'
					))
		);
		$this->setChild('reset_button',
			$this->getLayout()
				->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('modulecreator')->__('Reset'),
					'onclick'   => 'setLocation(\''.$this->getUrl('*/*/*', array('_current'=>true)).'\')'
				))
		);
		$this->setChild('save_button',
			$this->getLayout()
				->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('modulecreator')->__('Save'),
					'onclick'   => 'moduleForm.submit()',
					'class' => 'save'
			))
		);
		$this->setChild('save_and_edit_button',
			$this->getLayout()
				->createBlock('adminhtml/widget_button')
				->setData(array(
					'label' => Mage::helper('modulecreator')->__('Save and Continue Edit'),
					'onclick'   => 'saveAndContinueEdit(\''.$this->getSaveAndContinueUrl().'\')',
					'class' => 'save'
   			))
		);
		return $this;
	}
	/**
	 * get the back button html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
 	public function getBackButtonHtml(){
		return $this->getChildHtml('back_button');
	}
	/**
	 * get the cancel button html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getCancelButtonHtml(){
		return $this->getChildHtml('reset_button');
	}
	/**
	 * get the save button html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSaveButtonHtml(){
		return $this->getChildHtml('save_button');
	}
	/**
	 * get the save and continue edit button html
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSaveAndEditButtonHtml(){
		return $this->getChildHtml('save_and_edit_button');
	}
	/**
	 * get the save and continue edit url
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getSaveAndContinueUrl(){
		return $this->getUrl('*/*/save', array(
			'_current'   => true,
			'back'   => 'edit',
			'tab'=> '{{tab_id}}',
			'active_tab' => null
		));
	}
	/**
	 * get the validation url
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getValidationUrl(){
		return $this->getUrl('*/*/validate', array('_current'=>true));
	}
	/**
	 * check if edit mode is read only
	 * @deprecated 1.3
	 * @access public
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function isReadonly(){
		return false;
	}
}