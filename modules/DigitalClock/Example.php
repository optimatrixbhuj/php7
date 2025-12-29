<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
<?php
 // put your code here
 include("DigitalClock.php");
 $clock=new DigitalClock();
 echo $clock->getHours().":".$clock->getMinutes().":".$clock->getSeconds();
 echo $clock->jsDigitalClock(100, 100);
?>
    </body>
</html>
