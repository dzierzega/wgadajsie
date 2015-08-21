<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
->newTable($installer->getTable('booking/configuration'))
->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
'identity' => true,
 'unsigned' => true,
 'nullable' => false,
 'primary' => true,
 ), 'Id')
->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
'nullable' => false,
 ), 'Product Id')
->addColumn('from_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
'nullable' => true,
 ), 'From')
->addColumn('to_date', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
'nullable' => true,
 ), 'From')
->addColumn('slot_time', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
'nullable' => false,
 ), 'Time Slot')
->addColumn('buffer_time', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
'nullable' => true,
 ), 'Time Buffer');
$installer->getConnection()->createTable($table);
$installer->getConnection()
        ->addIndex(
            $installer->getTable('booking/configuration'),
            $installer->getIdxName('booking/configuration', array('product_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
            array('product_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        );
$installer->endSetup();
