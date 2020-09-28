<!--
/////////////////////////////////////////////////////////////
/* comment.php from CSCI3100 group 15
   03-05-2019

   Purpose: Insert record of comment in database

   Module used by view.php.
   Included by view.php
   
*/
////////////////////////////////////////////////////////////
!-->

<?php
	if(isset($_SESSION['uid'])){
		echo "<form  method='post' enctype='multipart/form-data'>
				<p>Comment：</p>
				<textarea name='reply_content' rows='5' cols='50'></textarea>
				<br/><br/>
				<input type='submit' name='reply_submit' value='Reply' />
			</form>
			";
		if (isset($_POST['reply_submit'])) { //check whether there is message from view.php.
			include_once("connect.php"); // Using "connect.php" module.
			$fid = $_GET['fid'];
			$creator = $_SESSION['uid'];
			$row = mysqli_fetch_assoc(mysqli_query("SELECT * FROM resource WHERE id='".$fid."'"));
			$reply_content = $_POST['reply_content'];

			if(empty($reply_content)){ //emtpy content detected
			echo "<script>
			alert('Please write content！');
			window.location.href='view.php?fid=".$fid."';
			</script>";
			exit();
			}

			$sql = "INSERT INTO comment (uid, fid, content, timedate) VALUES ('".$creator."', '".$fid."', '".$reply_content."', now())";
			$res =  mysqli_query($db, $sql) or die(mysqli_error($db));

			if ($res) { //respond according to status of the sql query
			echo "<script>
			alert('Suucessful！');
			window.location.href='view.php?fid=".$fid."';
			</script>";
			} else {
			echo "<script>
			alert('Fail');
			window.location.href='view.php?fid=".$fid."';
			</script>";
			}
		}
	}
?>
