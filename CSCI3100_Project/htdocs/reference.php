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
                        <font face="Economica, sans-serif" size="6"><b>Reference</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
    <a href="https://getbootstrap.com/"> Bootstrap 4 </a><br>
    <a href="https://www.w3schools.com/w3css/"> W3School </a><br>
    <a href="https://tcpdf.org/"> TCPDF </a><br>
    <a href="https://jquery.com/"> jQuery </a><br>
    <a href="https://github.com/Oberto/php-image-magician"> PHP image magician </a><br>
    <a href="https://www.youtube.com/playlist?list=PLEEE2B57BAE393EF5"> Basic Forum Tutorial </a><br>
    <a href="https://bootsnipp.com/snippets/PjQN9"> Search bar Tutorial </a><br>
    <a href="https://mdbootstrap.com/docs/jquery/navigation/footer/"> Footer Tutorial </a><br>
    </div>

<?php include('footer.php'); ?>
</body>
</html>