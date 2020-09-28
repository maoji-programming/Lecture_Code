<!--
/////////////////////////////////////////////////////////////
/* close_question.php from CSCI3100 group 15
   03-05-2019

   Purpose: Update record that indicate a post is closed or not.

   module used by view_question.php.
   Info would transfer from view_question.php to this page.
   
*/
////////////////////////////////////////////////////////////
!-->
<?php
include_once("connect.php");
$cid = $_GET['cid'];
$qid = $_GET['qid'];
$sql = "UPDATE questions SET  questions_close='1' WHERE qid='".$qid."' LIMIT 1";
$res = mysqli_query($db, $sql) or die(mysqli_error($db));
if (($res)) { // do action according to condition of the sql query 
	echo "<script>
	alert('Closed question！');
	window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1';
	</script>";
} else {
	echo "<script>
	alert('Errrrrrrrrrrrror.');
	window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1';
	</script>";
}
?>
