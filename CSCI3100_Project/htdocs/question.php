<!--
/////////////////////////////////////////////////////////////
/* question.php from CSCI3100 group 15
   03-05-2019

   Purpose: Entry page of question component. Allows user select a subject for looking questions in that subject.

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
    </style>
</head>


<body>
<?php include('menu.php');  ?>

    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
                        <font face="Economica, sans-serif" size="6"><b>Find a solution or Ask a question HERE!!!</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->


    <div class="container" >
            <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-book"></i> Subject</b></font></p>
            <?php
				include("connect.php");
				$sql = "SELECT * FROM sub_categories ORDER BY cid ASC"; // select all exisiting subject
				$res = mysqli_query($db, $sql) or die(mysqli_error($db));
				$sub_categories = "";
				if (mysqli_num_rows($res) > 0) { // if there is at least one record

                    echo '<table width="100%" style="border-collapse: collapse;">';
					echo "<tr style='background-color: #b6ead4;'><td width='240'>Subject</td><td>Description</td><td width='250'>Latest post</td></tr>";
                    #[graph| description              |latest]
					while ($row = mysqli_fetch_assoc($res)) { // fetch all record until all subject has been rendered
						$cid = $row['cid'];
						$title = $row['sub_title'];
						$sub_categories = "<a href='question_category.php?cid=".$cid."&pages=1' class='navbar-brand'><img class='d-block w-100' src='assets/images/question_sub_".$cid.".png'></a>";
                        echo "<tr><td style='background-color: #fff9e5'>";
                        echo $sub_categories;
                        echo "</td>";
                        echo "<td style='background-color: #fff9e5'><a href='question_category.php?cid=".$cid."&pages=1' class='cat_links'><b>$title</b></a><br>Discussion related to ".$title;
                        echo "</td>";
                        # title
                        #	http://localhost/csci3100/view_question.php?cid=1&qid=26&pages=1
                        $sql_1 = "SELECT * FROM questions WHERE category_id='".$cid."' ORDER BY post_date DESC, qid DESC LIMIT 1";
                        $res_1 = mysqli_query($db, $sql_1) or die(mysqli_error($db));
                        $row_1 = mysqli_fetch_assoc($res_1);
                        $title = $row_1['questions_title'];
                        $user_id = $row_1['questions_creator'];
                        $qid_1 = $row_1['qid'];
                        $post_date_1 = $row_1['post_date'];

                        # user
                        $sql_2 = "SELECT * FROM user WHERE id='".$user_id."' LIMIT 1";
				        $res_2 = mysqli_query($db, $sql_2) or die(mysqli_error($db));
                        $row_2 = mysqli_fetch_assoc($res_2);
                        echo "<td style='background-color: #fff9e5'>";
                        $creator = $row_2['username'];
                        if ($title == ""){
                            echo "no post here";
                        }else{
                            echo "<a href='view_question.php?cid=".$cid."&qid=".$qid_1."&pages=1' class='cat_links'>" .$title."</a><br>".$post_date_1. " by ".$creator;
                        }
                        echo "</td></tr>";
                    }
                    echo "</table>";

				} else {
					echo "<p>Constructing</p>";
				}
			?>

    </div>

<?php include('footer.php'); ?>

</body>
</html>
