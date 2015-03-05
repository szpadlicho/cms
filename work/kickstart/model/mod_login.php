<?php
include_once 'config/connect.php';
class Model_Login_Connect extends Connect
{
    /* 
     * Class Connect_Login
     * if email not exist -                  return boolean false
     * if email exist and wrong password     return boolean true
     * if email exist and correct pasword    return integer id
     * WARNING VARIABLE TYPE IS IMPORTANT !!!
     *
     * @return mix 
     *
     */
    public function checkPassword($table, $email, $password)
    {
        $con =$ this->pdo;
        $q = $con->query(
            "SELECT `password` 
            FROM `".$table."` 
            WHERE `email`='".$email."'"
            );// zwraca false jesli tablica nie istnieje
        unset ($con);
        $q = $q->fetch(PDO::FETCH_ASSOC);
        if ($q) {
            return ($q['password'] == $password) ? true : false ;
        } else {
            return (int)0;
        }
    }
    public function __getUserId($table, $email, $password)
    {
        $check = $this->checkPassword($email, $password);
        if ($check === true) {
            $con = $this->pdo;
            $q = $con->query(
                "SELECT `id` 
                FROM `".$table."` 
                WHERE `email`='".$email."'"
                );// zwraca false jesli tablica nie istnieje
            unset ($con);
            $id = $q->fetch(PDO::FETCH_ASSOC);
            return (int)$id['id'];
        } elseif ($check === false) {
            return true;
        } elseif ($check === (int)0) {
            return false;
        }     
    }
}