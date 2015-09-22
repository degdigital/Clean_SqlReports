<?php

class Clean_SqlReports_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{
    protected $_report;

    public function preDispatch()
    {
        parent::preDispatch();

        $this->_title($this->__("Special Reports"));
    }

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        Mage::register('current_report', $this->_getReport());
        $this->_title($this->__("Edit: %s", $this->_getReport()->getTitle()));

        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewtableAction()
    {
        Mage::register('current_report', $this->_getReport());
        $this->_title($this->_getReport()->getTitle());

        $this->loadLayout();
        $this->renderLayout();
    }

    public function viewchartAction()
    {
        Mage::register('current_report', $this->_getReport());
        $this->_title($this->_getReport()->getTitle());

        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $report = $this->_getReport();
        $postData = $this->getRequest()->getParams();

        $report->addData($postData['report']);
        $report->save();

        $postReportData = $postData['report'];
        if (!empty($postReportData['cron_expr']) && !empty($postReportData['cron_job_code'])) {
            Mage::getModel('core/config')->saveConfig('crontab/jobs/' . $postReportData['cron_job_code'] . '/schedule/cron_expr/', $postReportData['cron_expr']);
            Mage::getModel('core/config')->saveConfig('crontab/jobs/' . $postReportData['cron_job_code'] . '/run/model/', 'cleansql/observer::runReportExport');
            Mage::app()->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(Mage_Core_Model_Config::CACHE_TAG));
        }

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Saved report: %s", $report->getTitle()));

        $this->_redirect('*/*');

        return $this;
    }

    public function deleteAction()
    {
        $report = $this->_getReport();
        if (!$report->getId()) {
            Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Wasn't able to find the report"));
            $this->_redirect('adminhtml/adminhtml_report');
            return $this;
        }

        $report->delete();

        Mage::getModel('core/config')->deleteConfig('crontab/jobs/' . $report->getCronJobCode() . '/schedule/cron_expr/');
        Mage::getModel('core/config')->deleteConfig('crontab/jobs/' . $report->getCronJobCode() . '/run/model/');
        Mage::app()->getCache()->clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array(Mage_Core_Model_Config::CACHE_TAG));

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Deleted report: %s", $report->getTitle()));

        $this->_redirect('*/*');

        return $this;
    }

    /**
     * Export grid to CSV format
     */
    public function exportCsvAction()
    {
        Mage::register('current_report', $this->_getReport());
        $this->loadLayout();

        /** @var $grid Mage_Adminhtml_Block_Widget_Grid */
        $grid = $this->getLayout()->getBlock('report.view.grid');
        if(!$grid instanceof Mage_Adminhtml_Block_Widget_Grid) {
            $this->_forward('noroute');
            return;
        }

        $fileName = strtolower(str_replace(' ', '_', $this->_getReport()->getTitle())) . '_' . time() . '.csv';

        $this->_prepareDownloadResponse(
            $fileName,
            $grid->getCsvFile(),
            'text/csv'
        );
    }

    /**
     * Get JSON action
     *
     * @return void
     */
    public function getJsonAction() {
        try {
            $report = $this->_getReport();

            if ($report->getOutputType() == Clean_SqlReports_Model_Config_OutputType::TYPE_CALENDAR_CHART) {
                $json = $report->getReportCollection()->toCalendarJson();
            } else {
                $json = $report->getReportCollection()->toReportJson();
            }
            $this->getResponse()->setBody($json);
            $this->getResponse()->setHeader('Content-type', 'application/json');
        } catch (Exception $e) {
            $this->getResponse()->setBody(json_encode(array('error' => $e->getMessage())));
            $this->getResponse()->setHeader('Content-type', 'application/json');
        }
    }

    /**
     * @return Clean_SqlReports_Model_Report
     */
    protected function _getReport()
    {
        if (isset($this->_report)) {
            return $this->_report;
        }

        $report = Mage::getModel('cleansql/report');
        if ($this->getRequest()->getParam('report_id')) {
            $report->load($this->getRequest()->getParam('report_id'));
        }

        $this->_report = $report;
        return $this->_report;
    }

    protected function _isAllowed()
    {
        $isView = in_array($this->getRequest()->getActionName(), array('index', 'view', 'viewTable'));

        /** @var $helper Clean_SqlReport_Helper_Data */
        $helper = Mage::helper('cleansql');

        return ($isView ? $helper->getAllowView() : $helper->getAllowEdit());
    }

    /**
     * Export grid to TSV format
     */
    public function exportTsvAction()
    {
        Mage::register('current_report', $this->_getReport());
        $this->loadLayout();

        /** @var $grid Mage_Adminhtml_Block_Widget_Grid */
        $grid = $this->getLayout()->getBlock('report.view.grid');
        if(!$grid instanceof Mage_Adminhtml_Block_Widget_Grid) {
            $this->_forward('noroute');
            return;
        }

        $fileName = strtolower(str_replace(' ', '_', $this->_getReport()->getTitle())) . '_' . time() . '.tsv';

        $this->_prepareDownloadResponse(
            $fileName,
            $grid->getTsvFile(),
            'text/csv'
        );
    }

}
