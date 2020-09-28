<!--
/////////////////////////////////////////////////////////////
/* search.php from CSCI3100 group 15
   03-05-2019

   Purpose: Page for fast searching according to subject
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
    <title>Search - ARM!</title>

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
    </style>
</head>
	<body>
<?php include('menu.php');  ?>



		<?php
    include('search_header.php');

		if (isset($_SESSION['uid'])) { // check whether user has login. If yes show link for uploading resource.
			echo "<div class='container'>";
			echo "<p class='color-header'><font face='Economica, sans-serif' size='6'><b><i class='fa fa-folder-open'></i> I want to upload files</b></font></p>";
			echo "<a target ='_blank' href='upload_file.php'><button type='button' class='btn btn-primary btn-lg btn-block'>Upload!</button></a>";
			echo "</div>";
		}

		?>

	<div class="container"> <!--Big icon for fast seaching-->
			<p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i> Choose a subject</b></font></p>
			<div class ="gallery">
				<a  href="result.php?search_content=Chinese&category=All">
				<img src="assets/images/Chinese2.png" alt="中國語文" width="100%" height="100%">
				</a>
			</div>
			<br>
			<div class ="gallery">
			<a  href="result.php?search_content=English&category=All">
				<img src="assets/images/English.png" alt="English" width="100%" height="100%">
				</a>
			</div>
			<br>
			<div class ="gallery">
			<a  href="result.php?search_content=Math&category=All">
				<img src="assets/images/Math.png" alt="Mathematics(Core)" width="100%" height="100%">
				</a>
			</div>
			<br>
			<div class ="gallery">
					<a target ="_blank" href="#!">
					<img src="assets/images/LBS.png" alt="Liberal Studies" width="100%" height="100%">
					</a>
			</div>
			<br>
			<div class ="gallery">
					<a target ="_blank" href="#!">
					<img src="assets/images/Chem.png" alt="Chemistry" width="100%" height="100%">
					</a>
			</div>
			<br>
			<div class ="gallery">
					<a target ="_blank" href="#!">
					<img src="assets/images/phy.png" alt="Physics" width="100%" height="100%">
					</a>
			</div>
	</div>

<?php include('footer.php'); ?>

	</body>
</html>
