<?php

class Clean_SqlReports_Model_Report_ExportTest extends EcomDev_PHPUnit_Test_Case
{

    /**
     * @loadFixture
     */
    public function testRunReport()
    {
        $report = Mage::getModel('cleansql/report');
        $report->load(1);

        $gridMock = $this->getBlockMockBuilder('cleansql/adminhtml_report_view_grid')
            ->setMethods(array('getCsvFile'))
            ->getMock();
        $gridMock->expects($this->once())->method('getCsvFile')->will($this->returnValue(array('value'=>'test')));
        $this->replaceByMock('block', 'cleansql/adminhtml_report_view_grid', $gridMock);

        $reportExport = new Clean_SqlReports_Model_Report_Export();
        $reportExport->setReport($report);
        $result = $reportExport->runReport();
        $this->assertEquals(array('value'=>'test'),$result);
    }
}