<?php
/**
 * Stepzero
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
class Stepzero_Slider_Block_Adminhtml_Slideritems extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct(){
		$this->_controller = 'adminhtml_slideritems';
		$this->_blockGroup = 'slider';
		$this->_headerText = Mage::helper('slider')->__('Slider Items Manager');
		$this->_addButtonLabel = Mage::helper('slider')->__('Add Slider Item');
		parent::__construct();
	}
	
	

}
