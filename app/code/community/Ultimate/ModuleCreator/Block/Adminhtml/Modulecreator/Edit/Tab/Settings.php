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
 * settings tab block
 * 
 * @category	Ultimate
 * @package		Ultimate_ModuleCreator
 * @author 		Marius Strajeru <marius.strajeru@gmail.com>
 */
class Ultimate_ModuleCreator_Block_Adminhtml_Modulecreator_Edit_Tab_Settings extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{
 	/**
	 * Return Tab label
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabLabel(){
		return Mage::helper('modulecreator')->__('General Settings');
	}
	/**
	 * Return Tab title
	 * @access public
	 * @return string
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	public function getTabTitle(){
		return Mage::helper('modulecreator')->__('General Settings');
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
		return false;
	}
	/**
	 * prepare the form
	 * @access public
	 * @return Ultimate_ModuleCreator_Block_Adminhtml_Edit_Tab_Settings
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('settings_');
		$fieldWidth = '255';
		$fieldset = $form->addFieldset('settings_fieldset', array('legend'=>Mage::helper('modulecreator')->__('General Information')));
		$data = Mage::registry('current_module');
		if ($data){
			$values = new Varien_Object($data->asArray());
		}
		else{
			$values = new Varien_Object(Mage::getStoreConfig('modulecreator/settings'));
		}
		$fieldset->addField('current_extension', 'hidden', array(
			'name'  => 'current_extension',
			'value'	=> $values->getExtension()
		));
		$fieldset->addField('namespace', 'text', array(
			'name'  			=> 'namespace',
			'label' 			=> Mage::helper('modulecreator')->__('Namespace'),
			'title' 			=> Mage::helper('modulecreator')->__('Namespace'),
			'required'  		=> true,
			'style'				=> 'width:'.$fieldWidth.'px',
			'value'				=> $values->getNamespace(),
			'class'				=> 'validate-alphanum',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Namespace'), Mage::helper('modulecreator')->__('This is the folder name of your new extension. Your company name could go here. Use only letters and numbers. Start with a capital letter.'))
		));
		$fieldset->addField('module_name', 'text', array(
			'name'  			=> 'module_name',
			'label' 			=> Mage::helper('modulecreator')->__('Module name'),
			'title' 			=> Mage::helper('modulecreator')->__('Module name'),
			'required'  		=> true,
			'value'				=> $values->getModuleName(),
			'class'				=> 'validate-alphanum',
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Module name'), Mage::helper('modulecreator')->__('This is your extension name. You cannot name your extension with an existing name, not even under a different namespace.'))
		));
		$fieldset->addField('codepool', 'select', array(
			'name'  			=> 'codepool',
			'label' 			=> Mage::helper('modulecreator')->__('Code pool'),
			'title' 			=> Mage::helper('modulecreator')->__('Code pool'),
			'options'			=> Mage::getModel('modulecreator/adminhtml_system_config_source_codepool')->getAllOptions(),
			'required'  		=> true,
			'value'				=> $values->getCodepool(),
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Code pool'), Mage::helper('modulecreator')->__('This is the code folder in which your extension will be installed. If you don\'t know what goes here, choose "local"'))
		));
		$installOptions = array(
			'name'  			=> 'install',
			'label' 			=> Mage::helper('modulecreator')->__('Action'),
			'title' 			=> Mage::helper('modulecreator')->__('Action'),
			'options'			=> Mage::getModel('modulecreator/adminhtml_system_config_source_install')->getAllOptions(),
			'required'  		=> true,
			'value'				=> $values->getInstall(),
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Action'), Mage::helper('modulecreator')->__('This allows you to create an archive with your extension located in var/modulecreator folder of your current instance so you can edit it later or install it later manually by copying the "app" folder in the archive over the "app" folder of your instance and the "skin" folder in the archive over the "skin" folder of your instance. If you choose to install it directly please backup first. If you choose to install it you will be able to edit later but you will have to install the modified version manually.' ))
		);
		if (!$this->_canInstall()){
			$installOptions['disabled'] = 'disabled';
			$installOptions['value'] 	= 0;
		}
		$fieldset->addField('install', 'select', $installOptions);
		$fieldsetDesign = $form->addFieldset('settings_design_fieldset', array('legend'=>Mage::helper('modulecreator')->__('Design')));
		$fieldsetDesign->addField('front_package', 'text', array(
			'name'  			=> 'front_package',
			'label' 			=> Mage::helper('modulecreator')->__('Frontend package'),
			'title' 			=> Mage::helper('modulecreator')->__('Frontend package'),
			'required'  		=> true,
			'value'				=> ($values->getFrontPackage()) ? $values->getFrontPackage() : Mage_Core_Model_Design_Package::BASE_PACKAGE,
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Frontend package'), Mage::helper('modulecreator')->__('This is the name of the design interface (package) of your mangento instance. If you don\'t know what goes here put "base".' ))
		));
		$fieldsetDesign->addField('front_templates', 'text', array(
			'name'  			=> 'front_templates',
			'label' 			=> Mage::helper('modulecreator')->__('Frontend theme - templates'),
			'title' 			=> Mage::helper('modulecreator')->__('Frontend theme - templates'),
			'required'  		=> true,
			'value'				=> ($values->getFrontTemplates()) ? $values->getFrontTemplates() : Mage_Core_Model_Design_Package::DEFAULT_THEME,
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Frontend theme - templates'), Mage::helper('modulecreator')->__('This is the name of the theme of your mangento instance for the template files. If you don\'t know what goes here put "default".' ))
		));
		$fieldsetDesign->addField('front_layout', 'text', array(
			'name'  			=> 'front_layout',
			'label' 			=> Mage::helper('modulecreator')->__('Frontend theme - layout'),
			'title' 			=> Mage::helper('modulecreator')->__('Frontend theme - layout'),
			'required'  		=> true,
			'value'				=> ($values->getFrontLayout()) ? $values->getFrontLayout() : Mage_Core_Model_Design_Package::DEFAULT_THEME,
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Frontend theme - layout'), Mage::helper('modulecreator')->__('This is the name of the theme of your mangento instance for the layout files. If you don\'t know what goes here put "default".' ))
		));
		
		$fieldsetDesign = $form->addFieldset('settings_additional_fieldset', array('legend'=>Mage::helper('modulecreator')->__('Additional')));
		$fieldsetDesign->addField('license', 'textarea', array(
			'name'  			=> 'license',
			'label' 			=> Mage::helper('modulecreator')->__('License'),
			'title' 			=> Mage::helper('modulecreator')->__('License'),
			'required'  		=> false,
			'value'				=> $values->getLicense(),
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('License'), Mage::helper('modulecreator')->__('Added at the top of every generated file.').'<br />'.Mage::helper('modulecreator')->__('Use {{Namespace}} as a placeholder for namespace, {{Module}} as a placeholder for the module name and {{Y}} for current year.'))
		));
		$fieldsetDesign->addField('sort_order', 'text', array(
			'name'  			=> 'sort_order',
			'label' 			=> Mage::helper('modulecreator')->__('Menu sort order'),
			'title' 			=> Mage::helper('modulecreator')->__('Menu sort order'),
			'required'  		=> true,
			'value'				=> $values->getSortOrder(),
			'note'				=> Mage::helper('modulecreator')->__('See current menus sort order <a href="#" onclick="%s">here</a>', 'showMenuOrder(1);return false;'),
			'style'				=> 'width:'.$fieldWidth.'px',
			'after_element_html'=> Mage::helper('modulecreator/adminhtml')->getTooltipHtml(Mage::helper('modulecreator')->__('Menu sort order'), Mage::helper('modulecreator')->__('This sets the position of your extension menu in the entire admin menu.'))
		));
		$this->setForm($form);
		$form->addFieldNameSuffix('settings');
		return parent::_prepareForm();
	}
	/**
	 * check if module can be installer
	 * @access protected
	 * @return bool
	 * @author Marius Strajeru <marius.strajeru@gmail.com>
	 */
	protected function _canInstall(){
		if (!Mage::helper('modulecreator')->canInstall()){
			return false;
		}
		if (Mage::registry('module_read_only')){
			return false;
		}
		if ($module = Mage::registry('current_module')){
			$installedModules = array_keys((array)Mage::getConfig()->getNode('modules')->children());
			foreach ($installedModules as $installed){
				if ($installed == $module->extension){
					Mage::register('module_read_only', true);
					return false;
				}
			}
		}
		return true;
	}
}