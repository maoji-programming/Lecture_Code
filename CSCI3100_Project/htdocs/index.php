<!--
/////////////////////////////////////////////////////////////
/* index.php from CSCI3100 group 15
   03-05-2019

   Purpose: Show posible links, such as hot question and latest quesition. Also, search bar are included in the page.
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
      A.csci3100:visited {color: #ffffff;}
      A.csci3100:active {color: rgb(255, 153, 0);}

      A.link-below:visited {color: #45877b;}
      A.link-below:active {color: rgb(255, 153, 0);}
      </style>
    </head>


    <body>

      <?php include('menu.php'); 
		include('search_header.php');
	  ?>


      


      <div class="container">
        <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-book"></i> Subject</b></font></p>

        <div class="row justify-content-center">
          <div class="col ">
            <div class="card shadow" >
              <div class= "inner">
                <img class="card-img-top" src="assets/images/book.jpg" alt="Card image cap">
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">Chinese</h5>
                <a href="cat_chinese.php" class="btn btn-outline-dark">Learn more...</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card shadow" >
              <div class= "inner">
                <img class="card-img-top" src="assets/images/book.jpg" alt="Card image cap">
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">English</h5>
                <a href="#" class="btn btn-outline-dark">Learn more...</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card shadow">
              <div class= "inner">
                <img class="card-img-top" src="assets/images/math.jpg" alt="Card image cap">
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">Mathematics</h5>
                <a href="#" class="btn btn-outline-dark">Learn more...</a>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card shadow">
              <div class= "inner">
                <img class="card-img-top" src="assets/images/book.jpg" alt="Card image cap">
              </div>
              <div class="card-body text-center">
                <h5 class="card-title">Mathematics</h5>
                <a href="#" class="btn btn-outline-dark">Learn more...</a>
              </div>
            </div>
          </div>
        </div>


      </div>

      <div class="container" style="margin-top:50px">
        <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i> Popular Source</b></font></p>

        <div class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row">
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="1 slide"></div>
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="2 slide"></div>
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="3 slide"></div>
              </div>
            </div>
            <div class="carousel-item">
              <div class="row">
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="4 slide"></div>
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="5 slide"></div>
                <div class="col-sm"><img class="d-block w-100" src="http://placehold.it/1200x600/ddd" alt="6 slide"></div>
              </div>
            </div>
          </div>
        </div>


      </div>



      <div class="jumbotron jumbotron-fluid jumbotron-custom-img2" style ="margin-top:50px">
        <div class="container ">
          <div class="text-center darken-grey-text mb-4">
            <p style="color: rgba(255,255,255,.9)">
              <font face="Economica, sans-serif" size="6"><b>Have trouble doing your Homework? Click to find the solution!!!</b></font>
            </p>
            <a class="btn btn-danger btn-md" href="question.php" >QUESTION <i class="fa fa-question-circle"></i></a>
          </div>
        </div>
      </div>
      <!--end of heading-->


      <div class="container" >
        <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i> What other people ask</b></font></p>
        <div class ='row'>
          <div class ='col'>
            <table width="100%" style="border-collapse: collapse;">
              <tr style='background-color: #b6ead4;'><td width='450'><font face="Georgia, sans-serif" size="5">Latest question</td><td><font face="Georgia, sans-serif" size="5">Category</td></tr>
              <?php
              include("connect.php");
              $sql = "SELECT * FROM questions ORDER BY post_date DESC, qid DESC"; // select the questions sorted by time, i.e. lateest questions
              $res = mysqli_query($db, $sql) or die(mysqli_error($db));
              $num = mysqli_num_rows($res);
              if ($num > 0) {
                for ($i = 0; $i < 5; $i++){  // allow maxiumum of 5 questions
                  $row = mysqli_fetch_assoc($res);
                  $qid = $row['qid'];
                  $title = $row['questions_title'];
                  $cid = $row['category_id'];
                  $sql_2 = "SELECT sub_title FROM sub_categories WHERE cid ='".$cid."'";
                  $res_2 = mysqli_query($db, $sql_2) or die(mysqli_error($db));
                  $category_name = mysqli_fetch_assoc($res_2)['sub_title'];
                  if($row['questions_close'] == 0){
                    $close = "<font color='#FF0000'>[Unsolved]</font>";
                  }else{
                    $close = "<font color='#999999'>[Solved]</font>";
                  }
                  $topic = "
                  <tr style='background-color: #fff9e5'>
                  <td>
                  <a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1' class='cat_links'><font size=4>".$close."".$title." </a></td>
                  <td><a href='question_category.php?cid=".$cid."&pages=1'><img class='d-block w-100' src='assets/images/question_sub_".$cid.".png'></a></td>
                  <tr>";
                  echo $topic;
                }



              } else {
                echo "<p>Constructing</p>";
              }
              ?>
            </table>
          </div>
          <div class = 'col'>
            <table width="100%" style="border-collapse: collapse;">
              <tr style='background-color: #b6ead4;'><td width='450'><font face="Georgia, sans-serif" size="5">Hot question</td><td><font face="Georgia, sans-serif" size="5">Category</td></tr>
              <?php
              $sql = "SELECT * FROM questions ORDER BY num_of_view DESC, qid DESC"; // select the questions sorted by number of view, i.e. hotest questions
              $res = mysqli_query($db, $sql) or die(mysqli_error($db));
              $num = mysqli_num_rows($res);
              if ($num > 0) {
                for ($i = 0; $i < 5; $i++){ // allow maxiumum of 5 questions
                  $row = mysqli_fetch_assoc($res);
                  $qid = $row['qid'];
                  $title = $row['questions_title'];
                  $cid = $row['category_id'];
                  $sql_2 = "SELECT sub_title FROM sub_categories WHERE cid ='".$cid."'";
                  $res_2 = mysqli_query($db, $sql_2) or die(mysqli_error($db));
                  $category_name = mysqli_fetch_assoc($res_2)['sub_title'];
                  if($row['questions_close'] == 0){
                    $close = "<font color='#FF0000'>[Unsolved]</font>";
                  }else{
                    $close = "<font color='#999999'>[Solved]</font>";
                  }
                  $topic = "
                  <tr  style='background-color: #fff9e5'>
                  <td><a href='view_question.php?cid=".$cid."&qid=".$qid."&pages=1' class='cat_links'><font size=4>".$close."".$title."</a></<td>
                  <td><a href='question_category.php?cid=".$cid."&pages=1'><img class='d-block w-100' src='assets/images/question_sub_".$cid.".png'></a></td>
                  <tr>";
                  echo $topic;
                }
             } else {
                echo "<p>Constructing</p>";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
      <?php include('footer.php'); ?>
    </body>
    </html>
