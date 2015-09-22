<?php

/** @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$this->getConnection()
    ->addColumn($this->getTable('cleansql/report'), 'cron_expr', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '255',
        'comment'   => 'Cron Expression',
    ));
$this->getConnection()
    ->addColumn($this->getTable('cleansql/report'), 'cron_job_code', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '255',
        'comment'   => 'Cron Job Code',
    ));
$this->getConnection()
    ->addColumn($this->getTable('cleansql/report'), 'cron_export_type', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '10',
        'comment'   => 'Cron Export Type',
    ));
$this->getConnection()
    ->addColumn($this->getTable('cleansql/report'), 'cron_sftp_config', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '255',
        'comment'   => 'Cron SFTP Configuration',
    ));
$this->getConnection()
    ->addColumn($this->getTable('cleansql/report'), 'cron_sftp_file_name', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => '255',
        'comment'   => 'Cron SFTP File Name',
    ));

$this->endSetup();