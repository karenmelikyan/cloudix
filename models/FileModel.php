<?php


class FileModel
{
    private $db;

    /**
     * FileModel constructor.
     */
    public function __construct()
    {
        $this->db = new MySqlFactory();

        $this->db->setDbName('cloudix')
            ->setDbHost('127.0.0.1')
            ->setDbUserName('root')
            ->setDbPassword('root')
            ->setDbPort(3306)
            ->setDbTableName('files')
            ->setDbColumnProperties([
                'id' => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'filename' => "VARCHAR(200) NOT NULL",
                'time' => "INT NOT NULL",
            ])->build();
    }

    /**
     * @param $fileData
     * @return string|null
     */
    public function upload(array $fileData): ?string
    {
        /** Check if the file was choosen */
        if($fileData['file']['error'] > 0) {
            return 'File wasn\'t selected';
        }

        /**Set up valid image extensions*/
        $extsAllowed = ['jpg', 'jpeg', 'txt', 'pdf', 'html', 'png', 'gif'];
        $extUpload = strtolower( substr( strrchr($fileData['file']['name'], '.') ,1) ) ;

        /**Check if the uploaded file extension is allowed */
        if (in_array($extUpload, $extsAllowed)){

            /** generate unique file name via `salt` */
            $fileData['file']['name'] = $this->getSalt() . $fileData['file']['name'];

            /** Upload the file on the server */
            if(move_uploaded_file($fileData['file']['tmp_name'], 'storage/' . $fileData['file']['name'])){

                /** write data about downloaded file to database */
                if($this->db->insert(['filename' => $fileData['file']['name'], 'time' => time()])){
                    return 'File was uploaded successfully';
                }else{
                    /** if file was uploaded, but database was
                     fault - delete uploaded file from storage */
                     unlink('storage/' . $fileData['file']['name']);
                }
            }
        }

        return 'Failed file upload! Try again';
    }

    /**
     * @param string $filePath
     */
    public function download(string $filePath)
    {
        if (file_exists($filePath)) {
            /** reset the buffer of input*/
            if (ob_get_level()) {
                ob_end_clean();
            }
            /** to force browser to show window of download */
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filePath));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            /** read file and send it to user*/
            readfile($filePath);
        }
    }

    /**
     * @return int
     *
     * looking for uploaded files with expired time
     * (expire time is inserted in `config` file in milliseconds)
     * and deletes them from `storage` folder & database.
     */
    public function deleteExpiredFiles(): int
    {
         $counter = 0;
         $dbData = $this->db->getAll();

         for($i = 0; $i < count($dbData); $i ++){
             if($dbData[$i][2] + Config::$conf['filesExpireTime'] < time()){
                 if($this->db->deleteByColumn('time', $dbData[$i][2]) &&
                     unlink('storage/' . $dbData[$i][1])){
                     $counter ++;
                 }
             }
         }

         return $counter;
    }

    /**
     *
     */
    public function getAll(): ?array
    {
       return $this->db->getAll();
    }

    /**
     * @return string
     */
    private function getSalt(): string
    {
        return substr(md5(rand()), 0, 3) . '_';
    }

}