<?php

class Bizrate_Buyerssurvey_Model_System_Config_Source_Productattributes extends Mage_Core_Block_Template
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $array = array();
        foreach($this->getValues() as $k => $v)
        {
            $array[] = array('value' => $k, 'label'=>$v);
        }
        return $array;
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray(array $arrAttributes = Array())
    {
        return $this->getValues();
    }

    public function getValues()
    {
        $product = Mage::getModel('catalog/product');
        $attr = $product->getAttributes();
        $array = array();
        foreach($attr as $x)
        {
            if($x->getFrontendLabel() == '')
            {
                continue;
            }

            $array[$x->getAttributeCode()] = $x->getFrontendLabel();
        }
        return $array;
    }
}