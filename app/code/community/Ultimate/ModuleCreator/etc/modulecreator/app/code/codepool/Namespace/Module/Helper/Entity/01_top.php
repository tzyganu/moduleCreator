<?php 
{{License}}
/**
 * {{EntityLabel}} helper
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Helper_{{Entity}} extends Mage_Core_Helper_Abstract{
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * {{qwertyuiop}}
	 */
	public function getUseBreadcrumbs(){
		return Mage::getStoreConfigFlag('{{module}}/{{entity}}/breadcrumbs');
	}
