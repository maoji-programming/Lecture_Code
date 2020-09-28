<?php
	if ($_SESSION['uid'] == "") {
		header("Location: index.php");
		exit();
	}
if (isset($_POST['submit'])) {
	if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
	  echo 'NAME: ' . $_FILES['my_file']['name'] . '<br/>';
	  echo 'TYPE: ' . $_FILES['my_file']['type'] . '<br/>';
	  echo 'SIZE: ' . ($_FILES['my_file']['size'] / 1024) . ' KB<br/>';
	  echo 'TMP: ' . $_FILES['my_file']['tmp_name'] . '<br/>';

	$file = $_FILES['my_file']['tmp_name'];
	$dest = 'source_database/' . $_FILES['my_file']['name'];


	move_uploaded_file($file, $dest);
	
	//echo 'ERROR:' . $_FILES['my_file']['error'] . '<br/>';
	}
}
?>	