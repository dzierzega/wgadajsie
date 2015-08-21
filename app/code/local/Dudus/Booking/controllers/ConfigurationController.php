<?php

class Dudus_Booking_ConfigurationController extends Mage_Adminhtml_Controller_Action {

    protected function _initConfiguration() {

        $product_id = (int) $this->getRequest()->getParam('id');
        $bookingConfiguration = Mage::getModel('booking/configuration')->load($product_id, 'product_id');
        Mage::register('booking_configuration', $bookingConfiguration);
        Mage::register('current_booking_configuration', $bookingConfiguration);
        $dailyScheduleCollection = Mage::getModel('booking/configuration_dailySchedule')->getCollection()
                                        ->addFieldToFilter('configuration_id',array('eq'=>$bookingConfiguration->getId()));
        $dailySchedule = array();
        foreach($dailyScheduleCollection as $day){
            $dailySchedule[$day['day_name']] = array('start_time'=>substr($day['start_time'],11,5),
                                                    'end_time'=>substr($day['end_time'],11,5));
        }
        Mage::register('daily_schedule',$dailySchedule);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $bookingConfiguration;
    }

    public function configurationAction() {
        $productId = (int) $this->getRequest()->getParam('id');
        $bookingConfiguration = $this->_initConfiguration();
        $this->loadLayout();
        $this->renderLayout();
    }

}
