<?php
include_once 'config/connect.php';
class Model_Register_Connect extends Connect
{   
    /**
     * object of the class PDO
     *
     * @var object
     */

    /**
     * It validate all user inputs
     * if success initiate add user function
     * if fail return false and bad inputs array with error number
     *
     * @param string $table name of table to use
     * @param array $arr_val all input data
     *
     * @return mix
     */
    function checkUser($table, $arr_val){
        // delete unnecessary
        unset($arr_val['register']);
        // initiate arrays and variables
        $correct = array();
        $error = array();
        $length = 3;
        // start checking inputs
        
        if (filter_var($arr_val['email'], FILTER_VALIDATE_EMAIL)) {
            if ($arr_val['email'] == $arr_val['confirm_email']) {
                // delete unnecessary
                unset($arr_val['confirm_email']);
                if ($arr_val['password'] == $arr_val['confirm_password']) {
                    // delete unnecessary
                    unset($arr_val['confirm_password']);
                    foreach ($arr_val as $key => $value) {
                        if ( !empty($value) && strlen($value) >= $length) {
                            if ($key == 'password') {
                                $correct[$key] = md5($value);
                            } else {
                                $correct[$key] = $value;
                            }
                        } else {
                            $error[$key] = $value;
                        }
                    }
                    if (empty($error)) {
                        /**
                         *
                         * Here we can add more specific validation if need in future
                         * if correct just go further
                         *
                         * if error detected return false, error number, incorrect user data in array
                         *
                         */
                        // correct user data to save
                        // return array(true, $correct);
                        return $this->addUser($table, $correct);
                    } else {
                        // 3 inputs error
                        // remove password from returning array
                        unset($arr_val['password']);
                        return array(false, 3, $error, $arr_val);
                    }
                } else {
                    $error[] = $arr_val['password'];
                    $error[] = $arr_val['confirm_password'];
                    // 2 incorrect password error
                    return array(false, 2, $error, $arr_val);
                }
            } else {
                $error[] = $arr_val['email'];
                $error[] = $arr_val['confirm_email'];
                // 1 incorrect email error
                return array(false, 1, $error, $arr_val);
            }
        } else {
            // 0 incorrect email format valid
            $error[] = $arr_val['email'];
            return array(false, 0, $error);
        }
    }
    /**
     * It add user to database
     * initiate by checkUser function
     * Success return true, last insert id, and user data array
     * and send email activation
     * 
     * If fail return false, error number, and user data array
     *
     * @param string $table name of table to use
     * @param array $arr_val all input data
     *
     * @return mix
     */
    public function addUser($table, $arr_val)
    {
        $con = $this->pdo;
        // add prefix to table name
        include 'config/prefix.php';
        $table = $pref.$table;
        // check if email exist
        // if not return false
        $res = $con->query(
            "SELECT `email` 
            FROM ".$table." 
            WHERE `email` = '".$arr_val['email']."'"
            );
        $res = $res->fetch(PDO::FETCH_ASSOC);
        // save user if email not exist in table
        if (!empty($arr_val) && ! $res) {
            $field='';
            $value='';
            foreach ($arr_val as $name => $val) {
                $field .= '`'.$name.'`,';
                $value .= "'".$val."',";
            }
            // Remove last coma from string
            $field = rtrim($field, ",");
            $value = rtrim($value, ",");
            // Create record
            $res = $con->query(
                "INSERT INTO `".$table."`(
                ".$field.",
                `active`,
                `create_data`,
                `update_data`
                ) VALUES (
                ".$value.",
                '0',
                '".date('Y-m-d H:i:s')."',
                '".date('Y-m-d H:i:s')."'
                )");
            if ($res) {
                // activation email send
                $destination_address = $arr_val['email'];
                $token = md5($arr_val['email']).'|'.$con->lastInsertId();
                /**
                 * Email activation
                 * uncomment in finish
                 */
                // include_once 'config/email_activation.php';
                // remove password from returning array
                unset($arr_val['password']);
                // return true or ID when success
                return array(true, (int)$con->lastInsertId(), $arr_val);
            } else {
                // 5 save in database error
                unset($arr_val['password']);
                return array(false, 5, $arr_val = null, $arr_val);
            }
        } else {
            // 4 email exist error
            // remove password from returning array
            unset($arr_val['password']);
            return array(false, 4, $arr_val['email'], $arr_val);
        }
    }
    /**
     * It update data user in table
     * 
     *
     * @param string $table name of table to use
     * @param array $arr_val all input data
     * @param array $id user id
     *
     * @return mix
     */
    public function updateUser($table, $arr_val, $id)
    {
        $con = $this->pdo;
        // add prefix to table name
        include 'config/prefix.php';
        $table = $pref.$table;
        // Return false if table not exist
		$res = $con->query(
            "SELECT 1 
            FROM ".$table
            );
        if (!empty($arr_val) && ! $res) { //$res != false
            $commit='';
            foreach ($arr_val as $name => $val) {
                $commit .= "`".$name."` = '".$val."',";
            }
            // Remove last coma from string
            $commit = rtrim($commit, ",");
            $res = $con->query(
                "UPDATE `".$table."` SET 
                ".$commit.",
                `update_data` = '".date('Y-m-d H:i:s')."'
                WHERE 
                `id` = '".$id."'"
                );
            // if update return 1 if not return 0
            // returns the number of rows affected by the last 
            // DELETE, INSERT, or UPDATE 
            // statement executed by the corresponding PDOStatement object
            $res = $res->rowCount();
            return $res ? true : false;
        } else {
            return false;
        }
    }
    /**
     * It activate user account
     * checking token from url
     * if is correct activate account and return true
     * 
     * If fail return false
     *
     * @param string $table name of table to use
     * @param array $token its get from url sended in email
     *
     * @return boolean
     */
    public function activationAccount($table, $token)
    {
        $token = explode('|', $token);
        $email = $token[0];
        $id = $token[1];
        $con = $this->pdo;
        // add prefix to table name
        include 'config/prefix.php';
        $table = $pref.$table;
        // get email from user
		$res = $con->query("
            SELECT `email` 
            FROM ".$table." 
            WHERE `id` = '".$id."'
            ");
        $res = $res->fetch(PDO::FETCH_ASSOC);
        // check if the token is correct
        if (md5($res['email']) == $email) {
            $update = $con->query("
                UPDATE `".$table."`   
                SET 
                `active` = '1'
                WHERE 
                `id` = '".$id."'
                ");	
            return $update ? true : false ;
        }
    }
    public function addUserFromFacebook($table, $arr_val)
    {
        $con = $this->pdo;
        // add prefix to table name
        include 'config/prefix.php';
        $table = $pref.$table;
        // check if email exist
        // if not return false
        $res = $con->query(
            "SELECT `email` 
            FROM ".$table." 
            WHERE `email` = '".$arr_val['email']."'"
            );
        $res = $res->fetch(PDO::FETCH_ASSOC);
        // save user if email not exist in table
        if (!empty($arr_val) && ! $res) {
            $field='';
            $value='';
            foreach ($arr_val as $name => $val) {
                $field .= '`'.$name.'`,';
                $value .= "'".$val."',";
            }
            // Remove last coma from string
            $field = rtrim($field, ",");
            $value = rtrim($value, ",");
            // Create record
            $res = $con->query(
                "INSERT INTO `".$table."`(
                ".$field.",
                `create_data`,
                `update_data`
                ) VALUES (
                ".$value.",
                '".date('Y-m-d H:i:s')."',
                '".date('Y-m-d H:i:s')."'
                )");
            if ($res) {
                // activation email send
                if ($arr_val['active'] == 0) { // jesli nie zwerykikowany adres email na facebook
                    $destination_address = $arr_val['email'];
                    $token = md5($arr_val['email']).'|'.$con->lastInsertId();
                    /**
                     * Email activation
                     * uncomment in finish
                     */
                    // include_once 'config/email_activation.php';
                }
                // remove password from returning array
                unset($arr_val['password']);
                // return true or ID when success
                return array(true, (int)$con->lastInsertId(), $arr_val);
            } else {
                // 5 save in database error
                unset($arr_val['password']);
                return array(false, 5, $arr_val = null, $arr_val);
            }
        } else {
            // 4 email exist error
            // remove password from returning array
            unset($arr_val['password']);
            return array(false, 4, $arr_val['email'], $arr_val);
        }
    }
}