<!--
/////////////////////////////////////////////////////////////
/* contact.php from CSCI3100 group 15
   03-05-2019

   Purpose:  Show contact formation of our team
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
    <title>Contact US - ARM!</title>

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
                       <font face="Economica, sans-serif" size="7"><b>Contact</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->

	<div class="container">
		<div class="row">
            <div class="col-sm-5 mx-auto">
                <img src="assets/images/map.jpg" alt="Logo" style="width:100%; margin-top: 20px">
            </div>
            
			<div class="col-sm-5 mx-auto" style="text-align: justify; margin-top: 20px">
                <font size="4"><p><span>Address: Ho Sin Hang Engineering Building University of Hong Kong Shatin, N.T. Hong Kong </span>
				<span>Office hour: 10:00 a.m.- 5:00 p.m.</span>
				<span>Email Address: cs@csci3100group15.com</span>
				<span>Phone Contact: 84423943 </span>
            </div>

        </div>
    </div>


<?php include('footer.php'); ?>

</body>


</html>