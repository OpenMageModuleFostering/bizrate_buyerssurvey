<?php
class Bizrate_Buyerssurvey_Block_Footer extends Mage_Core_Block_Template
{
    protected $_code = 'footer';

	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

    public function getMid()
    {
        return Mage::getStoreConfig('buyerssurvey/buyerssurvey/mid');
    }

    public function dontUseMedal()
    {
        return $this->useMedal() == "0";
    }

    public function hasMid()
    {
        return $this->getMid() != '';
    }

    public function isBlockActive()
    {
        return Mage::getStoreConfig('buyerssurvey/buyerssurvey/medal_position') == $this->_code;
    }

    public function useMedal()
    {
        return (string)Mage::getStoreConfig('buyerssurvey/buyerssurvey/enable_medal');
    }

    public function getMedalCode()
    {
        $mid = $this->getMid();

        $code = Mage::getStoreConfig('buyerssurvey/buyerssurvey/large_medal_html');

        if($this->useMedal() == 'small')
        {
            $code = Mage::getStoreConfig('buyerssurvey/buyerssurvey/small_medal_html');
        }

        $code = str_replace('__MID__',$this->getMid(),$code);
        $code = str_replace('__STORENAME__',Mage::getStoreConfig('general/store_information/name'),$code);

        return $code;
    }

    protected function _toHtml()
    {

        if (!$this->isBlockActive() || !$this->hasMid() || $this->dontUseMedal())
        {
            return '';
        }

        return parent::_toHtml();
    }

}
