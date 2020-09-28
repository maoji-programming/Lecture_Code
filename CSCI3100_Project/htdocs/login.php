<!--
/////////////////////////////////////////////////////////////
/* login.php from CSCI3100 group 15
   03-05-2019

   Purpose: Allows user to login in the system. Users are required to input in certain format.
	Once the inputs are submitted, checking would be done on server-side.
*/
////////////////////////////////////////////////////////////
!-->
<!DOCTYPE html>
<html>
<head>
    <title>Log In - ARM!</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Economica" rel="stylesheet">
	<style>
	.btn-fa {
		padding:8px;
		background:#ffffff;
		margin-right:4px;
	}
	.icon-btn {
		padding: 1px 15px 3px 2px;
		border-radius:50px;
	}
	</style>
</head>
<body>

<?php include('menu.php');  ?>

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col  d-none d-lg-block">
				<h2>Welcome back!</h2>
				<div class="card card-body ">
					<p class="lead">Register now for <span class="text-success">FREE</span></p>
                      <ul class="list-unstyled" style="line-height: 2">
                          <li><span class="fa fa-check text-success"></span> Get the latest resources</li>
                          <li><span class="fa fa-check text-success"></span> Ask question about your academic</li>
                          <li><span class="fa fa-check text-success"></span> Share your paper</li>
                      </ul>
                      <p><a class="btn icon-btn btn-danger" href="register.php">
						<span class="fa fa-registered btn-fa rounded-circle text-danger"></span>
						Register Now!
						</a></p>
				</div>
			</div>
            <div class="col">
			<div class="card card-body ">
                <h1>User Log In</h1>
					<form method='post'>
						<div class="form-group">
							<label>USERNAME</label>
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-user-o" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="username" value="" pattern=".{4,255}" title="At least 4 character" required>
							</div>							
						</div>
						<div class="form-group">
							<label>PASSWORD</label>
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
								<input type="password" class="form-control" name="password" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,255}" 
             					 title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
							</div>
						</div>
						
						<button type="submit" class="btn btn-primary">Submit</button>	<a href= 'forgot_password.php' class="btn btn-primary">Forget Password</a>
					</form>
			</div>
            </div>


        </div>
    </div>
	
	
	
<?php include('footer.php'); ?>
	
<?php 
include_once("connect.php");
if (isset($_POST['username'])) { //check whether there are messages being submitted.
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM user WHERE username='".$username."' AND password='".$password."' LIMIT 1";
	$res = mysqli_query($db, $sql) or die(mysqli_error($db));
	if (mysqli_num_rows($res) == 1) { //case of only one record return 
		$row = mysqli_fetch_assoc($res);
		$_SESSION['uid'] = $row['id'];
		$_SESSION['username'] = $row['username'];
		echo "<script>
		alert('You have been successfully logged in!');
		window.location.href='index.php';
		</script>";
	}else{// no record or more than one record return 
		echo "<script>
		alert('You have entered an invalid username or password');
		window.location.href='login.php';
		</script>";
	}
}
?>

</body>
</html>
