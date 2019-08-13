<?php
class Bizrate_Buyerssurvey_Block_Buyerssurvey extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
        //mage::log(__METHOD__ . __LINE__);
		return parent::_prepareLayout();
    }

    protected function _construct()
    {
        //$this->setTemplate('buyerssurvey/buyerssurvey.phtml');
        //mage::log(__METHOD__ . __LINE__);
        parent::_construct();
        //mage::log(__METHOD__ . __LINE__ . " TMPL " . $this->getTemplate());
    }



//     public function getBuyerssurvey()
//     {
//        if (!$this->hasData('buyerssurvey')) {
//            $this->setData('buyerssurvey', Mage::registry('buyerssurvey'));
//        }
//        return $this->getData('buyerssurvey');
//
//    }

    public function getOrder()
    {
        if(!$this->_order)
        {
            $orderId = $this->getOrderId();
            if($orderId)
            {
                $this->_order = Mage::getModel('sales/order')->load($orderId);
            }
        }
        return $this->_order;
    }

    public function getOrderId()
    {
        $orderIds = $this->getOrderIds();
        if(is_array($orderIds) && count($orderIds))
        {
            return $orderIds[0];
        }
        return false;
    }

    public function getOrderTotal()
    {
        $order = $this->getOrder();

        if (!is_object($order) || !$order->getId())
        {
            return '0.00';
        }

        return number_format($order->getBaseSubtotal(),2);
    }

    public function getBillingPostal()
    {
        $order = $this->getOrder();

        if (!is_object($order) || !$order->getId())
        {
            return;
        }

        if ($order->getIsVirtual()) {
            $address = $order->getBillingAddress();
        } else {
            $address = $order->getShippingAddress();
        }
        return $address->getPostcode();
    }

    public function getGtinField()
    {
        return Mage::getStoreConfig('buyerssurvey/buyerssurvey/product_gtin_field');
    }

    public function getMid()
    {
        return Mage::getStoreConfig('buyerssurvey/buyerssurvey/mid');
    }

    public function _outPutCleanedText($x)
    {
        $x = str_replace("'","",$x);
        $x = str_replace("^","",$x);
        return $x;
    }

    public function getProductsPurchased()
    {
        $order = $this->getOrder();

        $blank_row = "URL=^SKU=^GTIN=^PRICE=";
        if (!is_object($order) || !$order->getId())
        {
            return $blank_row;
        }
                //'URL=^SKU=^GTIN=^PRICE=|URL=^SKU=^GTIN=^PRICE=|URL=^SKU=^GTIN=^PRICE=|URL=^SKU=^GTIN=^PRICE=|URL=^SKU=^GTIN=^PRICE='
        $product_data = '';
        $count = 0;
        $max = 4;
        // we can only have 5
        foreach ($order->getAllVisibleItems() as $item)
        {
            if($count > $max)
            {
                break;
            }
            $par = false;
            //mage::log("item->getSku():" . $item->getSku());
            //mage::log("item->getId():" . $item->getId());
            //mage::log("item->getProductId():" . $item->getProductId());

			//circumventing the SKU issue
			$product = Mage::getModel('catalog/product')->load($item->getProductId());
			
			/*
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku()); 
            $px = (array)$product; 
            if (empty($px)) {
            	$product = Mage::getModel('catalog/product')->load($item->getProductId());
            }
            */

            $par = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($product->getId());
            //adding conf product related code
            if ((!$par) || ($par == "")) {
	            $gtin = $this->_outPutCleanedText($product->getData($this->getGtinField()));
	            $price = number_format($item->getBasePrice(),2);
	            $sku = $this->_outPutCleanedText($product->getSku());	
            } else {
            	$par = Mage::getModel('catalog/product_type_configurable')->getParentIdsByChild($product->getId());
            	$product = Mage::getModel('catalog/product')->load($par[0]);
	            $gtin = $this->_outPutCleanedText($product->getData($this->getGtinField()));
	            $price = number_format($item->getBasePrice(),2);
	            $sku = $this->_outPutCleanedText($product->getSku());
            }
/* old
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $item->getSku());
            $gtin = $this->_outPutCleanedText($product->getData($this->getGtinField()));
            $price = number_format($item->getBasePrice(),2);
            $sku = $this->_outPutCleanedText($item->getSku());
*/

            if(!$gtin)
            {
                $gtin = $sku;
            }
            $gtin = '';

            if($product_data != '')
            {
                $product_data .= "|";
            }

            $product_data .= "URL={$product->getProductUrl()}^SKU={$sku}^GTIN={$gtin}^PRICE={$price}";
            $count++;
        }

        if($product_data == '')
        {
            $product_data = $blank_row;
        }

        return $product_data;
    }

    protected function _toHtml()
    {
//        mage::log(__METHOD__ . __LINE__);
        if(!strstr(mage::helper('core/url')->getCurrentUrl(), 'checkout/onepage/success'))
        {
//            mage::log(__METHOD__ . __LINE__);
            return '';
        }

        if (!Mage::getStoreConfig('buyerssurvey/buyerssurvey/enabled') || !Mage::getStoreConfig('buyerssurvey/buyerssurvey/mid'))
        {
//            mage::log(__METHOD__ . __LINE__);
            return '';
        }
//        mage::log(__METHOD__ . __LINE__);
        return parent::_toHtml();
    }

}
