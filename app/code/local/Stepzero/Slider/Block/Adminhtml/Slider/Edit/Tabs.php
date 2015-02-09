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
class Stepzero_Slider_Block_Adminhtml_Slider_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('slider_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('slider')->__('Slider Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('slider')->__('Slider Item Information'),
          'title'     => Mage::helper('slider')->__('Slider Item  Information'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slider_edit_tab_form')->toHtml(),
      ));
	  
      $this->addTab('form_config', array(
          'label'     => Mage::helper('slider')->__('Slider Configuration'),
          'title'     => Mage::helper('slider')->__('Slider Configuration'),
          'content'   => $this->getLayout()->createBlock('slider/adminhtml_slider_edit_tab_config')->toHtml(),
      ));
      return parent::_beforeToHtml();
  }
}