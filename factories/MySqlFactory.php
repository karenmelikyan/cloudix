<?php


class MySqlFactory
{
    private $db;
    private $dbHost;
    private $dbName;
    private $dbUserName;
    private $dbPassword;
    private $dbPort;
    private $dbTableName;
    private $tableColumnProperties = [];

    /**
     * @param $dbName
     * @return MySqlFactory
     */
    public function setDbName($dbName): MySqlFactory
    {
        $this->dbName = $dbName;
        return $this;
    }

    /**
     * @param $dbHost
     * @return MySqlFactory
     */
    public function setDbHost($dbHost): MySqlFactory
    {
        $this->dbHost = $dbHost;
        return $this;
    }

    /**
     * @param $dbUserName
     * @return MySqlFactory
     */
    public function setDbUserName($dbUserName): MySqlFactory
    {
        $this->dbUserName = $dbUserName;
        return $this;
    }

    /**
     * @param $dbPassword
     * @return MySqlFactory
     */
    public function setDbPassword($dbPassword): MySqlFactory
    {
        $this->dbPassword = $dbPassword;
        return $this;
    }

    /**
     * @param $dbPort
     * @return MySqlFactory
     */
    public function setDbPort($dbPort): MySqlFactory
    {
        $this->dbPort = $dbPort;
        return $this;
    }

    /**
     * @param $dbTableName
     * @return MySqlFactory
     */
    public function setDbTableName($dbTableName): MySqlFactory
    {
        $this->dbTableName = $dbTableName;
        return $this;
    }

    /**
     * @param $tableColumnProperties
     * @return MySqlFactory
     */
    public function setDbColumnProperties($tableColumnProperties): MySqlFactory
    {
        $this->tableColumnProperties = $tableColumnProperties;
        return $this;
    }

    /**
     * @return MySqlFactory
     */
    public function build(): MySqlFactory
    {
        /** connect to SQL database & return instance of connection */
        $this->db = new mysqli($this->dbHost, $this->dbUserName, $this->dbPassword,
            $this->dbName, $this->dbPort) or die("Error " . mysqli_error($this->db));

        /** create request string `str` from properties */
        $str = '(';
        foreach($this->tableColumnProperties as $key => $value){
            $str .= $key . ' ' . $this->tableColumnProperties[$key] . ', ';
        }
        $str = substr($str, 0, strlen($str) - 2) . ')';

        /** create table if not exist */
        if(!$this->db->query("CREATE TABLE IF NOT EXISTS " . $this->dbTableName)) {
            $query = 'CREATE Table' . ' ' . $this->dbTableName . ' ' . $str;
        }

        /** to do request to database */
        mysqli_query($this->db, $query);

        return $this;
    }


    /**
     * @return array
     *
     * returns a two-dimensional array
     */
    public function getAll(): ?array
    {
        $dataArray = [];
        $query = "SELECT * FROM " . $this->dbTableName;
        $result = mysqli_query($this->db, $query);

        if($result) {
            $rows = mysqli_num_rows($result); // get amount of rows
            for ($i = 0; $i < $rows; ++ $i) {
                $dataArray[] = mysqli_fetch_row($result);
            }
            return $dataArray;
        }

        return null;
    }

    /**
     * @param $fieldName
     * @param $value
     * @return array|null
     *
     * returns a two-dimensional array
     */
    public function getByColumn($columnName, $value): ?array
    {
        $dataArray = [];
        $query = "SELECT * FROM " . $this->dbTableName . " WHERE " . $columnName . " = " . "'$value'";
        $result = mysqli_query($this->db, $query);

        if($result) {
            $rows = mysqli_num_rows($result); // get amount of rows
            for ($i = 0; $i < $rows; ++ $i) {
                $dataArray[] = mysqli_fetch_row($result);
            }
        }

        if(count($dataArray) > 0){
            return $dataArray;
        }

        return null;
    }

    /**
     * @param $fieldName
     * @param $value
     * @return bool
     */
    public function deleteByColumn($columnName, $value): bool
    {
        $query = "DELETE FROM " . $this->dbTableName . " WHERE " . $columnName . " = " . "'$value'";
        if(mysqli_query($this->db, $query)){
            return true;
        }

        return false;
    }

    /**
     * @param $postData
     * @return bool
     */
    public function insert($postData): bool
    {
        /** extract data  & create sql string for request */
        $str = ' VALUES(NULL, ';
        foreach($this->tableColumnProperties as $key => $value){
            if($key !== 'id'){
                                /**  safety from sql injections */
                $str .= '\'' .  htmlentities(mysqli_real_escape_string($this->db, $postData[$key])) . '\', ';
            }
        }
        $str = substr($str, 0, strlen($str) - 2) . ')';

        /** to do sql request */
        $query = "INSERT INTO " . $this->dbTableName . $str;
        if(mysqli_query($this->db, $query)){
            return true;
        }

        return false;
    }

}