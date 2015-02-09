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
    ALTER TABLE `{$installer->getTable('slider/slider_items')}` ADD `slider_url` VARCHAR( 200 ) NULL AFTER `slider_image_path` ;
");
$installer->endSetup();