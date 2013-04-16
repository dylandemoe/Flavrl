<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    include '../includes/config.php';

    $s = '';
    
    //Get the imgs for the default folder
    foreach (glob("../img/s/*") as $filename) {
        $base = basename($filename);
        $file = $self.'img/s/'.$base;
        $s .= '<li class="span2"><a href="javascript:void(0)" class="thumbnail" style="background:url('.$file.')"></a></li>';
    }
?>    
    
    <script>
        $(document).ready(function(){
            bgMetaOpen();   
        });
    </script>
    
    <div id="background">
        <ul class="thumbnails colorbg">
            <li class="span2">
                 <a href="javascript:void(0)" class="thumbnail" style="background:white"></a>
            </li>
            <li class="span2">
                <a href="javascript:void(0)" class="thumbnail" style="background:#999"></a>
            </li>
            <li class="span2">
                 <a href="javascript:void(0)" class="thumbnail" style="background:#222"></a>
            </li>
        </ul>
        <hr/>
        <!-- These Patterns are from subtlepatterns.com -->
         <ul class="thumbnails ">
            <?php echo $s ?>
         </ul>
    </div>
    

<?php   
}

?>