<?php

$installer = $this;
$setup = new Mage_Catalog_Model_Resource_Eav_Mysql4_Setup('core_setup');
$installer->startSetup();

$setup->run("SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `{$this->getTable('customdiscount_discounts')}`;
CREATE TABLE `{$this->getTable('customdiscount_discounts')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `custom_price` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `used` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");


$setup->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'customdiscount', array(
        'group'         => 'General',
        'input'         => 'select',
        'type'          => 'int',
        'label'         => Mage::helper('customdiscount')->__('Discount request enabled'),
        'required'      => 0,
        'user_defined'  => 1,
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'source'                       => 'eav/entity_attribute_source_boolean',
        'visible'       => 1,
        'searchable'    => 0,
        'filterable'    => 0,
        'comparable'    => 0,
        'visible_on_front'          => 1,
        'visible_in_advanced_search'=> 0,
        'is_html_allowed_on_front'  => 0,
        'used_in_product_listing'  => 0,
        'position'     => 10
    )
);

$installer->endSetup();
