<?php
//Use this class to manage how the search engines are displayed

    class searchEngines{
        
        var $userID;
        var $connect;
        
        public function getEngines($type){
            if($type == 'header'){
                return $this->header_engines();
            }
            else if($type == 'settings'){
                return $this->settings_engines();
            }
        }
        
        private function header_engines(){
            $userID = $this->userID;
            $connect = $this->connect;
            
            $q = "SELECT s.*, u.dft
                FROM s_engine s
                RIGHT JOIN uTe u ON u.engine = s.id
                WHERE u.usr = '$userID' ORDER BY s.full_name";
            
            $result = $connect->query($q);
            $rows = $result->num_rows;
            $list = '';
            
            include 'favicon.php';
            $fav = new iconGrabber;
            
            if($rows >= 1){
                while ($row = $result->fetch_assoc()) {
                  $n = $row['full_name'];
                  $url = $row['url'];
                  $dft = $row['dft'];
                  $fav->url = $url;
                  $img = $fav->getIcon(true,'');
                  $data = 'data-action="'.$url.$row['action'].'" data-sq="'.$row['search_q'].'"'; 
                  $data .= 'data-h1="'.$row['hidden_q1'].'" data-h2="'.$row['hidden_q2'].'"';
                  $data .= ' data-short="'.$row['short_name'].'" data-dft="'.$dft.'"';
                  
                  if(($dft == 'false' && !isset($firstSearch)) || !isset($firstplace)){
                    $firstSearch = $n;
                    $fSimg = $fav->getIcon(true,'main-search-img');;
                    $firstplace = true;
                  }
                  else if($dft == 'true'){
                    $firstSearch = $n;
                    $fSimg = $fav->getIcon(true,'main-search-img');;
                    $firstplace = true;
                  }
    
                  $list .= '<li '.$data.' class="main-search-item" id="he'.$row['id'].'"><a data-name="'.$n.'" ';
                  $list .= 'href="javascript:void(0)">'.$img.' '.$n.'</a></li>';  
    
                }
                $default = $fSimg.'<input type="text" class="span3 main-search" placeholder="Search '.$firstSearch.'">';
            }
            
            $output = <<<EOT
            
             <form class="navbar-search pull-left input-append btn-group" id="main-form" method="get" target="_blank">
                $default
                <button type="submit" class="btn"><i class="icon-search"></i></button>
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                    <span class="caret"></span>
                </a> 
                <ul class="dropdown-menu span3 main-search-list">
                    $list
                    <li class="divider"></li>
                    <li>
                        <a class="modal-link" href="javascript:void(0)" data-close='updateEngines' data-href="modal/se.php" data-id="-editSearch" data-head="Search Engines">
                            <i class="icon-cog"></i> Edit
                        </a>
                    </li>
                </ul>
            </form>
EOT;

            return $output;
        }
        
        private function settings_engines(){
            $userID = $this->userID;
            $connect = $this->connect;
            $buttons = '';
            $q = "SELECT * FROM s_engine ORDER BY full_name";
            
            $result = $connect->query($q);
            
            include 'favicon.php';
            $fav = new iconGrabber;
            
            while ($row = $result->fetch_assoc()) {
                $fName = $row['full_name'];
                $id = $row['id'];
                $fav->url = $row['url'];
                $img = $fav->getIcon(true,'');
                $buttons .= <<<EOT
                    <div class="btn-group" data-id="$id" id="engine$id">
                      <button class="btn normal">$img <span>$fName</span></button>
                      <button class="btn fav-icon-b"><i class="fav-icon icon-star-empty"></i></button>
                    </div>            
EOT;
            }
            
            $output = <<<EOT
                <script>
                    $(document).ready(function(){
                        loadEngines();
                    })
                </script>
                <div class="engine_settings" id="engine_settings">
                    $buttons
                </div>       
EOT;

            return $output;
        }
    }
    
?>