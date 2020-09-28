<!--
/////////////////////////////////////////////////////////////
/* view_my_profile.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allow user to view his/her account infomation and previously asked questions.
   
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>My profile - ARM!</title>

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

        .roundrect {
            border-radius: 15px;
        }

    </style>
</head>


<body>
<?php include('menu.php');  ?>

<?php
if ((!isset($_SESSION['uid']))) { // check whether user has login. If not, return to index page
	header("Location: index.php");
	exit();
}
?>
    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
                        <font face="Economica, sans-serif" size="6"><b>View My Profile</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
            <?php header("Content-Type:text/html; charset=utf-8");
                include
                ("connect.php");
				$id = $_SESSION['uid'];
				$sql = "SELECT * FROM user WHERE id='".$id."' LIMIT 1";
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				while ($row = mysqli_fetch_assoc($res)) {
				    if (mysqli_num_rows($res) == 1) { //ensure only one record is fetched.
					    echo '<p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-id-badge"></i> Welcome Back, '.$row['username'].'</b></font></p>';

                        $check = $row['iconPath'];
                        if(empty($check)){ // if icon path not exists.
                            $img = '<img class="roundrect" src="assets/icon/null.jpg" width="250" height = "250">';
                        }else{
                            $img = '<img class="roundrect" src="assets/icon/'.$row['iconPath'].'" width="250" height = "250">';
                        }
                            echo "<div class='row'><div class='col-sm-4 mx-auto'>";
                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><font face='Economica, sans-serif' size='5'>Click to change Icon</font></span>
                                        <span><a href='update_profile.php?ch=icon' class='btn btn-default'>".$img."</a></span>
                                       
                                    </div>
                                </div>";
                            echo "</div><div class='col-sm-8 mx-auto'>";
                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>
                                        person</i><font face='Economica, sans-serif' size='5'>Username  : </font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['username']."</span>
                                    </div>
                                </div>";

                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>email</i>
                                        <font face='Economica, sans-serif' size='5'> Email Address：</font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['email']."</span>
                                        <span><a href='update_profile.php?ch=email' class='btn btn-default'><i class='material-icons'>create</i></a></span>
                                    </div>
                                </div>";
                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>credit_card</i>
                                        <font face='Economica, sans-serif' size='5'> Tokens：</font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['token']."</span>
                                        <span><a href='upload_file.php' class='btn btn-default'><i class='material-icons'>add</i></a></span>
                                </div>
                            </div></div></div>";
                                echo"<div class='card border-dark mb-3'>
                                        <div class='card-body'>
                                            <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>message</i>
                                            <font face='Economica, sans-serif' size='5'> Personal Information：</font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['personalInfo']."</span>
                                            <span><a href='update_profile.php?ch=pInfo' class='btn btn-default'><i class='material-icons'>create</i></a></span>
                                        </div>
                                    </div></div></div>";
				    }
				}
			?>
      <br>
      <div class = "container" style ="border-style: solid;">
        <div class="row">
          <div  class="col">
            <h4>My Questions</h4>
          </div>
        </div>

            <?php
            $sql = "SELECT * FROM questions WHERE questions_creator = '".$id."'ORDER BY post_date DESC";
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            if (mysqli_num_rows($res)){ // feching records of previous ask queestion 
              while($row = mysqli_fetch_assoc($res)){
                $cid = $row['category_id'];
                $qid = $row['qid'];
                $title = $row['questions_title'];
                $creator = $row['questions_creator'];
                $post_date = $row['post_date'];
                if($row['questions_close'] == 0){
                  $close = "<font color='#FF0000'>[Unsolved]</font>";
                }else{
                  $close =  "<font color='#999999'>[Solved]</font>";
                }
                $topic = '<div  class="row">
                            <div class="col">
                              <a href="view_question.php?cid='.$cid."&qid=".$qid.'&pages=1"  class="cat_links">'
                                .$close."".$title.
                              '</a>
                ';
                echo "<hr>";
                echo $topic;
                echo "<br>";
                $topic = '
                  <p style="text-align: right";>Posted on '.$post_date.'</p>';
                echo $topic;
                echo '</div></div>';
              }
            }
            ?>

        </div>



<?php include('footer.php'); ?>
</body>
</html>