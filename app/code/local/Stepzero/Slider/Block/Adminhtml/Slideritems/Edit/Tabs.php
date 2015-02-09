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
class Stepzero_Slider_Block_Adminhtml_Slideritems_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('slider_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('slider')->__('Slider Items'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('slider')->__('Slider Item Information'),
          'title'     => Mage::helper('slider')->__('Slider Item Information'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slideritems_edit_tab_form')->toHtml(),
      ));
      $this->addTab('form_links', array(
          'label'     => Mage::helper('slider')->__('Slider Image Links'),
          'title'     => Mage::helper('slider')->__('Slider Image Links'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slideritems_edit_tab_links')->toHtml(),
      ));
      $this->addTab('form_manual_image', array(
          'label'     => Mage::helper('slider')->__('Slider Image manual'),
          'title'     => Mage::helper('slider')->__('Slider Image manual'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slideritems_edit_tab_manual')->toHtml(),
      ));
      $this->addTab('form_image', array(
          'label'     => Mage::helper('slider')->__('Slider Image'),
          'title'     => Mage::helper('slider')->__('Slider Image'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slideritems_edit_tab_image')->toHtml(),
      ));

     
      return parent::_beforeToHtml();
  }
}