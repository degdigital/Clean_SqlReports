<?php
/**
 * Created by PhpStorm.
 * User: amacgregor
 * Date: 11/05/14
 * Time: 8:33 AM
 */

class Clean_SqlReports_Model_Config_ExportType extends Mage_Core_Model_Config_Data
{
    const TYPE_CSV            = 'csv';
    const TYPE_TSV            = 'tsv';

    public function toOptionArray()
    {
        $helper = Mage::helper('cleansql');
        
        return array(
            array("title"  => $helper->__('CSV'), 'label' => $helper->__('CSV'), 'value' => self::TYPE_CSV),
            array("title"  => $helper->__('TSV'), 'label' => $helper->__('TSV'), 'value' => self::TYPE_TSV)
        );
    }

}