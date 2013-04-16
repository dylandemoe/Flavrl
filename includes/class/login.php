<?php

    class login{
    
        var $user;
        var $pass;
        var $id;
        var $check;
        var $redirect;
        var $connect;
        
        public function login_handler($type){
            if($type == 'login'){
                return $this->login_user('false');
            }
            else if($type == 'remember'){
                return $this->check_cookie();
            }
        }

        private function login_user($bypass){

            $user = $this->user;
            $connect = $this->connect;
            
            if($bypass !== true){
                $user_small = strtolower($user);
                $pass = $this->pass;
                $check = $this->check;
            
                $q = "SELECT id, username FROM users 
                        WHERE username='$user'  AND password='$pass'";
                

                $result = $connect->query($q);
                $rows = $result->num_rows;

                $arr = $result->fetch_array(MYSQLI_NUM);
                $id = $arr[0];
                $user = $arr[1];
            }
            else{
                $rows = 1;
                $check = 'true';
                $id = $this->id;
            }
    
            if($rows == 1){
                
                
                $_SESSION['user'] = $user;
                $_SESSION['user_id'] = $id;

                $data = array($id,$user);
                include 'token.php';
                $t = new token($data);
                $value = $t->value;
                $secret = $t->secret;
                
                setcookie("ft",$secret, time()+3600*24, '/');

                if($check == 'true'){
                    setcookie("user_auth",$value, time()+3600*24*30, '/');
                }
                
                //I need this stupid date timezone cause it was not properly set in the php.ini file
                date_default_timezone_set('America/Toronto');
                $time = date('Y-m-d H:i:s', time());
                $q = "UPDATE users SET token = '$secret', lastLogged='$time' WHERE username='$user'";
                
                $result = $connect->query($q);
                if (!$result) {
                  return 'Error';
                }
                else{
                    if(isset($this->redirect)){
                        header('Location: '.$this->redirect);
                    }
                    else{
                        return 'true';
                    }
                }
                
            }
            else{
                return 'false';
            }
        }
        
        private function check_cookie(){

            $auth = $_COOKIE['user_auth'];
            $dc_auth = base64_decode($auth);
            $ps_auth = parse_str($dc_auth);
            $connect = $this->connect;
            
            $q = "SELECT username FROM users
                    WHERE username='$user' AND token='$token'";
            
            $result = mysqli_query($connect,$q);
            
            if(mysqli_num_rows($result) == 1){
                $this->user = $user;
                $this->id = $id;
                $this->login_user(true);
            }
            else{
                setcookie("user_auth",'', time()-1, '/');
            }
        }
    }
?>