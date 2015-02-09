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
class Stepzero_Slider_Model_Resource_Slider_Links_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
            $this->_init('slider/slider_links');
    }
	
	
    public function addAttributeToSelect($attribute = '*')
    {
        if ($attribute == '*') {
            // Save previous selected columns
            $columns = $this->getSelect()->getPart(Zend_Db_Select::COLUMNS);
            $this->getSelect()->reset(Zend_Db_Select::COLUMNS);
            foreach ($columns as $column) {
                if ($column[0] == 'main_table') {
                    // If column selected from main table,
                    // no need to select it again
                    continue;
                }

                // Joined columns
                if ($column[2] !== null) {
                    $expression = array($column[2] => $column[1]);
                } else {
                    $expression = $column[2];
                }
                $this->getSelect()->columns($expression, $column[0]);
            }

            $this->getSelect()->columns('*', 'main_table');
            return $this;
        }

        if (!is_array($attribute)) {
            $attribute = array($attribute);
        }

        $this->getSelect()->columns($attribute, 'main_table');
        return $this;
    }
	
    public function addAttributeToSort($attribute, $dir = self::SORT_ORDER_ASC)
    {
        if (!is_string($attribute)) {
            return $this;
        }
        $this->setOrder($attribute, $dir);
        return $this;
    }
	
	
    public function addSliderLinkFilter($Id)
    {
        $this->getSelect()->where("sliderlink_item  IN(?) ", $Id);
        return $this;
    }
} 