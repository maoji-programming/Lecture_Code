<!--
/////////////////////////////////////////////////////////////
/* ask_question.php from CSCI3100 group 15
   03-05-2019

   Purpose: Page for user to create question (post) 
            and info would be transfer to create_question.php for further process.
   
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
    </style>
</head>


<body>
<?php include('menu.php');  ?>    
	<?php 
	if ((!isset($_SESSION['uid']))) { // check whether user has login. If not, return to index page
	echo "<script>
	alert('Please Log in!');
	window.location.href='login.php';
	</script>";
	exit();
	}
	?>
    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
					<?php 
						include("connect.php"); // connect to database
						$cid = $_GET['cid']; // get a preasigned value according to the category selected
						$sql = "SELECT sub_title FROM sub_categories WHERE cid = '".$cid."' LIMIT 1";
						$res = mysqli_query($db, $sql) or die(mysqli_error($db));
						$row = mysqli_fetch_assoc($res);
						if(mysqli_num_rows($res) == 1){ // ensure num of record is not 0 or larger than 1
							$subject = $row['sub_title'];
							echo'<font face="Economica, sans-serif" size="6"><b>'.$subject.'</b></font>';
						}else{ // categorie not found
							echo "<script>
							window.location.href='404.php';
							</script>";
						}
					?>
                        
                    </p>
                    <a class="btn btn-danger btn-md" href="#" >ASK A QUESTION <i class="fa fa-question-circle"></i></a>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
            <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-question-circle"></i> Ask A Question!</b></font></p>
			<form action="create_question.php" method="post" enctype="multipart/form-data">
			<p>Topic:</p>
			<input type="text" name="topic_title" size="98" maxlength="150" />
			<p>Content:</p>
			<textarea name="topic_content" rows="5" cols="75"></textarea>
			<input type="hidden" name="cid" value="<?php echo $cid; ?>" /><br/><br/>
			<input type="submit" name="topic_submit" value="Submit" />
			</form>


    </div>

<?php include('footer.php'); ?>

</body>
</html>