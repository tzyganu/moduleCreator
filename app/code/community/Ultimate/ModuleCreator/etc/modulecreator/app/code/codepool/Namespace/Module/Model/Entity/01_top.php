<?php
{{License}}
/**
 * {{EntityLabel}} model
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Model_{{Entity}} extends Mage_Core_Model_Abstract{
	/**
	 * constructor
	 * @access public
	 * @return void
	 * {{qwertyuiop}}
	 */
	public function _construct(){
		parent::_construct();
		$this->_init('{{module}}/{{entity}}');
	}
	/**
	 * before save {{entityLabel}}
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Model_{{Entity}}
	 * {{qwertyuiop}}
	 */
	protected function _beforeSave(){
		parent::_beforeSave();
		$now = Mage::getSingleton('core/date')->gmtDate();
		if ($this->isObjectNew()){
			$this->setCreatedAt($now);
		}
		$this->setUpdatedAt($now);
		return $this;
	}
