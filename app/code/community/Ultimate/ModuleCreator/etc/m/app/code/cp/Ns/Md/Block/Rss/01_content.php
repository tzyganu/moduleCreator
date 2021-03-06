<?php 
{{License}}
/**
 * {{Module}} RSS block
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Block_Rss extends Mage_Core_Block_Template{
	protected $_feeds = array();
	/**
	 * add a new feed
	 * @access public
	 * @param string $label
	 * @param string $url
	 * @param bool $prepare
	 * @return {{Namespace}}_{{Module}}_Block_Rss
	 * {{qwertyuiop}}
	 */
	public function addFeed($label, $url, $prepare = false){
		$link = ($prepare ? $this->getUrl($url) : $url);
		$feed = new Varien_Object();
		$feed->setLabel($label);
		$feed->setUrl($link);
		$this->_feeds[$link] = $feed;
		return $this;
	}
	/**
	 * get the current feeds
	 * @access public
	 * @return array()
	 * {{qwertyuiop}}
	 */
	public function getFeeds(){
		return $this->_feeds;
	}
} 