<!--
/////////////////////////////////////////////////////////////
/* logout.php from CSCI3100 group 15
   03-05-2019
   Purpose: destory session record and allow user to logout
*/
////////////////////////////////////////////////////////////
!-->
<?php
session_start(); 
session_destroy(); 
echo "<script>
alert('You have successfully logged out!');
window.location.href='index.php';
</script>";
?>