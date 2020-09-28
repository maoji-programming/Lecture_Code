<!--
/////////////////////////////////////////////////////////////
/* view_question.php from CSCI3100 group 15
   03-05-2019

   Purpose: Provide interface for user to check, discuss and answer others' questions.
   
*/
////////////////////////////////////////////////////////////
-->
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

        .back{
          float:right ;
        }

        .roundrect {
            border-radius: 15px;
        }
    </style>
</head>


<body>
<?php include('menu.php'); $pages = $_GET['pages']; ?>


    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
					<?php
						include("connect.php");
						$cid = $_GET['cid'];
						$sql = "SELECT sub_title FROM sub_categories WHERE cid = '".$cid."' LIMIT 1";
						$res = mysqli_query($db, $sql) or die(mysqli_error($db));
						$row = mysqli_fetch_assoc($res);

						if(mysqli_num_rows($res) == 1){ //ensure the question is under existing subject
							$subject = $row['sub_title'];
							echo"<font face='Economica, sans-serif' size='6'><b>".$subject."</b></font>";
						}else{
							echo "<script>
							window.location.href='404.php';
							</script>";
						}
					?>

                    </p>
          <?php
					echo '<a class="btn btn-danger btn-md" href="ask_question.php?cid='.$cid.'">ASK A QUESTION <i class="fa fa-question-circle"></i></a>';
					?>
                    </div>
            </div>
        </div>


    <div class="container" >
			<?php

				$qid = $_GET['qid'];
				$sql = "SELECT * FROM questions WHERE qid = '".$qid."' LIMIT 1";
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				$row = mysqli_fetch_assoc($res);
				if(mysqli_num_rows($res) == 1){ //ensure only one question is selected
    				$title = $row['questions_title'];
    				echo'<p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-question-circle"></i> '.$title.'</b></font></p>';
            $num_of_view = $row['num_of_view'];
            $num_of_view += 1;
            $update = "UPDATE questions SET num_of_view= '".$num_of_view."' WHERE qid= '".$qid."' AND questions_title= '".$title."'" ;
            mysqli_query($db, $update) or die(mysqli_error($db)); // increase num of view by 1 and update it

				}
			?>

			<?php
				function getusername($uid) { // return username id according to given id.
					include("connect.php");
					$sql = "SELECT username FROM user WHERE id='".$uid."' LIMIT 1";
					$res = mysqli_query($db, $sql) or die(mysqli_error($db));
					$row = mysqli_fetch_assoc($res);
					return $row['username'];
				}

				$qid = $_GET['qid'];
				$sql = "SELECT * FROM questions WHERE qid='".$qid."' LIMIT 1";
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				if (mysqli_num_rows($res) == 1) {// if question  exists 
          echo "<table width='100%'>";

					if (!isset($_SESSION['uid'])) {     //Check right to reply
            echo "<tr><td colspan='2'><p>You can reply after you logged in.</p><hr/></td></tr>";
          }else{
            $row = mysqli_fetch_assoc($res);
            $close = $row['questions_close']; // Check whether user is the creator
              $id1 = $_SESSION['uid'];
              $id2 = $row['questions_creator'];
              if($id1 == $id2 && $close == 0){ // If id equal and question not closed
                echo "<a href='close_question.php?cid=".$cid."&qid=".$qid."'>Close</a>";
            }
          }
          echo"<a href='question_category.php?cid=".$cid."&pages=1' class='back'>Go back to question catagory</a> ";

						$sql2 = "SELECT * FROM posts WHERE question_id='".$qid."'";
						$res2 = mysqli_query($db, $sql2) or die(mysqli_error($db));
            $num = mysqli_num_rows($res2);
            $post_per_page = 10; // maximum number of post rendered in one page
            $lastpage = ceil($num / $post_per_page);
            if ($num > 0){
              $num_loop = 1;
              while ($num_loop <= $num){
                if ($num_loop <= ($pages -1)*$post_per_page ){
                  $row2 = mysqli_fetch_assoc($res2);
                  $id = $row2['post_creator'];
                }else if ($num_loop > ($pages -1)*$post_per_page  && $num_loop <= $pages*$post_per_page ){
                  $row2 = mysqli_fetch_assoc($res2);
                  $id = $row2['post_creator'];
                  $date = $row2['post_date'];

                  $sql3 = "SELECT iconPath FROM user WHERE id ='".$id."'";
                  $res3 = mysqli_query($db, $sql3) or die(mysqli_error($db));
                  $row = mysqli_fetch_assoc($res3);
                  $img = '<img class="roundrect" src="assets/icon/'.$row['iconPath'].'" width="150" height = "150">';
                  echo "<tr>
                  <td width='200' valign='top' align='center' style='border: 4px solid #cccccc;background-color:#FFFFFF;'>User<br/><a href='view_profile.php?uid=".$id."'>".getusername($row2['post_creator'])."</a><br/>
                  $img</td>
    							<td valign='top' style='border: 4px solid #8cca77;background-color:#F4FEDE;border-top-left-radius: 50px;
    				border-bottom-right-radius: 10px;'><div style='min-height: 200px;  max-width : 760px;'><pre align='left'>#$num_loop<span style='float:right;'>Posted on Date: $date</span><hr /><pre>".$row2['post_content']."</pre><br/></div></p></td>
    							</tr><tr><td colspan='2'><br /></td></tr>";
                }
                $num_loop += 1;
              }
            }
					echo "</table>";
				} else { // exit if user enter non-exsist question
					echo 	"<script>
							window.location.href='404.php';
							</script>";
				}
        echo "<p style='text-align:center;''>";
        if($pages !=1){
          echo"<a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1' class='cat_links'>First page</a>";
            echo" | ";

        }
        if($pages >1){
          echo"<a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".($pages-1)."' class='cat_links'>Previous page</a>";
        }
        if ($pages < $lastpage){
          if ($pages != 1){
            echo" | ";
          }
          echo "<a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".($pages+1)."' class='cat_links'>Next page</a>";
        }
        if($pages != $lastpage){
            echo" | ";
          echo"<a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$lastpage."' class='cat_links'>Last page</a>";
        }

      echo "</p>";
				?>


        <?php
          if(isset($_SESSION['uid']) && $close == 0){
        ?>
          <form  method="post" enctype="multipart/form-data">
          <p>Reply Content：</p>
          <textarea name="reply_content" rows="5" cols="75"></textarea>
           <br/><br />
          <input type="submit" name="reply_submit" value="Reply" />
          </form>

          <?php
            $qid = $_GET['qid'];
            $cid = $_GET['cid'];
            if (isset($_POST['reply_submit'])) {
                $creator = $_SESSION['uid'];
                $reply_content = $_POST['reply_content'];

                if(empty($reply_content)){
                echo "<script>
                alert('Please write content！');
                window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$pages."';
                </script>";
                exit();
                }
                date_default_timezone_set("Asia/Hong_Kong");
                $date = date("Y-m-d");
                //echo $date;
                $sql = "INSERT INTO posts (category_id, question_id, post_creator, post_content, post_date) VALUES ('".$cid."', '".$qid."', '".$creator."', '".$reply_content."','".$date."')";
                $res =  mysqli_query($db, $sql) or die(mysqli_error($db));
                $num += 1;
                $lastpage = ceil($num / $post_per_page);

                if ($res) {
                  $sql = "SELECT id from mail_group where user1 = '0' AND user2 = '".$_SESSION['uid']."' LIMIT 1";
                  $get_groupId = mysqli_query($db, $sql);
                  $row = mysqli_fetch_assoc($get_groupId);
                  $select_group = $row['id'];
                  $message = 'Someone has replied your question. <a href ="view_question.php?cid='.$cid.'&qid='.$qid.'&pages='.$lastpage.'">Click here to go check it </a>';
                  //send notifaction to post owener
                  //echo $message;
                  $sql_insertMessage = "INSERT INTO mail (group_id , from_id, mail_content, mail_date)VALUES('".$select_group."','0','".$message."', now())";
                  //echo $sql_insertMessage;
                  mysqli_query($db, $sql_insertMessage);
                  echo "<script>
                  alert('Suucessful！');
                  window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$lastpage."';
                  </script>";
                } else {
                  echo "<script>
                  alert('Fail');
                  window.location.href='view_question.php?cid=".$cid."&qid=".$qid."&pages=".$lastpage."';
                  </script>";
                }
          	  }
            }
				?>
    </div>


<?php include('footer.php'); ?>
</body>
</html>
