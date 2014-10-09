<?php

class Elgentos_Customdiscount_Model_Observer {
    
    public function applyDiscounts(Varien_Event_Observer $observer)
    {
        foreach ($observer->getCart()->getQuote()->getAllVisibleItems() as $item /* @var $item Mage_Sales_Model_Quote_Item */) {
             if ($item->getParentItem()) {
                 $item = $item->getParentItem();
             }
    
             // Discounted 25% off
             $percentDiscount = 0.25;
    
             // This makes sure the discount isn't applied over and over when refreshing
             $specialPrice = $item->getPrice() - ($item->getPrice() * $percentDiscount);
    
             // Make sure we don't have a negative
             if ($specialPrice > 0) {
                 $item->setCustomPrice($specialPrice);
                 $item->setOriginalCustomPrice($specialPrice);
                 $item->getProduct()->setIsSuperMode(true);
             }
        }
    }
    
    public function applyDiscount(Varien_Event_Observer $observer)
    {
        /* @var $item Mage_Sales_Model_Quote_Item */
        $item = $observer->getQuoteItem();
        if ($item->getParentItem()) {
            $item = $item->getParentItem();
        }
    
        // Discounted 25% off
        $percentDiscount = 0.25;
        
        // This makes sure the discount isn't applied over and over when refreshing
        $specialPrice = $item->getProduct()->getPrice() - ($item->getProduct()->getPrice() * $percentDiscount);
        
        // Make sure we don't have a negative
        if ($specialPrice > 0) {
            $item->setCustomPrice($specialPrice);
            $item->setOriginalCustomPrice($specialPrice);
            $item->getProduct()->setIsSuperMode(true);
        }
    }
}
