<?php
class Elgentos_Customdiscount_Model_Mysql4_Discounts extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('customdiscount/discounts', 'id');
    }

    protected function _setResourceModel($resourceName, $resourceCollectionName=null) {
       $this->_resourceName = $resourceName;
       if (is_null($resourceCollectionName)) {
           $resourceCollectionName = $resourceName.'_collection';
       }
       $this->_resourceCollectionName = $resourceCollectionName;
   }
}