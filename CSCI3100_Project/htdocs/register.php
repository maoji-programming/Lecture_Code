<!--
/////////////////////////////////////////////////////////////
/* register.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allow user to register on the system.
   
*/
////////////////////////////////////////////////////////////
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Account - ARM!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<style>

* {
  box-sizing: border-box;
}

/* Add padding to containers */
.container {
  padding: 16px;
  background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}
.select{
  /* font-size: 20px;
  border-style: dotted ;
  border-width: 10px 105px 0;
  top: 50%;
  right: 11px; */
   -webkit-appearance: button;
   -webkit-border-radius: 2px;
   -webkit-box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.1);
   -webkit-padding-end: 20px;
   -webkit-padding-start: 2px;
   -webkit-user-select: none;
   background-image: url(http://i62.tinypic.com/15xvbd5.png), -webkit-linear-gradient(#FAFAFA, #F4F4F4 40%, #E5E5E5);
   background-position: 97% center;
   background-repeat: no-repeat;
   border: 1px solid #AAA;
   color: #555;
   font-size: inherit;
   margin: 10px;
   overflow: hidden;
   padding: 5px 10px;
   text-overflow: ellipsis;
   white-space: nowrap;
   width: 390px;
}
/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
  background-color: #3EA08A;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>


</head>
<body>
<?php include('menu.php');  ?>

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-sm-5 mx-auto" >
            <div class="col  d-none d-lg-block">
				<h2>Welcome back!</h2>
				<div class="card card-body ">
					<p class="lead">Register now for <span class="text-success">FREE</span></p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> Get the latest resources</li>
                          <li><span class="fa fa-check text-success"></span> Ask question about your academic</li>
                          <li><span class="fa fa-check text-success"></span> Share your paper</li>
                      </ul>
				</div>
			</div>


            </div>
            <div class="col-sm-5 mx-auto">
				<div class="card card-body ">
					<h1>Sign Up</h1>
					<label> Join ARM with over 10000 students !</label>
					<form  method='post' name = "att">
					  <div class="container">
						<p>Create a free account and start now.</p>
						<label ><b>I am current a </b></label><br>


						<input type="radio" name="identity" id="Student" value="student" checked= "checked">
						<label for="student">Student</label>
						<input type="radio" name="identity" id="Publisher" value="Publisher" >
						<label for="Publisher">Publisher</label>
						<br><br>
              
            <script type="text/javascript"> $(document).on("change","input[type=radio]",function(){ // action on change of radio button
               var oform = document.forms["att"]; 
               if(document.getElementById('schoolList').style.display =='none'){
                  document.getElementById('schoolList').style.display = 'inline';
                  oform.elements.school.required = true;
                  
               }else{
                  document.getElementById('schoolList').style.display = 'none';
                  oform.elements.school.value = "";
                  oform.elements.school.required = false;

               }
               if(document.getElementById('publisherList').style.display =='inline'){
                  document.getElementById('publisherList').style.display = 'none';
                  oform.elements.contact.required = false;
               }else{
                  document.getElementById('publisherList').style.display = 'inline';
                  oform.elements.contact.required = true;
                  oform.elements.contact.value = "";
               }
            });
            </script>
						<label for="email"><b>Email Address *</b></label><!--Using regex to check format-->
						<input type="text" placeholder="Please enter your Email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" name="email" required> 

						<label for="username"><b>Username *</b></label>
						<input type="text" placeholder="Please enter your username" pattern=".{4,255}" title="At least 4 character" name="username" required>

						<label for="psw"><b>Password *</b></label>
						<input type="password" placeholder="Please enter your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,255}" 
              title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="psw" required>

						<label for="confirm"><b>Confirm Password *</b></label>
						<input type="password" placeholder="Confirm your Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,255}" 
              title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" name="confirm" required>

            <div id = "schoolList">
						  <label for="schoolL"><b>Choose your school *</b></label><br>
              <input type="text" placeholder="Please enter your school's name" pattern=".{10,255}" title="Please fill the fullname of School " name="school" required>
            </div>

            <div id = "publisherList" style="display:none">
						  <label for="publisherL"><b>Contact info *</b></label><br>
              <input type="text" placeholder="Please enter your contact info" pattern= "\d{3}[-]\d{8}" title="Fill in xxx-xxxxxxxx " name="contact">
            </div>

						<p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

						<button type="submit" class="registerbtn" name="register_btn">Register</button>
					  </div>

					  <div class="container signin">
						<p>Already have an account? <a href="login.html">Sign in</a>.</p>
					  </div>
					</form>

				</div>
			</div>	
        </div>
    </div>

<?php include('footer.php'); ?>
<?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = mysqli_connect("localhost", "root", "", "arm");
        if (isset($_POST['register_btn'])){ // button clicked
          $username = ($_POST['username']);
          $email = ($_POST['email']);
          $psw = ($_POST['psw']);
          $confirm = ($_POST['confirm']);
          $check_duplicate_username = "SELECT * FROM user WHERE username = '$username'";
          $result_username = mysqli_query($db, $check_duplicate_username);
          $check_duplicate_email = "SELECT * FROM user WHERE email = '$email'";
          $result_email = mysqli_query($db, $check_duplicate_email);
   
          if (mysqli_num_rows($result_username) > 0 && mysqli_num_rows($result_email) > 0) { // case of already exist username + email
            echo '<script type="text/javascript">alert("Already have account with this username and email.");  </script>';
          }
          elseif(mysqli_num_rows($result_username) > 0){ // case of already exist username
            echo '<script type="text/javascript">alert("Already have account with this username.");  </script>';
          }
          elseif (mysqli_num_rows($result_email) > 0) { // case of already exist email
            echo '<script type="text/javascript">alert("Already have account with this email.");  </script>';
          }
          else // case of no eamil and username exist before
          {
            if($psw === $confirm){ // twice input matched
              //create user
              $psw = ($_POST['psw']);
              $confirm = ($_POST['confirm']);
              $identity = ($_POST['identity']);
             
              if(!empty($_POST['school'])){
                $school = ($_POST['school']);
                $contactInfo = "NULL";
              }else{
                $school = "NULL";
                $contactInfo = ($_POST['contact']);
              }
                $sql = "INSERT INTO user(username, password, email, identity, school,contactInfo) VALUES ( '$username', '$psw', '$email','$identity', '$school', '$contactInfo')";
                mysqli_query($db,$sql);
                $sql = "SELECT id FROM user WHERE username = '$username' LIMIT 1";
                $res = mysqli_query($db, $sql) or die(mysqli_error($db));
                $row = mysqli_fetch_assoc($res);
                $id = $row['id'];
                $sql_insert ="INSERT INTO mail_group (user1 , user2) VALUES ('0','".$id."')";
                //echo $sql_insert;
                mysqli_query($db, $sql_insert);
                echo '<script type="text/javascript">alert("Welcome " + "'.$username.'" + "\nYour may now login");
                window.location.href="login.php";
                </script>';

            }else{ // twice input not matched
              echo '<script type="text/javascript">alert("Password not matched");
                </script>';
            }
          }
        }
      }
      
?>
</body>
</html>
