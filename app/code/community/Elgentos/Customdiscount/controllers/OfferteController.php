<?php
class Elgentos_Customdiscount_DiscountController extends Mage_Core_Controller_Front_Action {
    
    public function requestAction() {
        echo "<pre>";
        print_r($this->getRequest()->getParams());
        echo "</pre>";
        exit;
    }
    
}