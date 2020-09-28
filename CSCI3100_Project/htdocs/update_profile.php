<!--
/////////////////////////////////////////////////////////////
/* update_profile.php from CSCI3100 group 15
   03-05-2019

   Purpose: Page for user to update his/her profile, like icon,email, personal description
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>My profile - ARM!</title>

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
	header("Location: index.php");
	exit();
}
?>  

    <div class="jumbotron jumbotron-fluid jumbotron-custom-img2">
            <div class="container ">
                    <div class="text-center darken-grey-text mb-4">
                    <p style="color: rgba(255,255,255,.9)">
                        <font face="Economica, sans-serif" size="6"><b>Changing My Profile</b></font>
                    </p>
                    </div>
            </div>
        </div>
        <!--end of heading-->
     <?php
       

      
    ?>
    <form  method='post'>
        <div class="container" >
                    <?php header("Content-Type:text/html; charset=utf-8"); error_reporting(0);
                        $item = $_GET['ch'];
                        $id = $_SESSION['uid'];
                        include_once("connect.php");
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //case of button is clicked
                            switch($item){
                                case "icon":
                                $tempStr = explode(".", $_FILES["fileToUpload"]["name"]);
                                $extension = end($tempStr);
                                if ((($_FILES["fileToUpload"]["type"] == "image/jpeg") || ($_FILES["fileToUpload"]["type"] == "image/jpg") || ($_FILES["fileToUpload"]["type"] == "image/png"))
                                && ($_FILES["fileToUpload"]["size"] < 30000000) ){ // only accept types :jpeg,jpg,png and size dones not exceed 30000000
                                  if ($_FILES["fileToUpload"]["error"] > 0){ // case of error occur
                                    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
                                    }else {
                                      $newfilename = $id."_icon".'.'.$extension;
                                      move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "./assets/icon/" . $newfilename); 
                                      require_once('./assets/php_image_magician.php'); // import external library
                                            $magicianObj = new imageLib('./assets/icon/'.$newfilename.'');
                                            $magicianObj -> resizeImage(250, 250, 'auto');  // reseize image to 250*250
                                            $magicianObj -> saveImage('./assets/icon/'.$newfilename.'', 100);
                                            $sql = "UPDATE user SET iconPath = '". $newfilename."'  WHERE id='".$id."' LIMIT 1";     
                                    }
                                }else{ // case of size exceed or format not matched
                                    echo "<script>
                                    alert('Sorry, only JPG, JPEG, PNG files are allowed. And file size cannot exceed 30000000B');
                                    window.location.href='update_profile.php?ch=icon';
                                    </script>";	
                                }
                                    break;
                                case "email":
                                    $sql = "UPDATE user SET email = '$_POST[email]' WHERE id='".$id."' LIMIT 1";
                                    break;  
                                case "pInfo":
                                    $sql = "UPDATE user SET personalInfo = '$_POST[personalInfo]' WHERE id='".$id."' LIMIT 1";
                                    break;
                
                                default:
                                    header("Location: view_my_profile.php");
                                    exit();
                                    break;
                            }
                                //echo $sql;
                               
                                $UpdateStatus = mysqli_query($db, $sql) or die(mysqli_error($db));

                        }

                        $text ="";
                        $formText ="";
                        $sql = "SELECT * FROM user WHERE id='".$id."' LIMIT 1";
                        $res = mysqli_query($db, $sql) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_assoc($res)) { // fetching all record
                            if (mysqli_num_rows($res) == 1) { // case of only one record
                                switch($item){
                                    case "icon":
                                        $text = "Icon";
                                        $formText = "</form><img src='assets/icon/$row[iconPath]' class='rounded mx-auto d-block' width ='200' height = '200' alt='your icon'>
                                                        <form method='post' enctype='multipart/form-data'>
                                                                <input type='file' name='fileToUpload' id='fileToUpload' accept='/image/png, image/jpeg, image/jpg'>
                                                                <div class='input-group-append'>
                                                                <button type='submit' name='submit_btn'><i class='material-icons'>publish</i></button>
                                                        </form>";
                                        break;

                                    case "email":
                                        
                                        $text = "Email Address";
                                        $formText = "<div class='input-group mb-3'>
                                                        <div class='input-group-prepend'>
                                                                <span class='input-group-text' id='basic-addon2'><i class='material-icons'>email</i></span>
                                                        </div>
                                                        <input type='email' name = 'email' class='form-control' value='$row[email]'  aria-label='Email Address' aria-describedby='basic-addon2'>
                                                        <div class='input-group-append'>
                                                        <button type='submit' name='submit_btn'><i class='material-icons'>done</i></button>                                     
                                                        </div>
                                                    </div>";
                                        break;
                                     
                                    
                                    case "pInfo":
                                        $text = "Personal Information";
                                        $formText = "<div class='input-group '>
                                                        <div class='input-group-prepend'>
                                                                <span class='input-group-text' id='basic-addon3'><i class='material-icons'>message</i></span>
                                                        </div>
                                                        <textarea class='form-control' name = 'personalInfo' aria-label='Personal Information' aria-describedby='basic-addon3'>$row[personalInfo]</textarea>    
                                                        <div class='input-group-append'>
                                                        <button type='submit' name='submit_btn'><i class='material-icons'>done</i></button>                                     
                                                        </div>
                                                    </div>";   
                                        break;

                                    default:
                                        header("Location: index.php");
                                        exit();
                                        break;
                                }
                            }
                        }
                        echo "<p class='color-header'><font face='Economica, sans-serif' size='6'><b><i class='fa fa-id-badge'></i> Changing $text</b></font></p>";

                        echo"<div class='card border-dark mb-3'>
                                <div class='card-body'>";
                                echo"$formText";
                        echo"   </div>
                            </div>";
                                    
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // after action is done, redirect user to view_my_profile
                            echo '<script type="text/javascript">alert("Value has been Change\n Your are now directed to view_my_profile page");
                                    window.location.href="view_my_profile.php"
                                  </script>';//
                        }
                    ?>
        </div>
    </form>

                        
  

<?php include('footer.php'); ?>
</body>
</html>