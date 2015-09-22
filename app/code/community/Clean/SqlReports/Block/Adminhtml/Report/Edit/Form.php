<?php

class Clean_SqlReports_Block_Adminhtml_Report_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('report_edit_form');
    }

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array('id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post')
        );

        $form->setData('use_container', true);
        $this->setForm($form);

        $this->_addBaseFieldset();

        $form->setValues($this->_getReport()->getData());

        return parent::_prepareForm();
    }

    /**
     * @return Clean_SqlReports_Model_Report
     */
    protected function _getReport()
    {
        return Mage::registry('current_report');
    }

    protected function _addBaseFieldset()
    {
        $fieldset = $this->getForm()->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('core')->__('General'),
        ));

        $fieldset->addField('report_id', 'hidden', array(
            'name'      => 'report_id',
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'report[title]',
            'label'     => Mage::helper('core')->__('Title'),
            'required'  => true,
        ));

        $fieldset->addField('sql_query', 'textarea', array(
            'name'      => 'report[sql_query]',
            'label'     => Mage::helper('core')->__('SQL'),
            'required'  => true,
            'style'     => 'width: 640px; height: 200;',
            'note'      =>  Mage::helper('core')->__('NOTE: Do not include a semicolon terminator as the query will be executed as a subquery')
        ));

        // Start Refactor : Replace with predefined types and a source
        $fieldset->addField('output_type', 'select', array(
            'name' => 'report[output_type]',
            'label' => Mage::helper('core')->__('Output Type'),
            'values' => Mage::getModel('cleansql/config_outputType')->toOptionArray(),
            'required' => true,
        ));
        // End Refactor

        $fieldset->addField('chart_config', 'textarea', array(
            'name'      => 'report[chart_config]',
            'label'     => Mage::helper('core')->__('Chart Configuration'),
            'style'     => 'width: 640px; height: 200px;'
        ));
        $fieldset->addField('grid_config', 'textarea', array(
            'name'      => 'report[grid_config]',
            'label'     => Mage::helper('core')->__('Grid Configuration'),
            'style'     => 'width: 640px; height: 200px;'
        ));

        $fieldset->addField('cron_job_code', 'text', array(
            'name'      => 'report[cron_job_code]',
            'label'     => Mage::helper('core')->__('Cron Job Name'),
            'required'  => false,
            'note'      =>  Mage::helper('core')->__('NOTE: Scheduler job code')
        ));

        $fieldset->addField('cron_expr', 'text', array(
            'name'      => 'report[cron_expr]',
            'label'     => Mage::helper('core')->__('Cron Expression'),
            'required'  => false,
        ));

        $fieldset->addField('cron_export_type', 'select', array(
            'name'      => 'report[cron_export_type]',
            'label'     => Mage::helper('core')->__('Cron Export Type'),
            'values' => Mage::getModel('cleansql/config_exportType')->toOptionArray(),
            'required'  => false,
            'note'      =>  Mage::helper('core')->__('NOTE: Export file type. This will set the file name extension.')
        ));

        $sftpConfig = Mage::getModel('cleansql/config_sftpConfig')->toOptionArray();
        if (!empty($sftpConfig)) {
            $fieldset->addField('cron_sftp_config', 'select', array(
                'name' => 'report[cron_sftp_config]',
                'label' => Mage::helper('core')->__('Cron SFTP Configuration'),
                'values' => $sftpConfig,
                'required' => false,
                'note'      =>  Mage::helper('core')->__('NOTE: Upload server configuration. Defines the host, user, password and server path.')
            ));

            $fieldset->addField('cron_sftp_file_name', 'text', array(
                'name'      => 'report[cron_sftp_file_name]',
                'label'     => Mage::helper('core')->__('Cron SFTP File Name'),
                'required'  => false,
                'note'      =>  Mage::helper('core')->__('NOTE: File name to use when uploading the file to the server. File extension will be set by the export type.')
            ));

        }

    }
}