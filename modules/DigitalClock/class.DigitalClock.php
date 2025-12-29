<?php
/*
 * PHP-Digital Clock
 * @author Angelos Staboulis
 * @town Komotini
 * @country Greece
 */
class DigitalClock {
    /**Print Digital Clock**/
    function jsDigitalClock($left,$top){
                    $div1='"div1"';
                    $proc='"printTime()"';
                    $style="font-size:14px;font-weight:bold;";
                    echo "<div style=$style id=".$div1.">";
                    $retvalue="<script language=javascript>".
                           "var int=self.setInterval(".$proc.",1000);".   
                           "function printTime(){".
                           "var d=new Date();".
						   "var m=parseInt(d.getMonth())+parseInt(1);".
                           "var t = d.getDate()+'-'+m+'-'+d.getFullYear()+ ' ' + d.toLocaleTimeString();".
                           "document.getElementById(".$div1.").innerHTML=t;".
                           "}". 
                           "</script>";
                    echo $retvalue;
                    echo "</div>";     
    }
   
    /** Get Hours **/
    function getHours(){
      $hours=getdate();
      return $hours["hours"];
    }
    /** Get Minutes **/
    function getMinutes(){
      $minutes=getdate();
      return $minutes["minutes"];
        
    }
    /** Get Seconds **/
    function getSeconds(){
      $seconds=getdate();
      return $seconds["seconds"];
    }
}
?>
