<!--
/////////////////////////////////////////////////////////////
/* upload_file.php from CSCI3100 group 15
   03-05-2019

   Purpose: Page for user to upload his/her academic resource.
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
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>
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
                        <font face="Economica, sans-serif" size="6"><b>Upload and Get some tokens!!</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->


        <div class="container" >
            <p class="color-header"><font face="Economica, sans-serif" size="6"><b><i class="fa fa-search"></i> I want to upload files</b></font></p>
            <?php
            if (!isset($_SESSION['uid'])){ // check whether user has login. If not, return to index page
                header("Location: index.php");
                exit();
            }
            
            ?>
            <form class="col-sm-6 mx-auto" id = "upload"  method = "POST" enctype = "multipart/form-data">
                <b>Select file to upload:</b>
                <br>
                    <input class="btn btn-default" type="file" value="Select" name="my_file" id="fileToUpload">
                <br>
                <label for="name"><b>File name:</b></label>
                <input type="text" class="form-control" name="name" required>
                <br>
				<div class="form-group">
				  <label for="stype"><b>Type of Material:</b></label>
				  <select class="form-control" id="stype" name='type'>
					<option value="exercise">Exercise</option>
					<option value="exam paper">Exam Paper</option>
					<option value="notes">Notes</option>
					<option value="reading">Reading</option>
					<option value="textbook">Textbook</option>
				  </select>
				</div>
                <br>
                <label for="name"><b>Token:</b></label>
                <input type="text" class="form-control" name="token" required>
                <br>Add some tags to increse the view!
				<div class="form-group">
					 <label for="stype"><b>Add Tags:</b></label>
					<input type="text" name="tags" id="tags" class="form-control" />
				</div>
				<br>
                <input class="btn btn-default" type="submit" value="submit" name="submit">
            </form>
			
<script>
$(document).ready(function(){
 
 $('#tags').tokenfield({
  autocomplete:{
   source: ['PHP','Codeigniter','HTML','JQuery','Javascript','CSS','Laravel','CakePHP','Symfony','Yii 2','Phalcon','Zend','Slim','FuelPHP','PHPixie','Mysql'],
   delay:100
  },
  showAutocompleteOnFocus: true
 });

 $('#upload').on('submit', function(event){
  event.preventDefault();
   var form_data = $(this).serialize();
   $('#submit').attr("disabled","disabled");
   $.ajax({
    url:"insert.php",
    method:"POST",
    data:form_data,
    beforeSend:function(){
     $('#submit').val('Submitting...');
    },
    success:function(data){
     if(data != '')
     {
      $('#tags').tokenfield('setTokens',[]);
      $('#success_message').html(data);
      $('#submit').attr("disabled", false);
      $('#submit').val('Submit');
     }
    }
   });
   setInterval(function(){
    $('#success_message').html('');
   }, 5000);

 });
 
});
</script>
			
			<?php
			if (isset($_POST['submit'])) { // if submit button is clicked
				if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK){
                    $displayname = $_POST['name'];
                    $name = ''.$_SESSION['uid'].'_'.$_POST['name'].'';
                    $file = $_FILES['my_file']['tmp_name'];
                    $type = $_POST['type'];
                    $dest = 'source_database/'.$name.'.pdf';
                    $tags = $_POST['tags'];
                    $tags  = json_encode($tags); 
                    $tags  = htmlspecialchars_decode($tags);	
                    $token = $_POST['token'];
                    
                    move_uploaded_file($file, $dest); 
                    include('previewGenerator.php');
                    //echo 'ERROR:' . $_FILES['my_file']['error'] . '<br/>';
                    
                    include_once("connect.php");
                    $uploader = $_SESSION['uid'];
                    $sql = "INSERT INTO resource (uid,name, file_url, rating,type, pages, tag, price) VALUES ('" . $uploader . "', '" . $displayname . "', '" . $name . "', '5','".$type."','" . $pdf->numPages . "','" . $tags . "','" . $token . "')";
                    $res = mysqli_query($db, $sql) or die(mysqli_error($db));
                    $fid = mysqli_insert_id ($db);

                    $sql_t = "SELECT token FROM user WHERE id = '".$_SESSION['uid']."' LIMIT 1";
                    $res_t = mysqli_query($db, $sql_t) or die(mysqli_error($db));
                    $row_t = mysqli_fetch_assoc($res_t);
                    if(mysqli_num_rows($res_t) == 1){ //case of fetching success
                        $token = $row_t['token'];
                        
                    }
                    $token += 5;
                    $sql_u = "UPDATE user SET token = ".$token." WHERE id =".$_SESSION['uid']." ";
                    //echo $token;
                    mysqli_query($db,$sql_u);
                    if (($res)) {// do action according to the resutl of sql query
                        echo "<script>
                            alert('Uploaded successful');
                            window.location.href='view.php?fid=" . $fid ."';
                            </script>";
                    } else {
                        echo "<script>
                            alert('An Error Was Encoountered. Please try it later.');
                            window.location.href='upload_file.php';
                            </script>";
                    }
				
				}
			}
			?>		
            
    </div>
    

<?php include('footer.php'); ?>
</body>
</html>