<?php

interface Clean_SqlReports_Model_Sftp_Connection_Interface
{

    /**
     * Set the Sftp configuration path. This is the cron_sftp_config value from the cleansql_report table.
     * @param string $sftpConfigPath
     * @return $this
     */
    public function setSftpConfiguration($sftpConfigPath);

    /**
     * Set the Sftp file name. This is the cron_sftp_file_name value from the cleansql_report table.
     * @param string $sftpFileName
     * @return $this
     */
    public function setSftpFileName($sftpFileName);

    /**
     * Set the Sftp file extension. This is the cron_export_type value from the cleansql_report table.
     * @param string $sftpFileExtension
     * @return $this
     */
    public function setSftpFileExtension($sftpFileExtension);

    /**
     * Upload the file to the Sftp server defined by the Sftp configuration.
     * @param string $fileName
     * @return $this
     */
    public function upload($fileName);

}