<?php
class Clean_SqlReports_Model_Report_Export
{
    protected $_report;

    public function runReport() {
        Mage::register('current_report', $this->_report);
        $grid = Mage::app()->getLayout()->createBlock('cleansql/adminhtml_report_view_grid');

        if ($this->_report->getCronExportType() == Clean_SqlReports_Model_Config_ExportType::TYPE_CSV) {
            return $grid->getCsvFile();
        }

        if ($this->_report->getCronExportType() == Clean_SqlReports_Model_Config_ExportType::TYPE_TSV) {
            return $grid->getTsvFile();
        }
        return false;
    }

    public function setReport($report) {
        $this->_report = $report;
        return $this;
    }
}