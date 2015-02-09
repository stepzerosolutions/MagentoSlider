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
class Stepzero_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
	parent::__construct();
    $this->setId('sliderGrid');
    $this->setDefaultSort('slider_title');
    $this->setDefaultDir('ASC');
    $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('slider/slider')->getResourceCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  { 
      $this->addColumn('slider_id', array(
          'header'    => Mage::helper('slider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'slider_id',
      ));

      $this->addColumn('slider_title', array(
          'header'    => Mage::helper('slider')->__('Title'),
          'align'     =>'left',
          'index'     => 'slider_title',
      ));
	  
      $this->addColumn('slider_description', array(
          'header'    => Mage::helper('slider')->__('Description'),
          'align'     =>'left',
          'index'     => 'slider_description',
      ));


	  
      $this->addColumn('slider_width', array(
          'header'    => Mage::helper('slider')->__('Width'),
          'align'     =>'center',
		  'width'     => '80px',
          'index'     => 'slider_width',
      ));


	  
      $this->addColumn('slider_height', array(
          'header'    => Mage::helper('slider')->__('Height'),
          'align'     =>'center',
		  'width'     => '80px',
          'index'     => 'slider_height',
      ));


	  
      $this->addColumn('slider_duration', array(
          'header'    => Mage::helper('slider')->__('Duration'),
          'align'     =>'center',
		  'width'     => '80px',
          'index'     => 'slider_duration',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('slider')->__('Status'),
          'align'     => 'left',
          'width'     => '90px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              0 => 'Disabled',
          ),
      ));
	  
	  $this->addColumn('action',
		  array(
			  'header'    =>  Mage::helper('slider')->__('Action'),
			  'width'     => '100',
			  'type'      => 'action',
			  'getter'    => 'getId',
			  'actions'   => array(
				  array(
					  'caption'   => Mage::helper('slider')->__('Edit'),
					  'url'       => array('base'=> '*/*/edit'),
					  'field'     => 'id'
				  )
			  ),
			  'filter'    => false,
			  'sortable'  => false
	  ));
		
      return parent::_prepareColumns();
  }

  protected function _prepareMassaction()
  {
	  $this->setMassactionIdField('slider_id');
	  $this->getMassactionBlock()->setFormFieldName('slider');

	  $this->getMassactionBlock()->addItem('delete', array(
		   'label'    => Mage::helper('slider')->__('Delete'),
		   'url'      => $this->getUrl('*/*/massDelete'),
		   'confirm'  => Mage::helper('slider')->__('Are you sure?')
	  ));

	  $statuses = Mage::getSingleton('slider/status')->getOptionArray();

	  array_unshift($statuses, array('label'=>'', 'value'=>''));
	  $this->getMassactionBlock()->addItem('status', array(
		   'label'=> Mage::helper('slider')->__('Change status'),
		   'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
		   'additional' => array(
				  'visibility' => array(
					   'name' => 'status',
					   'type' => 'select',
					   'class' => 'required-entry',
					   'label' => Mage::helper('slider')->__('Status'),
					   'values' => $statuses
				   )
		   )
	  ));
	  return $this;
  }
	
	
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }}
