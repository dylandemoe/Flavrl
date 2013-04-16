<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';
include '../includes/colours.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    $list = '';
    
    foreach($colours as $key=>$value){
        $style = styles($key,$colours);
        
        $list .= '<li class="span2">';
        $list .=    '<a title="'.$key.'" href="javascript:void(0)" class="thumbnail" style="background:'.$style.'"></a>';
        $list .= '</li>';
    }
    
?>
    
    <script>
        $(document).ready(function(){
            thMetaOpen()
        });
    </script>
    
    <div id="theme">
        <ul class="thumbnails colorbg">
            <?php echo $list ?>
        </ul>
    </div>
<?php
}

?>