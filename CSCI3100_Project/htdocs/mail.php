<!--
/////////////////////////////////////////////////////////////
/* mail.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allow user to send and read mail.
*/
////////////////////////////////////////////////////////////
!-->
<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Economica" rel="stylesheet">
    <title>ARM!</title>

    <style>
        .jumbotron-custom-img{
            background:
                linear-gradient(
                rgba(52, 180, 160, 0.3),
                rgba(0, 0, 0, 0.5)
                ),
                url("assets/images/book.jpg");
            background-size:cover;
        }

        .jumbotron-custom-img2{
            background:
                linear-gradient(
                rgba(52, 180, 160, 0.3),
                rgba(0, 0, 0, 0.5)
                ),
                url("assets/images/question.jpg");
            background-size:cover;
        }
        A.csci3100:visited {color: #ffffff;}
        A.csci3100:active {color: rgb(255, 153, 0);}

        A.link-below:visited {color: #45877b;}
        A.link-below:active {color: rgb(255, 153, 0);}
    </style>
</head>


<body>
<?php include('menu.php');  ?>    

    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
                        <font face="Economica, sans-serif" size="6"><b>Type something</b></font>
                    </p>
                    <a class="btn btn-danger btn-md" href="#" target="_blank">ASK A QUESTION!<i class="fa fa-download pl-2"></i></a>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
            <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i> Your Mail Box</b></font></p>
          
<?php
include("connect.php");
function convertdate($date) {	// data format conversion
	include("connect.php");
	$date = strtotime($date);
	return date("M j, Y g:ia", $date);
}

function geticon($from_id) { // return icon of a user
	include("connect.php");
	$sql7 = "SELECT iconPath FROM user WHERE id='".$from_id."' LIMIT 1";
	$res7 = mysqli_query($db,$sql7) or die(mysql_error($db));
	$row7 = mysqli_fetch_assoc($res7);
	$img = '<img src="assets/icon/'.$row7['iconPath'].'" width="50"/>';
	return $img;
}

function getnickname($from_id) { // reutrn username of a user
	include("connect.php");
	$sql8 = "SELECT username FROM user WHERE id='".$from_id."' LIMIT 1";
	$res8 = mysqli_query($db, $sql8) or die(mysqli_error($db));
	$row8 = mysqli_fetch_assoc($res8);
	return $row8['username'];
}

$my_id = $_SESSION['uid'];
echo "<table ><tr><td valign='top' rowspan='2' width= '300'>";
	echo '<form method="post">
	<div class="form-group">
		<div class="input-group-prepend">
			<span class="input-group-text"><i class="fa fa-user-o" aria-hidden="true"></i></span>
			<input type="text" class="form-control" placeholder = "Someone you want to chat with "name="username" value="" pattern=".{4,255}" title="At least 4 character" required>
		</div>	
		<button type="submit" name = "confirm" class="btn btn-primary">Confirm</button>						
	</div>
	</form>';
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		if (isset($_POST['confirm'])){ // if user press confirm button
			$user2_name = $_POST['username'];
			$sql_getId = "SELECT id FROM user WHERE username='".$user2_name."' LIMIT 1";
			$result = mysqli_query($db, $sql_getId) or die(mysqli_error($db));
			if(mysqli_num_rows($result) > 0){  // finding record that have the username given by user
				$row = mysqli_fetch_assoc($result);
				$user2_id = $row['id'];
				$sql_checkExist = "SELECT * FROM mail_group WHERE ((user1 = '".$my_id."' AND user2 ='".$user2_id."') OR  (user1 = '".$user2_id."' AND user2 = '".$my_id."')) LIMIT 1" ;
				//echo $sql_checkExist;
				$result = mysqli_query($db, $sql_checkExist) or die(mysqli_error($db));
				if(mysqli_num_rows($result) > 0){ // Mail group already exist
					echo "<script type='text/javascript'>
					alert('User has already added to your Mail Box');
					window.location.href='mail.php?';
					</script>";
				}else{ // record not exist
					$sql_insert ="INSERT INTO mail_group (user1 , user2) VALUES ('".$my_id."','".$user2_id."')"; // insert record of new mail group
					//echo $sql_insert;
					$result = mysqli_query($db, $sql_insert) or die(mysqli_error($db))	;
					$sql_selectGroupID = "SELECT id FROM mail_group WHERE user1 = '".$my_id."' AND user2 ='".$user2_id."' LIMIT 1";
					$result = mysqli_query($db, $sql_selectGroupID) or die(mysqli_error($db));
					$row = mysqli_fetch_assoc($result);
					$select_group = $row['id'];
					//echo $sql_selectGroupID;
					echo "<script type='text/javascript'>
					alert('A new user has added to your mail box');
					window.location.href='mail.php?id=".$select_group."';
					</script>";
				}
			}else{ // user not exist
				echo "<script type='text/javascript'>
					alert('User not exist. Please retry');
					window.location.href='mail.php?';
					</script>";
			}
		}
	}

	$get_id = mysqli_query($db, "SELECT * FROM mail_group WHERE (user1 = '".$my_id."') OR  (user2 = '".$my_id."')");
	echo "<div id='T1'><table width= '300'>";
	while ($row = mysqli_fetch_assoc($get_id)) {
		$group_id = $row['id'];
		$user1 = $row['user1'];
		$user2 = $row['user2'];
		if($user1 == $my_id){
			$select_id = $user2;
		}else{
			$select_id = $user1;
		}
		$get_user = mysqli_query($db, "SELECT username FROM user WHERE id = '".$select_id."'");
		$row_user = mysqli_fetch_array($get_user);
		$select_name = $row_user['username'];
		if($select_name != ""){
		echo "<tr height='50'><td><a href='mail.php?id=".$group_id."'>".$select_name."</a><hr/></td></tr>";
		}
	}
	echo "</table></div>";

if(isset($_GET['id'])){

	$select_group = $_GET['id'];
	//$sql = "SELECT id FROM mail WHERE group_id = '".$select_group."'"
	$res = mysqli_query($db, "SELECT * FROM mail WHERE group_id = '".$select_group."'");
	echo "</td>";
	echo "<td>";
	echo "You are chatting with ".$select_name."<br>";
	echo "<font color='#FF0000'>Please refresh manually for receiving new!</font>";
	echo "<div><table width='500' >";
	if(mysqli_num_rows($res) >= 1){
		while($row = mysqli_fetch_array($res)){ // Fetching all previous conversation record
			$from_id = $row['from_id'];
			$content = $row['mail_content'];
			$icon = getIcon($from_id);
			$date = convertdate($row['mail_date']);
			echo "<tr><td width= '50'>$icon</td><td>".getnickname($from_id).":</td></tr><tr><td></td><td>".$content."<hr/>";
			}
	}
	echo "</td></tr></table></div>";
	echo "</td></tr>
	<tr><td><br/>
	Message：<br/><form method='post'>
	<textarea name='message' rows='3' cols='60'></textarea>
	<br/><br/>
	<input type='submit' value='送出'/>
	</form>
	</td></tr>
	</table></div>";
	
	if(isset($_POST['message']) && !empty($_POST['message'])){ // if there is a message and it is not null
		$sql_insertMessage = "INSERT INTO mail (group_id , from_id, mail_content, mail_date)VALUES('".$select_group."','".$my_id."','".$_POST['message']."', now())";
		//echo $sql_insertMessage;
		mysqli_query($db, $sql_insertMessage); // then we insert it into the database
		//echo 'mail.php?id='.$select_group.'';
		echo "<script type='text/javascript'>
			alert('Message sent');
			window.location.href='mail.php?id=".$select_group."';
			</script>";
	}
}else{
	echo "Click a user 's name to find Someone?";
	echo "</tr></table></table></div>";
}


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
        $("#T2").scrollTop(99999);
});
</script>
		  
    </div>
<?php include('footer.php'); ?>
</body>
</html>