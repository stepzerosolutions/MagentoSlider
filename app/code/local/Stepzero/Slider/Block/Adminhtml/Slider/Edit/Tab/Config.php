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
class Stepzero_Slider_Block_Adminhtml_Slider_Edit_Tab_Config extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('web_form', array('legend'=>Mage::helper('slider')->__('Slider Configuration')));

      $fieldset->addField('slider_width', 'text', array(
          'label'     => Mage::helper('slider')->__('Slider Width'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'slider_width',
          'maxlength' => '4',
          'size'      => '6',
      ));
	  
      $fieldset->addField('slider_height', 'text', array(
          'label'     => Mage::helper('slider')->__('Slider Height'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'slider_height',
          'maxlength' => '4',
          'size'      => '6',
      ));
	  
      $fieldset->addField('slider_duration', 'text', array(
          'label'     => Mage::helper('slider')->__('Slider Duration'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'slider_duration',
          'maxlength'      => '6',
          'size'      => '8',
      ));
		
     
     
      if ( Mage::getSingleton('adminhtml/session')->getSliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
          Mage::getSingleton('adminhtml/session')->setSliderData(null);
      } elseif ( Mage::registry('slider_data') ) {
          $form->setValues(Mage::registry('slider_data')->getData());
      }
      return parent::_prepareForm();
  }
}