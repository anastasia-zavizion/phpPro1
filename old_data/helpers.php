<?php
function show($str){
    if (is_bool($str)){
        var_dump($str);
        echo '<br>';
    }else{
        echo $str.'<br>';
    }
}