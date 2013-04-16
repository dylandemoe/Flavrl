<?php

$colours = array(
            'orange' => '#FF9805, #F60',
            'blue' => '#0088cc, #0044cc',
            'black' => '#444444, #222222',
            'green' => '#00a600 ,#008a00',
            'blue2' => '#52aded, #418ce4',
            'gray' => '#ffffff ,#f1f1f1'
                );

function styles($c,$array){
                    
    $cz = explode(",", $array[$c]);
    $c1 = $cz[0];
    $c2 = $cz[1];
    
    $output = <<<EOD
    
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: $c2;
    background-image: -moz-linear-gradient(top, $c1, $c2);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from($c1), to($c2));
    background-image: -webkit-linear-gradient(top, $c1, $c2);
    background-image: -o-linear-gradient(top, $c1, $c2);
    background-image: linear-gradient(to bottom, $c1, $c2);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0044cc', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    
EOD;

    return $output;
}

?>