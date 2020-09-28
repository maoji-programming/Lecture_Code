<!--
/////////////////////////////////////////////////////////////
/* 404.php from CSCI3100 group 15
   03-05-2019

   Purpose: Indicate user enter wrong url that it does not exist.
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
		</style>

</head>


<body>

</body>
<?php include('menu.php');  ?>
    <div class="jumbotron jumbotron-fluid jumbotron-custom-img">
        <div class="container ">
            <div class="text-center darken-grey-text mb-4">
                <p style="color: rgba(255,255,255,.9)">
                    <img src="assets/images/404.png" alt="Logo" style="width:100%; margin-top: 20px">
                </p>              
            </div>
        </div>
    </div>


<?php include('footer.php'); ?>
</html>