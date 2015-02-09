<?php
/** * Stepzero
 *
 * NOTICE OF LICENSE
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Stepzero
 * @package     Stepzero_Slider
 * @copyright   Copyright (c) 2014 Stepzero. (http://www.stepzero.solutions)
 * @license     http://www.stepzero.solutions/magento/licenses/Stepzero_Slider
 */
class Stepzero_Slider_Block_Adminhtml_Slideritems_Edit_Tab_Image extends Mage_Adminhtml_Block_Widget_Form
{
	
    public function __construct()
    {
        $this->setTemplate('slider/image.phtml');
    }
	
	
    protected function _toHtml()
    {
        if( !Mage::registry('slideritems_data') ) {
            $this->assign('sliderimage', false);
            return parent::_toHtml();
        }

		
		$collection = Mage::getModel('slider/slider_items')->getCollection()
						->addFieldToSelect( array( 'slider_image_path' ) )
						->addFieldToFilter('slideritem_id', Mage::registry('slideritems_data')->getSlideritem_id() );
		$imagedata = $collection->getData();
        $this->assign('sliderimage', $imagedata[0]);
        return parent::_toHtml();
    }

  
	
}