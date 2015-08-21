<?php

class Dudus_Booking_Model_Resource_Configuration_DailySchedule extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize connection and define resource table
     *
     */
    protected function _construct()
    {
        
        $this->_init('booking/configuration_dailySchedule', 'id');
    }
}