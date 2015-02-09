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
class Stepzero_Slider_Block_Adminhtml_Slideritems_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('sliderGrid');
      $this->setDefaultSort('slideritems_title');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
	  $collection = Mage::getModel('slider/slider_items')->getResourceCollection();
	  
	  foreach ($collection as $view) {
      	if ( $view->getStoreId() && $view->getStoreId() != 0 ) {
            $view->setStoreId(explode(',',$view->getStoreId()));
        } else {
            $view->setStoreId(array('0'));
        }
	  }
		
	  
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  { 
      $this->addColumn('slideritem_id', array(
          'header'    => Mage::helper('slider')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'slideritem_id',
      ));
	  
      $this->addColumn('slideritem_title', array(
          'header'    => Mage::helper('slider')->__('Title'),
          'align'     =>'left',
          'index'     => 'slideritem_title',
      ));
	  
  
      $this->addColumn('slideritem_description', array(
          'header'    => Mage::helper('slider')->__('Description'),
          'align'     =>'left',
          'index'     => 'slideritem_description',
      ));

      $this->addColumn('slider_url', array(
          'header'    => Mage::helper('slider')->__('URL'),
          'align'     =>'left',
          'index'     => 'slider_url',
      ));
	  

		if ( !Mage::app()->isSingleStoreMode() ) {
			$this->addColumn('store_id', array(
				'header' => Mage::helper('slider')->__('Store View'),
				'index' => 'store_id',
				'type' => 'store',
				'store_all' => true,
				'store_view' => true,
				'sortable' => true,
				'filter_condition_callback' => array($this, '_filterStoreCondition'),
			));
		}


      $this->addColumn('slideritem_slider', array(
          'header'    => Mage::helper('slider')->__('Slider'),
          'align'     =>'left',
          'index'     => 'slideritem_slider',
      ));
	  
      $this->addColumn('slider_sort', array(
          'header'    => Mage::helper('slider')->__('Sort Order'),
          'align'     => 'left',
          'width'     => '90px',
          'index'     => 'slider_sort'
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


	protected function _filterStoreCondition($collection, $column)
	{
		if ( !$value = $column->getFilter()->getValue() ) {
			return;
		}
		$this->getCollection()->addStoreFilter($value);
	}


  protected function _prepareMassaction()
  {
	  $this->setMassactionIdField('slideritem_id');
	  $this->getMassactionBlock()->setFormFieldName('slideritem');

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
