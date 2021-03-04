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

function checkItem($select,$from,$value){
    global $con;
    $statment = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();
    return $count;

}
/*
** Redirect function v2.0
** Redirect function [accept parameter]
** first [the message]
** second [url]
** thired [number of seconds]
*/
function redirectPage($Msg ,$url = null,$seconds = 3){
    if($url === null){
        $url = "index.php";
        $link = "Home Page";
    }else{
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ){
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'previes Page';
        }else{
            $url = "index.php";
            $link = "Home Page";
        }
    }
    echo  $Msg ;
    echo "<div class = 'alert alert-info'> You will be redirect to $link after $seconds Seconds </div>";
    header("Refresh:$seconds ; url=$url");
    exit();
}