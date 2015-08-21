<?php
class Dudus_Booking_Model_Resource_Configuration_DailySchedule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
            $this->_init('booking/configuration_dailySchedule');
    }
}