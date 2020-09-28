<!--
/////////////////////////////////////////////////////////////
/* view_profile.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allow user to view profile of other users and his/her previously asked questions.
   
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
    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
                        <font face="Economica, sans-serif" size="6"><b>View Profile</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
            <?php header("Content-Type:text/html; charset=utf-8");
				include("connect.php");
				$id = $_GET['uid'];
				$sql = "SELECT * FROM user WHERE id='".$id."' LIMIT 1";
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				while ($row = mysqli_fetch_assoc($res)) { // fetching record
				    if (mysqli_num_rows($res) == 1) { // ensure there only exists one record
                        $userName = $row['username'];
					    echo '<p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-id-badge"></i> This is '.$userName.'\'s profile.</b></font></p>';

                        $check = $row['iconPath'];
                        if(empty($check)){ // in case of there does not exist icon
                            $img = '<img class="roundrect" src="assets/icon/null.jpg" width="250" height = "250">';
                        }else{
                            $img = '<img class="roundrect" src="assets/icon/'.$row['iconPath'].'" width="250" height = "250">';
                        }
                            echo "<div class='row'><div class='col-sm-4 mx-auto'>";
                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span>".$img."</span>
                                       
                                    </div>
                                </div>";
                            echo "</div><div class='col-sm-8 mx-auto'>";
                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>
                                        person</i><font face='Economica, sans-serif' size='5'>Username  : </font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$userName."</span>
                                    </div>
                                </div>";

                            echo"<div class='card border-dark mb-3'>
                                    <div class='card-body'>
                                        <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>email</i>
                                        <font face='Economica, sans-serif' size='5'> Email Address：</font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['email']."</span>
                                    </div>
                                </div>";
                                echo"<div class='card border-dark mb-3'>
                                        <div class='card-body'>
                                            <span class = 'd-inline p-2 bg-dark text-white'><i class='material-icons'>message</i>
                                            <font face='Economica, sans-serif' size='5'> Personal Information：</font></span> <span>&nbsp;&nbsp;&nbsp;&nbsp;".$row['personalInfo']."</span>
                                        </div>
                                    </div></div></div>";
				    }
				}
			?>
      <br>
      <div class ="container" style ="border-style: solid;">
        <div class="row">
          <div  class="col">
            <h4> <?php echo "$userName's questions"; ?> </h4>
          </div>
        </div>

            <?php
            $sql = "SELECT * FROM questions WHERE questions_creator = '".$id."'ORDER BY post_date DESC";
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            if (mysqli_num_rows($res)){ // if there is any record reuturn.
              while($row = mysqli_fetch_assoc($res)){ // fetching all records of previous questions.
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
    </div>



<?php include('footer.php'); ?>
</body>
</html>