<?php

    class display{
    
        var $user;
        var $userID;
        var $section;
        var $connect;
        
        
        public function display(){
            $section = $this->section;
            
            if($section == 'signin'){
                return $this->notLoggedIn();
            }
            else if($section == 'log_header'){
                return $this->loggedIn_header();
            }
            else if($section == 'log_body'){
                return $this->loggedIn_body();
            }
            else if($section == 'scripts'){
                return $this->getScripts();
            }
            else if($section == 'user_styles'){
                return $this->getStyles();
            }
        }
        
        private function notLoggedIn(){
            $output = <<<EOT
            <form class="form-signin mainpage-signin">
                <h2 class="form-signin-heading">Please sign in</h2>
                <input id="login_user" type="text" class="input-block-level" placeholder="Username">
                <input id="login_pass" type="password" class="input-block-level" placeholder="Password">
                <label class="checkbox">
                    <input id="login_check" type="checkbox"> Remember me
                </label>
                <button id="login_submit" class="btn btn-primary" type="button">Sign in</button>
                <br/>
                <small>or <a href="guest.php">login</a> as a guest.</small>
            </form>
EOT;
            return $output;
        }
        
        private function loggedIn_header(){
            $user = $this->user;
            
            //Get the user's search engines
            include 'engines.php';
            $e = new searchEngines;
            $e->userID = $this->userID;
            $e->connect = $this->connect;
            $header = $e->getEngines('header');

            //now  get the app list
            include 'apps.php';
            $a = new apps;
            $a->connect = $this->connect;
            $apps = $a->getApps('list');

            $output = <<<EOT
            
            <div id="user_engines">
                $header
            </div>
            <ul class="nav pull-right">
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-th-large"></i> 
                        Apps
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" id="apps-list">
                        $apps
                    </ul>
                </li>
                <li>
                    <div class="btn-group pull-right">
                      <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-user"></i>
                        $user
                        <span class="caret"></span>
                      </a>
                      <ul class="dropdown-menu force-arrow">
                        <li class="dropdown-submenu pull-left">
                            <a tabindex="-1" href="#">Settings</a>
                            <ul class="dropdown-menu">
                              <li><a href="javascript:void(0)" class="modal-link" data-id="-theme" data-head="Theme" data-href="modal/theme.php">Theme</a></li>
                              <li><a href="javascript:void(0)" class="modal-link" data-id="-background" data-head="Background" data-href="modal/background.php">Background</a></li>
                              <li><a href="">Account</a></li>
                            </ul>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php">Log Out</a></li>
                      </ul>
                    </div>
                </li>
            </ul>   
EOT;

            return $output;
        }
        
        private function loggedIn_body(){
            //now  get the app list
           // $a->connect = $this->connect;
            //$a->userID = $this->userID;
            $a = new apps;
            $a->connect = $this->connect;
            $a->userID = $this->userID;
            $apps = $a->getApps('user');
            $output = <<<EOD
               $apps
EOD;
            return $output;
        }
        
        private function getScripts(){
            $p = '';
            $c = '';
    
            //Get the scripts from the js folder for plugins
            foreach (glob("js/plugins/*.js") as $filename) {
                $p .= "<script src='".$filename."'></script>\n";
            }
            //Get the scripts from the js folder for custom
            foreach (glob("js/custom/*.js") as $filename) {
                $c .= "<script src='".$filename."'></script>\n";
            }
            
            return $p.$c;
        }
        
        private function getStyles(){
            $user = $this->userID;
            $connect = $this->connect;
            $q = "SELECT theme, bg FROM visual_settings WHERE id='$user' LIMIT 1";
            $r = $connect->query($q);
            $output = '';
            while ($row = $r->fetch_assoc()) {
                $bg = $row['bg'];
                $theme = $row['theme'];
                if($theme != 'orange'){
                    $output .= '<link href="css/userstyles.php?t='.$theme.'" rel="stylesheet"/>';   
                }
                $output .= "<style>\n";
                $output .= "    body{background:$bg}\n";
                $output .= "</style>\n";
            }
            
            return $output;
        }
    }
?>