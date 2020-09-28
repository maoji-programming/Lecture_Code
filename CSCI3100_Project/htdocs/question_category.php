<!--
/////////////////////////////////////////////////////////////
/* question_category.php from CSCI3100 group 15
   03-05-2019

   Purpose: Provide user interface for user to look up questions according to the categroy which already selected previously
   
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
        .catagory_box{
          border-style : hidden;
          border-color: #d9d9d9;
          padding:0 0 0 0;
          margin:-3px 3px 0 0;
          *margin:0 0 0 -5px;
          width:auto;
        }
        .back{
          float:right ;
        }
		
		.little_box{
			border: 2px solid gray;
			border-radius: 7px;
			height: 70px;
			width: 70px;
			text-align: center;
			margin: 5px;  
		}
    </style>
</head>


<body>
<?php include('menu.php');  ?>

    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
					<?php
						include("connect.php");
						$cid = $_GET['cid'];
						$sql = "SELECT sub_title FROM sub_categories WHERE cid = '".$cid."' LIMIT 1"; // get the sub_title of a particualr subject according to the cid
						$res = mysqli_query($db, $sql) or die(mysqli_error($db));
						$row = mysqli_fetch_assoc($res);
						if(mysqli_num_rows($res) == 1){ // exactly one record return 
							$subject = $row['sub_title'];
							echo'<font face="Economica, sans-serif" size="6"><b>'.$subject.'</b></font>';
						}else{// no subject_title reutrn 
							echo"<script>
							window.location.href='404.php';
							</script>";
						}
					?>

                   </p>
          <?php
					echo '<a class="btn btn-danger btn-md" href="ask_question.php?cid='.$cid.'" >ASK A QUESTION <i class="fa fa-question-circle"></i></a>';
					?>
                    </div>
            </div>
        </div>
        <!--end of heading-->


        <div class="container" >
                <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i>What are other people asking?</b></font></p>
                <?php
                  $pages = $_GET['pages'];
            			function getusername($uid) { // function for return username according to a given id
            				include("connect.php");
            				$sql = "SELECT username FROM user WHERE id='".$uid."' LIMIT 1";
            				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
            				$row = mysqli_fetch_assoc($res);
            				return $row['username'];
            			}

            				$sql = "SELECT * FROM questions WHERE category_id='".$cid."' ORDER BY post_date DESC, qid DESC";
            				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
                    $num = mysqli_num_rows($res);
                    $lastpage = ceil($num / 5); // a page have maximum of 5 question
            				if ($num > 0) {
                      $num_loop = 0;
            					//echo '<table width="100%" style="border-collapse: collapse;">';
            					//echo "</td><tr style='background-color: #b6ead4;'><td width='20'><td>Question</td><td width='150'>Creator</td><td width='100'>Posted date</td><td width='100'>Reply</td></tr>";
                        while ($num_loop < $num){ // until all questions has been fetch
                          if ($num_loop >= ($pages -1)*5  && $num_loop < $pages*5 ){ // maxium of 5 question
                            $row = mysqli_fetch_assoc($res);
                            $qid = $row['qid'];
                						$title = $row['questions_title'];
                						$creator = $row['questions_creator'];
                            $post_date = $row['post_date'];
                            $sql2 = "SELECT * FROM posts WHERE question_id='".$qid."'";
                						$res2 = mysqli_query($db, $sql2) or die(mysqli_error($db));
                            $reply = mysqli_num_rows($res2) -1;
                            $view = $row['num_of_view'];
                						if($row['questions_close'] == 0){
                							$close = "<font color='#FF0000'>[Unsolved]</font>";
                						}else{
                							$close = "<font color='#999999'>[Solved]</font>";
                						}
                					$topics = "<hr>
                            <div class = 'container'>
                            <div class = 'row'>
                              
                              <div class = 'col-1 d-none d-lg-block little_box'>
                                View <br>".$view."
                              </div>
                              <div class = 'col-1 d-none d-lg-block little_box'>
                                Reply <br>".$reply."
                              </div>
                              <div class = 'col-auto'>
                                <div class = 'row'>
                                <a  href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1' target='_blank'>
                                  ".$close."".$title."
                                </a>
                                </div>
                                <div class = 'row'>
                                Ask by ".getusername($creator)." | Last post at ".$post_date."
                                </div>
                              </div>
                                  
                            </div>
                            </div>";
                						echo $topics;
                          }
                          $num_loop += 1;
                        }

                        echo "<p style='text-align:left;''>";
                        echo " Page: ";
                        for ($i = 1; $i <= $lastpage; $i++){
                          echo "<a href='question_category.php?cid=".$cid."&pages=".$i."' class='cat_links'>$i</a>";
                          echo " ";
                        }
                        echo"<a href='question.php?' class='back'>Go back to subjects</a> ";
                        echo "</p>";

            					//echo '</table>';
                      echo "<p style='text-align:left;''>";
                      if($pages !=1){
                        echo"<a href='question_category.php?cid=".$cid."&pages=1' class='cat_links'>First page</a>";
                          echo" | ";

                      }
                      if($pages >1){
                        echo"<a href='question_category.php?cid=".$cid."&pages=".($pages-1)."' class='cat_links'>Previous page</a>";
                      }
                      if ($pages < $lastpage){
                        if ($pages != 1){
                          echo" | ";
                        }
                        echo "<a href='question_category.php?cid=".$cid."&pages=".($pages+1)."' class='cat_links'>Next page</a>";
                      }
                      if($pages != $lastpage){
                          echo" | ";
                        echo"<a href='question_category.php?cid=".$cid."&pages=".$lastpage."' class='cat_links'>Last page</a>";
                      }

                    echo "</p>";

            				} else {
            					echo "<p>No Question</p>";
            				}
            			?>
        </div>

<?php include('footer.php'); ?>
</body>
</html>
