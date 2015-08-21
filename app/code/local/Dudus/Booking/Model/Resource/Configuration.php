<?php

class Dudus_Booking_Model_Resource_Configuration extends Mage_Core_Model_Resource_Db_Abstract {

    protected function _construct() {
        $this->_init('booking/configuration', 'entity_id');
//        $this->_sizetableSizeTable = $this->getTable('zcatalog/sizetable_size');
//        $this->_sizetableCategoryTable = $this->getTable('zcatalog/category_sizetable');
    }

}
