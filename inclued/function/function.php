<?php

/*  function get title 
    echo page title for each page 
*/
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else{
        echo 'Defult';
    }
}