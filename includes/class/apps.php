<?php
    class apps{
        var $userID;
        var $connect;

        public function getApps($type){
            if($type == 'list'){
                return $this->appList();
            }
            else if($type == 'user'){
                return $this->userApps();
            }
        }

        private function appList(){
            //this just creates a list of all the apps from the db
            $connect = $this->connect;
            $q = "SELECT * FROM apps";
            $r = $connect->query($q);

            $output = '';
            while ($row = $r->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $display_name = $row['display_name'];
                $bg = $row['bg'];
                $color = $row['color'];
                $manifest = $row['manifest'];

                $output .= <<<EOD

                <li>
                    <a href="javascript:void(0)" data-id="$id" data-m="$manifest" data-name="$name" data-bg="#$bg" data-color="#$color">
                        $display_name
                    </a>
                </li>
EOD;
            }

            return $output;
        }

        private function userApps(){
            //this function will return the user's apps and their props
            $userID = $this->userID;
            $connect = $this->connect;

            $q = "SELECT a.*, r.id AS rid, r.width, r.blend
                FROM apps a
                RIGHT JOIN app_relation r ON r.app = a.id
                WHERE r.usr = '$userID' AND active = '1'";
            
            $r = $connect->query($q);
            $rows = $r->num_rows;
            $output = '';
            
            if($rows >= 1){
                while ($row = $r->fetch_assoc()) {
                    //define the vars
                    $id = $row['rid'];
                    $name = $row['name'];
                    $bg = $row['bg'];
                    $color = $row['color'];
                    $manifest = $row['manifest'];
                    $width = $row['width'];
                    $blend = $row['blend'];
                    $app = strtolower($name);

                    //check the width
                    if($width == 'full'){
                        $widthClass = 'fullsize';
                        $widthSize = '';
                    }
                    else if($width == 'dft'){
                        $widthClass = '';
                        $widthSize = '';
                    }
                    else{
                        $widthClass = '';
                        $widthSize = $width.'px';
                    }

                    //now check blend
                    if($blend == '1'){
                        $blendClass = 'blend';
                    }
                    else{
                        $blendClass = '';
                    }

                    //make output
                    $output = <<<EOD
                    <div id="flavrl-app-$app" data-column-id="$id" 
                    class="app-column notloaded flavrl-app-$name $widthClass $blendClass" 
                    data-man="$manifest" data-name="$name" style="width:$widthSize">
                        <div class="app-header $blendClass" style="background:#$bg;color:#$color">
                            <span class="app-name">$name</span>
                            <div class="app-header-right pull-right">
                                <a href="javascript:void(0)" data-href='' class="icon-refresh" title="Refresh"></a>
                                <a href="" class="icon-external-link" target="_blank" title="Go to website"></a>
                                <a href="javascript:void(0)" class="icon-resize-full btn-size" title="Expand/Shrink"></a>
                                <a href="javascript:void(0)" class="icon-circle-blank btn-blend" title="Blend/Show"></a>
                                <a href="javascript:void(0)" class="icon-remove" title="Remove"></a>
                            </div>
                        </div>
                        <div class="app-body">
                            <div class="app-loading">
                                <i class="icon-spinner icon-spin"></i>
                                Loading data..
                            </div>
                        </div>
                    </div>
EOD;
                }
            }

            return $output;
        }
    }
?>