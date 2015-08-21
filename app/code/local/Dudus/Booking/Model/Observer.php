<?php

class Dudus_Booking_Model_Observer {

    /**
     * Flag to stop observer executing more than once
     *
     * @var static bool
     */
    static protected $_singletonFlag = false;

    public function updateBookingConfig($oldConfig, $data) {
        foreach ($data as $key => $value) {
            if ($key != 'days') {
                $oldConfig->setData($key, $value);
            } else {
                $configId = $oldConfig->getId();
                $i = 1;
                foreach ($value as $key => $days) {
                    $dailySchedule = Mage::getModel('booking/configuration_dailySchedule')->getCollection()
                                    ->addFieldToFilter(
                                            'configuration_id', array('eq' => $configId)
                                    )
                                    ->addFieldToFilter(
                                            'day_id', array('eq' => $i)
                                    )->getFirstItem();
                    $dailySchedule->setData('start_time', $days['start']);
                    $dailySchedule->setData('end_time', $days['end']);
//                    print_r($dailySchedule->getData());die();
//                    $dailyData = array(
//                        'configuration_id' => $configId,
//                        'day_id' => $i,
//                        'day_name' => $key,
//                        'start_time' => $days['start'],
//                        'end_time' => $days['end']
//                    );
//                    $dailySchedule->setData($dailyData);
                    $dailySchedule->save();
                    $i++;
                }
            }
        }
        return $oldConfig;
    }
    
    public function createDailySchedule($configId,$data){
        $i=1;
        foreach ($data as $key => $value) {
                    $dailySchedule = Mage::getModel('booking/configuration_dailySchedule');
                    $dailyData = array(
                        'configuration_id' => $configId,
                        'day_id' => $i,
                        'day_name' => $key,
                        'start_time' => $value['start'],
                        'end_time' => $value['end']
                    );
                    $dailySchedule->setData($dailyData);
                    $dailySchedule->save();
                    $i++;
                }
    }

    /**
     * This method will run when the product is saved from the Magento Admin
     * Use this function to update the product model, process the 
     * data or anything you like
     *
     * @param Varien_Event_Observer $observer
     */
    public function saveProductTabData(Varien_Event_Observer $observer) {

        $product = $observer->getEvent()->getProduct();

        try {
            /**
             * Perform any actions you want here
             *
             */
            $oldConfig = Mage::getModel('booking/configuration')->load($product->getId(), 'product_id');
            if ($oldConfig->getId()) {
                $bookingConfig = $product['booking'];
                $newConfig = $this->updateBookingConfig($oldConfig, $bookingConfig);
                $newConfig->save();
            } else {
                $customFieldValue = $this->_getRequest()->getPost('custom_field');
                $configuration = Mage::getModel('booking/configuration');
                $bookingConfig = $product['booking'];
                $bookingConfig['product_id'] = $product->getId();
                $configuration->setData($bookingConfig);
                $configuration->save();
                $this->createDailySchedule($configuration->getId(),$product['booking']['days']);
                
            }
//                ob_start();
//                print_r($product['booking']);
//                Mage::log(ob_get_clean(),null,'fields.txt');
//                Mage::log('product_id: ' . $product->getId(),null,'fields.txt');

            /**
             * Uncomment the line below to save the product
             *
             */
            //$product->save();
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    /**
     * Retrieve the product model
     *
     * @return Mage_Catalog_Model_Product $product
     */
    public function getProduct() {
        return Mage::registry('product');
    }

    /**
     * Shortcut to getRequest
     *
     */
    protected function _getRequest() {
        return Mage::app()->getRequest();
    }

}
