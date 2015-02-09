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
class Stepzero_Slider_Block_Adminhtml_Slideritems_Edit_Tab_Links extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        $this->setTemplate('slider/list.phtml');
    }

    protected function _toHtml()
    {
        if( !Mage::registry('slideritems_data') ) {
            $this->assign('sliderlinks', false);
            return parent::_toHtml();
        }

		
        $collection = Mage::getModel('slider/slider_links')
            ->getResourceCollection()
            ->addSliderLinkFilter( Mage::registry('slideritems_data')->getSlideritem_id() )
			->load();
        $this->assign('sliderlinks', $collection);
        return parent::_toHtml();
    }

    protected function _prepareLayout()
    {
        $this->setChild('deleteButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('slider')->__('Delete'),
                    'onclick'   => 'newlink.del(this)',
                    'class' => 'delete'
                ))
        );

        $this->setChild('addButton',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
                    'label'     => Mage::helper('slider')->__('Add New Link'),
                    'onclick'   => 'newlink.add(this)',
                    'class' => 'add'
                ))
        );
        return parent::_prepareLayout();
    }

    public function getDeleteButtonHtml()
    {
        return $this->getChildHtml('deleteButton');
    }

    public function getAddButtonHtml()
    {
        return $this->getChildHtml('addButton');
    }
  
	
}