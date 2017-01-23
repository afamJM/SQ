<?php


$cookieStr      = $_COOKIE['nsec'];
parse_str($cookieStr, $output);

if(isset($output['ci'])){
    echo 'true';
}else{
    echo 'false';
}

?>