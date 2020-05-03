<?php


class UserModel
{
    private $db;

    /**
     * UserModel constructor.
     */
    public function __construct()
    {
        $this->db = new MySqlFactory();

        $this->db->setDbName('cloudix')
            ->setDbHost('127.0.0.1')
            ->setDbUserName('root')
            ->setDbPassword('root')
            ->setDbPort(3306)
            ->setDbTableName('users')
            ->setDbColumnProperties([
                'id' => "INT NOT NULL AUTO_INCREMENT PRIMARY KEY",
                'username' => "VARCHAR(200) NOT NULL",
                'password' => "VARCHAR(200) NOT NULL",
            ])->build();
    }

    /**
     * @param array $postData
     * @return string
     */
    public function signUp(array $postData): ?string
    {
        /** checking user`s input */
        if($this->isUserExist($postData['username'])){
            return '\''. $postData['username'] . '\' username already exist';
        }else if($postData['password'] !== $postData['password2']) {
            return 'Password dosen\'t confirm';
        }

        /** password hashing before save */
        $postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);

        /**save data, turn on SESSION */
        if($this->db->insert($postData)){
            $_SESSION['user'] = $postData['username'];
            return null;
        }

        return 'Something went wrong! Try again';
    }

    /**
     * @param array $postData
     * @return string
     */
    public function logIn(array $postData): ?string
    {
        if($dbData = $this->db->getByColumn('username', $postData['username'])){
            if(password_verify($postData['password'], $dbData[0][2])){
                $_SESSION['user'] = $postData['username'];
                return null;
            }
        }

        return 'Something went wrong! Try again';
    }

    /**
     *
     */
    public function logOut(): void
    {
        if(isset($_SESSION['user'])) {
            $_SESSION['user'] = false;
        }
    }

    /**
     * @param $username
     * @return bool
     */
    private function isUserExist($username): bool
    {
        if(!$this->db->getByColumn('username', $username)){
            return false;
        }

        return true;
    }
}