<!--
/////////////////////////////////////////////////////////////
/* menu.php from CSCI3100 group 15
   03-05-2019

   Purpose: Provide navigation bar to all pages

   Module used by most page.
   Included by most page.
*/
////////////////////////////////////////////////////////////
!-->
<?php session_start(); ?>    
<nav class="navbar navbar-expand-sm navbar-custom shadow">
        <a href="index.php" class="navbar-brand">
            <img src="assets/images/logo.png" alt="Logo" style="width:76px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCustom">
            <i class="fa fa-bars"></i>
        </button>
        <div class="navbar-collapse collapse" id="navbarCustom">
            <ul class="navbar-nav ml-auto">
                <li><a class="nav-link" href="search.php"><i class="fa fa-search"></i> Resources</a></li>
                <li><a class="nav-link" href="question.php"><i class="fa fa-comment"></i> Question</a></li>
				<?php header("Content-Type:text/html; charset=utf-8");
					if (!isset($_SESSION['uid'])) { //check whether user has logged in
						echo '
						<li><a class="nav-link" href="login.php"><i class="fa fa-sign-in"></i> Log In</a></li>
						<li><a class="nav-link" href="register.php"><i class="fa fa-user"></i> Sign Up</a></li>
						';
					} else { // case of has logged in
                         echo '
                        <li class="nav-item dropdown">
                        <div class="nav-link">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> '.$_SESSION['username'].'
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item"  href="view_my_profile.php"> <i class="fa fa-id-badge"></i> View My Profile</a>
                            <a class="dropdown-item"  href="mail.php"> <i class="fa fa-envelope"></i> Mailbox</a>
                            </div>
                        </div>
                        </li>
                        <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-in"></i> Log Out</a></li>';
					}
				?>
            </ul>
        </div>
    </nav>