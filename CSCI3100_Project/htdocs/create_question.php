<!--
/////////////////////////////////////////////////////////////
/* create_question.php from CSCI3100 group 15
   03-05-2019

   Purpose: Process info from ask_question.php and send to database
*/
////////////////////////////////////////////////////////////
!-->
<?php header("Content-Type:text/html; charset=utf-8");
session_start();

if (!isset($_SESSION['uid'])) { // check whether user has login. If not, return to index page
	header("Location: index.php");
	exit();
}
if (isset ( $_POST ['topic_submit'] )) {  //check whether there are messages come from ask_question.php.
	if (($_POST ['topic_title'] == "") or ($_POST ['topic_content'] == "")) { // Case of title or content is null
		echo "<script>
		alert('Please fill in the topic and the content.');
		window.location.href='ask_question.php?cid=" . $cid . "';
		</script>";
		exit ();
	} else {
		include_once ("connect.php");
		$cid = $_POST['cid'];
		$title = $_POST ['topic_title'];
		$content = $_POST ['topic_content'];
		$creator = $_SESSION ['uid'];
		date_default_timezone_set("Asia/Hong_Kong");
		$date = date("Y-m-d");

		$sql = "INSERT INTO questions (category_id, questions_title, questions_creator, post_date) VALUES ('" . $cid . "', '" . $title . "', '" . $creator . "','" . $date . "')";
		$res = mysqli_query($db, $sql) or die(mysqli_error($db));
		$new_topic_id = mysqli_insert_id ($db);

    	$sql2 = "INSERT INTO posts (category_id, question_id, post_creator, post_content, post_date) VALUES ('" . $cid . "', '" . $new_topic_id . "', '" . $creator . "', '" . $content . "','" . $date . "')";
	  	$res2 = mysqli_query($db, $sql2) or die(mysqli_error($db));

		if (($res)) { // respond according to status of the sql query
			echo "<script>
				alert('Posted successful');
				window.location.href='view_question.php?cid=" . $cid . "&qid=" . $new_topic_id . "&pages=1';
				</script>";
		} else {
			echo "<script>
				alert('An Error Was Encoountered. Please try it later.');
				window.location.href='view_category.php?cid=" . $cid . "';
				</script>";
		}
	}
}
?>
