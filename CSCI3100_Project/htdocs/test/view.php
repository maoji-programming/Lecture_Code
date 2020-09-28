<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/main.css">
    <link rel="stylesheet" href="assets/Rating.css">
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

        A.csci3100:visited {color: #ffffff;}
        A.csci3100:active {color: rgb(255, 153, 0);}

        A.link-below:visited {color: #45877b;}
        A.link-below:active {color: rgb(255, 153, 0);}
		ul.des {
		  list-style-type: none;
		  margin: 0;
		  padding: 0;
		  overflow: hidden;
		}

		li.des2 {
		  float: left;
		  padding: 16px;
		  text-decoration: none;
		  border-left: 2px solid rgb(255, 153, 0);

		}
#T2 {
  height:130px;
  width: 500px;
  overflow:auto;
  margin-top:20px;
 }
    </style>
</head>


<body>
<?php include('menu.php');   ?>

<?php
	include("connect.php");
	$fid = $_GET['fid'];
	$sql = "SELECT * FROM resource WHERE fid = '".$fid."' LIMIT 1";
	$res = mysqli_query($db, $sql) or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($res);
  $res_2 = mysqli_query($db, "SELECT AVG(rating) FROM rating WHERE fid = '".$fid."'") or die(mysqli_error($db));

	if(mysqli_num_rows($res) == 1){
		$uploader = $row['uid'];
		#$school = $row['school'];
		#$subject = $row['subject'];
		$type = $row['type'];
		$pages = $row['pages'];
		$file = $row['file_url'];
		$pay = $row['price'];
		//echo $file;
		$rating = $row['rating'];
    $rating = (int)mysqli_fetch_assoc($res_2)['AVG(rating)'];
		$file_url = $row['file_url'];
		//echo'<font face="Economica, sans-serif" size="6"><b>'.$fid.'</b></font>';

	}else{
		echo "<script>
		window.location.href='404.php';
		</script>";
	}
	
	$sql_t = "SELECT token FROM user WHERE id = '".$_SESSION['uid']."' LIMIT 1";
	$res_t = mysqli_query($db, $sql_t) or die(mysqli_error($db));
	$row_t = mysqli_fetch_assoc($res_t);
	if(mysqli_num_rows($res_t) == 1){
		$token = $row_t['token'];
		
	}
	
	
?>

    <div class="jumbotron jumbotron-fluid jumbotron-custom-img">
        <div class="container">
            <p style="color: rgba(255,255,255,.9)">
                <font face="Economica, sans-serif" size="6"><b>The Source Library for Secondary Students</b></font>
            </p>
            <p style="color: rgba(255,255,255,.9)">
                <font face="Economica, sans-serif" size="7">A</font><font face="Economica, sans-serif" size="6">cademic</font>
                <font face="Economica, sans-serif" size="7">R</font><font face="Economica, sans-serif" size="6">esource</font>
                <font face="Economica, sans-serif" size="7">M</font><font face="Economica, sans-serif" size="6">aster</font>
            </p>

            <!--searching bar-->
            <form class="card card-sm">
                <div class="card-body row no-gutters align-items-center">
                    <div class="col-auto">
                        <i class="fa fa-search" style="color:#45877b; font-size: xx-large"></i>&ensp;
                    </div>
                    <div class="col">
                        <input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Find Resources!">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-lg btn-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
            <!--end of searching bar-->

        </div>
    </div>
    <!--end of heading-->




    <div class="container">
        <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-file-pdf-o"></i> Preview</b></font></p>
		<div class = "row">
		<div class="container">
		<?php
			function getusername($uid) {
				include("connect.php");
				$sql = "SELECT username FROM user WHERE id='".$uid."' LIMIT 1";
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				$row = mysqli_fetch_assoc($res);
				return $row['username'];
			}

			#Cancel
			#
			#	<li class ='des2'><div>School:</div>".$school."</li>
			#	<li class ='des2'><div>Subject:</div>".$subject."</li>
			#
			echo "<ul class ='des'>
				<li class ='des2'><div>Type:</div>".$type."</li>
				<li class ='des2'><div>Uploaded by:</div>".getusername($uploader)."</li>
				<li class ='des2'><div>Pages:</div>".$pages."</li>
				<li class ='des2'><div><i class='fa fa-thumbs-o-up' aria-hidden='true'></i>Rating:</div>".$rating."</li>
			</ul>";

		?>

<?php
if (!extension_loaded('imagick')){
    echo 'imagick not installed';
}
?>

		</div>
		</div>

		<br/>
          <div class = "row" >

            <div class = "col">
			<?php 
			  echo "<object width='100%' height='800' data='source_database/preview/".$file."_preview.pdf#zoom=100#view=FitH'></object>";
			  			  //<object width="100%" height="800" data="source_database\HKDSE2012Chinese_paper1.pdf#zoom=100#view=FitH"></object>
			?>
			</div>
            <div class = "col-sm-5 mx-auto">
              <div class="container">
                  <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-download"></i> Download</b></font></p>
					
						<form class="row" name="reply_submit" value="Reply" />
							<div class="col-lg-12 sm-auto">
							<p>
								<?php echo "<a href='source_database/preview/".$file."_preview.pdf' download" ?>
								class="btn btn-sq-lg btn-primary btn-lg btn-block" name="preview_submit" value="Download Preview" />
								<i class="fa fa-eye fa-5x"></i><br>Download Preview
								</a>
								
								
							</p>
						</div>
						<div class="col-lg-12 sm-auto">
							<p>
								
							
							<?php 

								
            
								echo "<a type='submit' href='source_database/".$file.".pdf' download class='btn btn-sq-lg btn-success btn-lg btn-block' name='full_submit' value='Download Full Version'><i class='fa fa-cart-arrow-down fa-5x'></i><br>Download Full Version<br>";		
								if($token == 0){
									echo "FREE";
								}else{
									echo $pay." HKD.";
									
								}					
							?> 
							  </a>	
						  </p>
						</div>
						
						
						</form>
					<?php
					if (isset($_POST['full_submit'])){
							echo "<script>alert('YYYYYYYY!')</script>";
									if ($_SESSION['uid'] == "") {
										echo "<script>alert('You should login first!')</script>";
										header("Location: index.php");
										exit();
									}else{
										$buy_sql = "SELECT uid FROM trade WHERE fid =".$fid;
										$buy_res = mysqli_query($db, $buy_sql) or die(mysqli_error($db));
										while($buy_row = mysqli_fetch_assoc($buy_res)){
											
											if($_SESSION['uid'] == $buy_row['uid']){
												echo "$pay=0";
												$pay = 0;
												break;
											}
										}
											if ( $token - $pay < 0){
												//no token
												echo "<script>alert('You do not have enough token!')</script>";
												header("Location: index.php");
												exit();
											}else{
												//cut token
												if($pay != 0){
													$token = $token - $pay;
													$sql_u = "UPDATE user SET token = ".$token."WHERE id =".$_SESSION['uid']." ";
													echo "UPDATE user SET token = ".$token."WHERE id =".$_SESSION['uid']." ";
													mysqli_query($db,$sql_u);
													echo "<script>alert('Payment Success!')</script>";
													$sql_i = "INSERT INTO trade (uid, fid) VALUES (".$_SESSION['uid'].",".$fid.")";
													echo "INSERT INTO trade (uid, fid) VALUES (".$_SESSION['uid'].",".$fid.")";
													mysqli_query($db,$sql_i);
												}
												
													
												
												
											}
											
											
										
										
									}
										
										
										
									
									
									
									
								}
					?>
		
											   
              <div class="container">
                  <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-commenting"></i> Comment</b></font></p>
                  <?php
                  include("connect.php");
                  $sql =  "SELECT uid FROM rating WHERE fid='".$fid."' AND uid= '".$_SESSION['uid']."'  LIMIT 1";
                  $res = mysqli_query($db, $sql) or die(mysqli_error($db));
                  if (mysqli_num_rows($res) > 0){
                    echo "Your have voted already, Thankyou!!!";
                  }
                  else{
                    echo '
                    <n-star-rating value = "3" number = "5" id ="rating"></n-star-rating>
                    <script src ="assets/Rating.js"></script>
                    <script> rating.addEventListener("rate", () =>{

                      console.log(rating.value);
                      alert("Thankyou for your vote");
                      window.location.href = window.location.href="create_rating.php?fid='.$fid.'&vote="+rating.value;
                    });
                    </script>
                    ';
                  }

                ?>
				<div id='T2'><table>
          <tr style='background-color:#b6ead4'><td width='280'>Content</td><td width = 50>User</td><td>Post date</td></tr>
          <?php
            include("connect.php");
            $sql =  "SELECT * FROM comment WHERE fid='".$fid."' ORDER BY timedate ASC";
            $res = mysqli_query($db, $sql) or die(mysqli_error($db));
            if (mysqli_num_rows($res) > 0){
              while($row = mysqli_fetch_assoc($res)){
                $content = $row['content'];
                $date_time = $row['timedate'];
                $row = mysqli_fetch_assoc(mysqli_query($db,"SELECT username FROM user WHERE id='".$row['uid']."'"));
                $user_name = $row['username'];
                echo "<tr><td>".$content."</td><td>".$user_name."</td><td>".$date_time."</td></tr>";
              }
            }
          ?>

				</table></div>
                <?php include('comment.php');?>
              </div>
            </div>

          </div>
    </div>
	</div>

<?php include('footer.php'); ?>

</body>


</html>
