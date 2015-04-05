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
class Stepzero_Slider_Block_Adminhtml_Slideritems_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('web_form', array('legend'=>Mage::helper('slider')->__('Slider Item Information')));
 
	  
      $fieldset->addField('slideritem_title', 'text', array(
          'label'     => Mage::helper('slider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'slideritem_title',
      ));


	  
      $fieldset->addField('slideritem_description', 'editor', array(
          'label'     => Mage::helper('slider')->__('Description'),
          'name'      => 'slideritem_description',
		  'wysiwyg'   => true,
      ));
	  
      $fieldset->addField('slider_url', 'text', array(
          'label'     => Mage::helper('slider')->__('URL'),
          'name'      => 'slider_url',
      ));
	  
      $fieldset->addField('slideritem_slider', 'select', array(
          'label'     => Mage::helper('slider')->__('Slider'),
          'name'      => 'slideritem_slider',
		  'required'  => true,
          'values'    => $this->getSlidertitleOptionsArray(),
      ));
	  
      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('slider')->__('Slider Image'),
          'required'  => false,
          'name'      => 'filename',
	  ));
	  
	//if (!Mage::app()->isSingleStoreMode()) {
		$fieldset->addField('store_id', 'multiselect', array(
			'name' => 'stores[]',
			'label' => Mage::helper('slider')->__('Store View'),
			'title' => Mage::helper('slider')->__('Store View'),
			'required' => true,
			'values' => Mage::getSingleton('adminhtml/system_store')
						 ->getStoreValuesForForm(false, true),
		));
	//}else {
		//$fieldset->addField('store_id', 'hidden', array(
		//	'name' => 'stores[]',
		//	'value' => Mage::app()->getStore(true)->getId()
		//));
	//}

		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slider')->__('Enabled'),
              ),

              array(
                  'value'     => 0,
                  'label'     => Mage::helper('slider')->__('Disabled'),
              ),
          ),
      ));
     
 	
      $fieldset->addField('slider_sort', 'text', array(
          'label'     => Mage::helper('slider')->__('Sort Order'),
          'name'      => 'slider_sort',
          'class' 		=> 'validate-digits',
      ));
	
      if ( Mage::getSingleton('adminhtml/session')->getSliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
          Mage::getSingleton('adminhtml/session')->setSliderData(null);
      } elseif ( Mage::registry('slideritems_data') ) {
          $form->setValues(Mage::registry('slideritems_data')->getData());
      }
      return parent::_prepareForm();
  }
  
    /**
     * Retrieve array (sliders => slider_name) of available sliders
     *
     * @return array
     */
    public function getSlidertitleOptionsArray()
    {
		$sliders = $this->getSliderOptionArray();
        array_unshift($sliders, array(
            'value' => '',
            'label' => Mage::helper('slider')->__('-- Please Select --')
        ));
        return $sliders;
    }
	
    public function getSliderInstance()
    {
        return Mage::registry('current_slideritems');
    }
	
	
    /**
     * Retrieve option array of widget types
     *
     * @return array
     */
    public function getSliderOptionArray()
    {
		$slidersArray = array();
		$sliders = Mage::getModel('slider/slider')->getResourceCollection()
	   ->addFieldToSelect(array('slider_id', 'slider_title'))
	   ->addFieldToFilter('status', array('eq' => '1'))
		->getData();
        foreach ($sliders as $slider) {
            $slidersArray[] = array(
                'value' => $slider['slider_id'],
                'label' => $slider['slider_title']
            );
        }
        return $slidersArray;
    }
	
	
}