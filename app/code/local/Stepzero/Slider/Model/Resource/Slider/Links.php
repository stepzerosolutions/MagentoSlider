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
 * @package     Stepzero_Productturn
 * @copyright   Copyright (c) 2014 Stepzero. (http://www.stepzero.solutions)
 * @license     http://www.stepzero.solutions/licenses/Stepzero_Productturn
 */
class Stepzero_Slider_Model_Resource_Slider_Links extends Mage_Core_Model_Resource_Db_Abstract{
	public function _construct(){
		$this->_init('slider/slider_links', 'sliderlink_id');
	}
}