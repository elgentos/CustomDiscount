<?php

class Elgentos_Customdiscount_Model_Mysql4_Discounts_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customdiscount/discounts');
    }
}