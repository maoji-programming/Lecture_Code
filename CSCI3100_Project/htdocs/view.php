<!--
/////////////////////////////////////////////////////////////
/* view.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allow user to view, purchase and download resource
   
*/
////////////////////////////////////////////////////////////
-->
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
<?php include('menu.php'); 
include('search_header.php');  ?>

<?php
	include("connect.php");
	$fid = $_GET['fid'];
	$sql = "SELECT * FROM resource WHERE fid = '".$fid."' LIMIT 1";
	$res = mysqli_query($db, $sql) or die(mysqli_error($db));
	$row = mysqli_fetch_assoc($res);
  $res_2 = mysqli_query($db, "SELECT AVG(rating) FROM rating WHERE fid = '".$fid."'") or die(mysqli_error($db));

	if(mysqli_num_rows($res) == 1){ // finding exactly one record of a resource
		$uploader = $row['uid'];
		#$school = $row['school'];
		#$subject = $row['subject'];
		$type = $row['type'];
		$displayname = $row['name'];
		$file = $row['file_url'];
		$pay = $row['price'];
		//echo $file;
		$rating = $row['rating'];
    $rating = (int)mysqli_fetch_assoc($res_2)['AVG(rating)'];
		$file_url = $row['file_url'];
		//echo'<font face="Economica, sans-serif" size="6"><b>'.$fid.'</b></font>';

	}else{ // not found
		echo "<script>
		window.location.href='404.php';
		</script>";
	}
?>


    <div class="container">
        <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-file-pdf-o"></i> Preview</b></font></p>
		<div class = "row">
		<div class="container">
		<?php
			function getusername($uid) { // return username according to id given
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
				<li class ='des2'><div>Name:</div>".$displayname."</li>
				<li class ='des2'><div>Type:</div>".$type."</li>
				<li class ='des2'><div>Uploaded by:</div>".getusername($uploader)."</li>
				
				<li class ='des2'><div><i class='fa fa-thumbs-o-up' aria-hidden='true'></i>Rating:</div>".$rating."</li>
			</ul>";

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
					
						<form method="post" class="row" name="reply_submit" value="Reply" />
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
								if($pay == 0){ // free
										$money = "Full Version Download(FREE)";
									}else{ // purchase required
										$money = "Full Version Download(".$pay." HKD.)";
										
								}
								//echo $token;
								echo "<input type='submit' class='btn btn-sq-lg btn-success btn-lg btn-block' value='".$money."' name='full_submit'></input>";
								?>
						  </p>
						</div>
						</form>

					<?php
					//echo isset($_POST['full_submit']);
					if (isset($_POST['full_submit'])){
									if (!isset($_SESSION['uid'])) {
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
												echo "<script> window.location.href = window.location.href='source_database/".$file.".pdf' </script>";
												break;
											}
										}
											$sql_t = "SELECT token FROM user WHERE id = '".$_SESSION['uid']."' LIMIT 1";
											$res_t = mysqli_query($db, $sql_t) or die(mysqli_error($db));
											$row_t = mysqli_fetch_assoc($res_t);
											if(mysqli_num_rows($res_t) == 1){
												$token = $row_t['token'];
												
											}
											if ( $token - $pay < 0){
												//no token
												echo "<script>alert('You do not have enough token!');window.location.href='view.php?fid=" . $fid ."';</script>";
												exit();
											}else{
												//cut token
												if($pay != 0){
													$token -= $pay;
													$sql_u = "UPDATE user SET token = ".$token." WHERE id =".$_SESSION['uid']." ";
													//echo $token;
													mysqli_query($db,$sql_u);
													echo "<script>alert('Payment Success!')</script>";
													$sql_i = "INSERT INTO trade (uid, fid) VALUES (".$_SESSION['uid'].",".$fid.")";
													//echo "INSERT INTO trade (uid, fid) VALUES (".$_SESSION['uid'].",".$fid.")";
													mysqli_query($db,$sql_i);
													echo "
													<script> 
													download_file('source_database/".$file.".pdf' , '".$file.".pdf');
													</script>";
												}
											}

									}
										
									
								}
					?>
					
				
											   
              <div class="container">
                  <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-commenting"></i> Comment</b></font></p>
                  <?php
									//include("connect.php");
									if(isset($_SESSION['uid'])){
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
