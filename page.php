<?php
//$do =isset($_GET['do']) ?$do=$_GET['do']:$do = 'Manage'; if in anther way

$do =''; // بفحص ادا بيرجع دو خلي دو بتساوي الي رجع وادا لاء خلي دو بتساوي المنج
if (isset($_GET['do'])){
    //echo "welcome in do page";
    $do =$_GET['do'];
}else{
    $do = 'Manage';
    //echo 'welcom in Manage page';
}
// بعدين بفحص كل دو الي في جواتها وبطبع الجملة المناسبة
if($do == "Manage"){
    echo 'welcom in Manage page';
}elseif($do == "Add"){
    echo 'welcome in do Add page';
}elseif($do == "Insert"){
    echo 'welcome in do Insert page';
}elseif($do == 'Delete'){
    echo 'welcome in do Delete page';
}elseif($do == 'Edit'){
    echo 'welcome in do Edit page';
}elseif($do == 'Update'){
        echo 'welcome in do Update page';}
else{
    echo "error";

}