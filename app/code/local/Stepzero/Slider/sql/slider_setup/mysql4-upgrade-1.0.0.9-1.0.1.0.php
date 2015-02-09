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
 * @license     http://www.stepzero.solutions/licenses/Stepzero_Slider
 */
$installer = $this;
$installer->startSetup();
$installer->run("
    ALTER TABLE `{$installer->getTable('slider/slider')}` ADD `slider_width` INT( 4 ) NULL DEFAULT '600' AFTER `slider_description` ;
    ALTER TABLE `{$installer->getTable('slider/slider')}` ADD `slider_height` INT( 4 ) NULL DEFAULT '400' AFTER `slider_width` ;
    ALTER TABLE `{$installer->getTable('slider/slider')}` ADD `slider_duration` INT( 6 ) NULL DEFAULT '5000' AFTER `slider_height` ;
");
$installer->endSetup();