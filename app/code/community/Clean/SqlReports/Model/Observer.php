<?php
class Clean_SqlReports_Model_Observer
{

    public function runReportExport($schedule)
    {
        $reportJobCode = $schedule->getJobCode();

        $report = Mage::getModel('cleansql/report');
        $report->load($reportJobCode,'cron_job_code');//load by cron_job_code

        $reportExport = Mage::getModel('cleansql/report_export');
        $reportExport->setReport($report);
        $exportFileData = $reportExport->runReport();

        if (is_array($exportFileData) && isset($exportFileData['value'])) {
            $dropFileResult = $this->_dropFile($exportFileData['value'], $report->getCronSftpConfig(), $report->getCronSftpFileName(), $report->getCronExportType());
            if (!$dropFileResult) {
                Mage::throwException('Failed to upload file to SFTP server.');
            }
        }
    }

    protected function _dropFile($fileName, $sftpConfigPath, $sftpFileName, $exportFileType) {
        $sftpConnectionModel = Mage::getStoreConfig('cleansql/sftp_connection');
        if (!empty($sftpConnectionModel)) {
            $sftpConnection = Mage::getModel($sftpConnectionModel);
            $sftpConnection->setSftpConfiguration($sftpConfigPath);
            $sftpConnection->setSftpFileName($sftpFileName);
            $sftpConnection->setSftpFileExtension($exportFileType);
            $uploadResult = $sftpConnection->upload($fileName);
            return $uploadResult;
        }
        return false;
    }
}