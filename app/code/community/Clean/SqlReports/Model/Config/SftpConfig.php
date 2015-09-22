<?php

class Clean_SqlReports_Model_Config_SftpConfig extends Mage_Core_Model_Config_Data
{
    public function toOptionArray()
    {
        $sftpConfigurationModel = Mage::getStoreConfig('cleansql/sftp_configuration');
        if (!empty($sftpConfigurationModel)) {
            $sftpConfig = Mage::getModel($sftpConfigurationModel);
            $sftpConfigurations = $sftpConfig->getConfigurations();
            return $sftpConfigurations;
        }
        return array();
    }

}