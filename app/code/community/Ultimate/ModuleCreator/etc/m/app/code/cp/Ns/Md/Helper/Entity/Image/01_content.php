<?php 
{{License}}
/**
 * {{EntityLabel}} image helper
 *
 * @category	{{Namespace}}
 * @package		{{Namespace}}_{{Module}}
 * {{qwertyuiop}}
 */
class {{Namespace}}_{{Module}}_Helper_{{Entity}}_Image extends Mage_Core_Helper_Data{
	/**
	 * image placeholder
	 * @var string
	 */
	protected $_placeholder = 'images/placeholder/{{entity}}.jpg';
	/**
	 * image processor class name
	 * @var string
	 */
	protected $_imageProcessorClass = 'Varien_Image_Adapter_Gd2';
	/**
	 * image processor
	 * @var null|Varien_Image_Adapter_Gd2
	 */
	protected $_imageProcessor = null;
	/**
	 * image to process
	 * @var null|string
	 */
	protected $_image = null;
	/**
	 * resize width
	 * @var null|int
	 */
	protected $_width = null;
	/**
	 * resize height
	 * @var null|int
	 */
	protected $_height = null;
	/**
	 * resized image folder name
	 * @var string
	 */
	protected $_resizeFolderName = 'cache';
	/**
	 * image base path
	 * @var sting
	 */
	protected $_basePath = '{{entity}}';
	/**
	 * image path
	 * @var string
	 */
	protected $_imagePath = 'image';
	/**
	 * get the image path for {{entityLabel}}
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getImageBaseDir(){
		return Mage::getBaseDir('media').DS.'{{entity}}'.DS.'image';
	}
	/**
	 * get the image url for {{entityLabel}}
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function getImageBaseUrl(){
		return Mage::getBaseUrl('media').'{{entity}}'.'/'.'image';
	}
	/**
	 * init image
	 * @access public
	 * @param Varien_Object $object
	 * @param string $imageField
	 * @return {{Namespace}}_{{Module}}_Helper_{{Entity}}_Image
	 * {{qwertyuiop}}
	 */
	public function init(Varien_Object $object, $imageField = '{{firstImageField}}'){
		$this->_reset();
		$this->_image = $object->getData($imageField);
		try{
			$this->_getImageProcessor()->open($this->getImageBaseDir().$this->_image);
		}
		catch (Exception $e){
			$this->_getImageProcessor()->open(Mage::getDesign()->getSkinUrl($this->_placeholder));
			$this->_image = '/'.$this->_placeholder;
		}
		return $this;
	}
	/**
	 * reset the image processor
	 * @access protected
	 * @return {{Namespace}}_{{Module}}_Helper_{{Entity}}_Image
	 * {{qwertyuiop}}
	 */
	protected function _reset(){
		$this->_imageProcessor = null;
		$this->_image = null;
		$this->_width = null;
		$this->_height = null;
		return $this;
	}
	/**
	 * get the image processor
	 * @access protected 
	 * @return Varien_Image_Adapter_Gd2
	 * {{qwertyuiop}}
	 */
	protected function _getImageProcessor(){
		if (is_null($this->_imageProcessor)){
			$class = $this->_imageProcessorClass;
			$this->_imageProcessor = new $class();
		}
		return $this->_imageProcessor;
	}
	/**
	 * resize image
	 * @access public
	 * @param int $width - defaults to null
	 * @param int $height - defaults to null
	 * @return {{Namespace}}_{{Module}}_Helper_{{Entity}}_Image
	 * {{qwertyuiop}}
	 */
	public function resize($width = null, $height = null){
		$this->_width = $width;
		$this->_height = $height;
		$this->_getImageProcessor()->keepAspectRatio(true);
		$this->_getImageProcessor()->keepTransparency(true);
		$this->_getImageProcessor()->resize($width, $height);
		return $this;
	}
	/**
	 * to string - no need for cache expire because the image names will be different
	 * @access public
	 * @return string
	 * {{qwertyuiop}}
	 */
	public function __toString(){
		try{
			$width = $this->_width;
			$height = $this->_height;
			$imageRealPath = $this->getImageBaseDir().DS.$this->_resizeFolderName.DS.$width.'x'.$height.$this->_image;
			if (!file_exists($imageRealPath)){
				$this->_getImageProcessor()->save($imageRealPath);
			}
			return $this->getImageBaseUrl().'/'.$this->_resizeFolderName.'/'.$width.'x'.$height.$this->_image;
		}
		catch (Exception $e){
			Mage::logException($e);
			return '';
		}
	}
}