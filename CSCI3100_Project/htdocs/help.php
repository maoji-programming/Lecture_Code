<!--
/////////////////////////////////////////////////////////////
/* help.php from CSCI3100 group 15
   03-05-2019

   Purpose: Show info of our team
*/
////////////////////////////////////////////////////////////
!-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Help - ARM!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Economica" rel="stylesheet">

    <style>
        .jumbotron-custom-img {
            background: linear-gradient( rgba(52, 180, 160, 0.3), rgba(0, 0, 0, 0.5) ), url("assets/images/book.jpg");
            background-size: cover;
        }

        A.csci3100:visited {
            color: #ffffff;
        }

        A.csci3100:active {
            color: rgb(255, 153, 0);
        }
    </style>

</head>
<body>
<?php include('menu.php');  ?>


    <div class="jumbotron jumbotron-fluid jumbotron-custom-img">
        <div class="container ">
            <div class="text-center darken-grey-text mb-4">
                <p style="color: rgba(255,255,255,.9)">
                    <font face="Economica, sans-serif" size="7"><b>Help</b></font>
                </p>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-sm-5 mx-auto">
                <img src="assets/images/help.jpg" alt="Logo" style="width:100%; margin-top: 20px">
            </div>
            <div class="col-sm-5 mx-auto" style="text-align: justify; margin-top: 20px">

                <p><font size="2">We are the CSCI3100 project team 15. This is an online learning platform. You can find those learning materials, exercise or exam paper.</font></p>
                <font size="2"><p><span>Our group member:</span><span>Wong Sin Yi(1155110677)</span><span>Cheung Kam Ho(1155092634) </span><span>Cheung Chi Hang Calvin(1155110302) </span><span>Cheung Tsz Ho(1155102444) </span><span>Yuen Ching Yin(1155110657) </span></p></font>

            </div>

        </div>
    </div>



<?php include('footer.php'); ?>
</body>
</html>
