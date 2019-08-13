<?php

class Bizrate_Buyerssurvey_Model_Observer extends Mage_Core_Block_Template
{

    public function _order_success_page($observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('buyerssurvey');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }

    public function updateConfig($observer)
    {
        $parts = $observer->getEvent();

        if (!Mage::getStoreConfig('buyerssurvey/buyerssurvey/enabled') || !Mage::getStoreConfig('buyerssurvey/buyerssurvey/mid'))
        {
            return '';
        }

        $config = new Mage_Core_Model_Config();

        $collection = Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', 'buyerssurvey/buyerssurvey/medal_position');

        $found_scopes = array();
        foreach($collection as $conf_data)
        {
            $configs = array(
                'buyerssurvey/buyerssurvey/medal_footer' => 0,
                'buyerssurvey/buyerssurvey/medal_left' => 0,
                'buyerssurvey/buyerssurvey/medal_sidebar' => 0,
            );
//            foreach($configs as $k => $v)
            //          {

            switch($conf_data->getValue())
            {
                case 'left':
                    $configs['buyerssurvey/buyerssurvey/medal_left'] = 1;
                    break;
                case 'right':
                    $configs['buyerssurvey/buyerssurvey/medal_sidebar'] = 1;
                    break;
                case 'footer':
                    $configs['buyerssurvey/buyerssurvey/medal_footer'] = 1;
                    break;
                default:
                    $configs = array(
                        'buyerssurvey/buyerssurvey/medal_footer' => 0,
                        'buyerssurvey/buyerssurvey/medal_left' => 0,
                        'buyerssurvey/buyerssurvey/medal_sidebar' => 0,
                    );
                    break;
            }

            $found_scopes[] = $conf_data->getScopeId();
            foreach($configs as $k => $v)
            {
                $config->saveConfig($k, $v, $conf_data->getScope(), $conf_data->getScopeId());
            }

            // because we inject config values.
            // we need to remove the scopes if they dont exist now.
            $configs_to_clean = array('buyerssurvey/buyerssurvey/medal_footer', 'buyerssurvey/buyerssurvey/medal_left', 'buyerssurvey/buyerssurvey/medal_sidebar' );

            $collection = Mage::getModel('core/config_data')->getCollection()
                ->addFieldToFilter('path', array('in' => $configs_to_clean))
                ->addFieldToFilter('scope_id', array('nin' => $found_scopes));
            foreach($collection as $conf_data)
            {
                $conf_data->delete();
            }
        }

        Mage::getConfig()->reinit();
        Mage::app()->reinitStores();

    }
}