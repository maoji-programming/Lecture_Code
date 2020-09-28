<!--
/////////////////////////////////////////////////////////////
/* connect.php from CSCI3100 group 15
   03-05-2019

   Purpose:  Store all info required to connect database

   module used by most page connected to database.
   
*/
////////////////////////////////////////////////////////////
!-->

<?php 
$host = "localhost";
$username = "root"; 
$password = "";
$database = "arm"; 

$db =mysqli_connect($host, $username, $password, $database);
?>