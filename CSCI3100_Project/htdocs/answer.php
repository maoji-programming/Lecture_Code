<!--
/////////////////////////////////////////////////////////////
/* answer.php from CSCI3100 group 15
   03-05-2019

   Purpose: provide module which allows user send answer to database

   Module used by view_question.php.
   Included by view_question.php
*/
////////////////////////////////////////////////////////////
!-->

<?php
if ((!isset($_SESSION['uid']))) { // check whether user has login. If not, return to index page
	header("Location: index.php");
	exit();
}
$qid = $_GET['qid']; // get values from GET method
$cid = $_GET['cid'];
?>

<form  method="post" enctype="multipart/form-data">
<p>Reply Content：</p>
<textarea name="reply_content" rows="5" cols="75"></textarea>
 <br/><br />
<input type="submit" name="reply_submit" value="Reply" />
</form>

<?php
	if (isset($_POST['reply_submit'])) { // check whether there is message from view_question.php.
		include_once("connect.php");// Using "connect.php" module.
		$creator = $_SESSION['uid'];
		$row = mysqli_fetch_assoc(mysqli_query("SELECT * FROM questions WHERE id='".$qid."'"));
		$reply_content = $_POST['reply_content'];

		if(empty($reply_content)){ // emtpy content detected
		echo "<script>
		alert('Please write content！');
		window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$pages."';
		</script>";
		exit();
		}

   	 	$sql = "INSERT INTO posts (category_id, question_id, post_creator, post_content) VALUES ('".$cid."', '".$qid."', '".$creator."', '".$reply_content."')";
		$res =  mysqli_query($db, $sql) or die(mysqli_error($db));

		if ($res) { // respond according to status of the sql query
		echo "<script>
		alert('Suucessful！');
		window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$pages."';
		</script>";
		} else {
		echo "<script>
		alert('Fail');
		window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$pages."';
		</script>";
		}
	}
?>
