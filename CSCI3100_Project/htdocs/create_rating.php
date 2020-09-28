<!--
/////////////////////////////////////////////////////////////
/* create_rating.php from CSCI3100 group 15
   03-05-2019

   Purpose: Insert record of rating in database

   Module used by view.php.
   Included by view.php
   
*/
////////////////////////////////////////////////////////////
!-->
<?php header("Content-Type:text/html; charset=utf-8");
session_start();
if (isset($_SESSION['uid'])) {
  include_once("connect.php");
  $fid = $_GET['fid'];
  $vote = $_GET['vote'];
  $voter = $_SESSION['uid'];
  $sql = "INSERT INTO rating (fid, uid, rating) VALUES ('".$fid."','".$voter."','".$vote."')";
  $res = mysqli_query($db, $sql) or die(mysqli_error($db));
  if ($res) {
  echo "<script>
  window.location.href='view.php?fid=".$fid."';
  </script>";
  } else {
  echo "<script>
  window.location.href='view.php?fid=".$fid."';
  </script>";
  }
}else{
  header("Location: index.php");
	exit();
}
?>
