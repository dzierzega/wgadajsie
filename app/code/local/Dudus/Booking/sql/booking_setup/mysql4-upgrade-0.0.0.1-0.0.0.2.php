<?php
$installer = $this;
 
$installer->startSetup();
 
$table = $installer->getConnection()
    ->newTable($installer->getTable('booking/configuration_dailySchedule'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Id')
    ->addColumn('configuration_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Configuration Id')
     ->addColumn('day_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        ), 'Day Id')
    ->addColumn('day_name', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ), 'Day Name')
    ->addColumn('start_time',Varien_Db_Ddl_Table::TYPE_TIME,null,array(
        'nullable' => false,
    ),'Row Id')
    ->addColumn('end_time',  Varien_Db_Ddl_Table::TYPE_TIME,null,array(
        'nullable'=>false,
    ),'Size Value');
$installer->getConnection()->createTable($table);
$installer->getConnection()
        ->addIndex(
            $installer->getTable('booking/configuration_dailySchedule'),
            $installer->getIdxName('booking/configuration_dailySchedule', array('configuration_id','day_id'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
            array('configuration_id','day_id'),
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ); 
$installer->endSetup();
