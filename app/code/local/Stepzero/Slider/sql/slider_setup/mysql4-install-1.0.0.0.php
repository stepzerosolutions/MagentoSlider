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
    CREATE TABLE `{$installer->getTable('slider/slider')}` (
      `slider_id` int(11) NOT NULL auto_increment,
      `slider_title` varchar(200),
      `slider_description` text,
      `date` datetime default NULL,
      `status` tinyint(1) NULL DEFAULT '0',
      `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
      PRIMARY KEY  (`slider_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	
	
    CREATE TABLE `{$installer->getTable('slider/slider_items')}` (
      `slideritem_id` int(11) NOT NULL auto_increment,
      `slideritem_slider` tinyint(5) NOT NULL,
      `slideritem_title` varchar(200) NULL,
      `slideritem_description` text NULL,
      `slider_image_path` text NOT NULL,
      `status` tinyint(1) NULL DEFAULT '0',
      `date` datetime default NULL,
      `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
      PRIMARY KEY  (`slideritem_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();