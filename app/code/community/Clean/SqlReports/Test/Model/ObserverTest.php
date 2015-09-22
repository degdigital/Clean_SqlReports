<?php
class Clean_SqlReports_Model_Report_ExportTest extends EcomDev_PHPUnit_Test_Case
{
    /**
     *
     */
    public function testRunReportExport()
    {
        $reportMock = $this->getModelMockBuilder('cleansql/report_export')
            ->setMethods(array('runReport'))
            ->getMock();
        $reportMock->expects($this->once())->method('runReport');

        $this->replaceByMock('model', 'cleansql/report_export', $reportMock);

        $data = new Varien_Event_Observer();
        $data->setJobCode('dataflow_profile');
        $cronObserver = new Clean_SqlReports_Model_Observer();
        $cronObserver->runReportExport($data);

    }

}