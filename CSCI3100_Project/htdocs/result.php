<!--
/////////////////////////////////////////////////////////////
/* result.php from CSCI3100 group 15
   03-05-2019

   Purpose: Showing result of seraching a keyword
   
*/
////////////////////////////////////////////////////////////
-->
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


	.cardc {
	  position: relative;
	}
	.cardc:hover {
	  position: relative;
	  top: 0;
	  left: 10px;
	  content: "\f005";
	}

      </style>
    </head>


    <body>

      <?php include('menu.php');     include('search_header.php'); ?>

<div class = "container">
      <?php
      $srch = $_GET['search_content'];
      $category = $_GET['category'];
		  $len = strlen($srch);

          echo "You searched for <i>$srch</i> <hr size='1'></br>";

          include("connect.php");
          $srch_exploded = explode (" ", $srch); //split the whole sentence into words
          $x = 0;
          $construct = "";
              foreach($srch_exploded as $srch_each) // for each word
              {

                  $x++;

                  if($x==1)
                  {
                    $construct .="tag LIKE '%$srch_each%'"; // first word
                  }
                  else
                  {
                    $construct .="AND tag LIKE '%$srch_each%'"; // words after
                  }

              }

              $sql ="SELECT * FROM resource WHERE $construct AND type= '".$category."'";
              if($category == "All"){
                $sql ="SELECT * FROM resource WHERE $construct";
              }
              $res = mysqli_query($db,$sql);
              $num = mysqli_num_rows($res);

              if ($num==0){
              echo "Sorry, there are no matching result for <b>$srch</b>.</br></br>";
              }else{
                  echo "".$num." results found !<p>";
                  $count = -1;
                  $numOfRow = 0;
                        while($row = mysqli_fetch_assoc($res))
                        {
                          $count ++;
                          $fid = $row ['fid'];
                          $title = $row ['name'];
                          $type = $row['type'];
                          $rating = $row['rating'];
                          $cardType = "";
                          switch ($type){ // give different color according to the type 
                            case "notes":
                              $cardType = '<div class="card border-primary mb-3" style="max-width: 18rem;">';
                              break;
                            case "exercise":
                              $cardType = '<div class="card border-secondary mb-3" style="max-width: 18rem;">';
                              break;
                            case "pastpaper":
                              $cardType = '<div class="card border-success mb-3" style="max-width: 18rem;">';
                              break;
                            case "textbook":
                              $cardType = '<div class="card border-danger mb-3" style="max-width: 18rem;">';
                              break;
                            case "Reading":
                              $cardType = '<div class="card border-info mb-3" style="max-width: 18rem;">';
                              break;
                            default:
                              $cardType = '<div class="card border-warning mb-3" style="max-width: 18rem;">';
                              break;
                          }
                    if($count%4 ==0){ // four card in a row
                      echo '<div class="row justify-content-center">';
                      $numOfRow ++;
                    }
                        echo '<div class ="col">
                        '.$cardType.'
                          <div class="card-header">'.ucfirst($type).'</div>
                          <div class="card-body text-primary">
                          <h5 class="card-title"><a href = "view.php?fid='.$fid.'">'.$title.'</a></h5>
                          <p class="card-pf-aggregate-status-notifications">
                            <span class="card-pf-aggregate-status-notification" style = "text-align:right"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> '.$rating.'</span>
                          </p>
                          </div>
                        </div>
                      </div>';
                      
                    if($count%4 == 0 && $count !=0){ // closing <div class ="row">
                      echo '</div>';
                      $numOfRow--;
                    }
                  }
            if($numOfRow != 0){
              echo '</div>';
            }
          }

	  ?>
</div>

<?php include('footer.php'); ?>

</body>
</html>
