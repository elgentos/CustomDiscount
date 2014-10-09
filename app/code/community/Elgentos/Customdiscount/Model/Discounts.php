<?php
class Elgentos_Customdiscount_Model_Discounts extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('customdiscount/discounts');
    }
    
    public function loadByHash($hash) {
        $collection = $this->getCollection();
        foreach($collection as $discount) {
            if($discount->getHash()==$hash) return $discount;
        }
        return false;
    }

}