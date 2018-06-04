
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="icon" href="<?php echo base_url()?>img/logo.png">
        <title>GeoTag</title>

        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="css/mystyle.css" />
        <script src="<?php echo base_url(); ?>js/myjs.js"></script>
    </head>

    <body>

        <div class="header" style="background-image: url('<?php echo base_url(); ?>img/header.jpg'); height:100px; margin:10px; margin-bottom:20px; border-radius: 3px">

        </div>
        
        <span>
            <?php if (isset($message) && ($message == "Confirmation mail has been sent.")) 
                echo "<div class=\"alert alert-info \" style=\" margin-left:15px; margin-right:15px;\">
                        <strong>Check mail! </strong> ".$message."
                      </div>"
            ?>
        </span>
        <span>
            <?php if (isset($message) && ($message == "Your registration has been confirmed! You can login now!")) 
                echo "<div class=\"alert alert-success \" style=\" margin-left:15px; margin-right:15px;\">
                        <strong>Success!</strong> ".$message."
                      </div>"
            ?>
        </span>
        <span>
            <?php if (isset($message) && ($message == "Your registration has expired!")) 
                echo "<div class=\"alert alert-danger \" style=\" margin-left:15px; margin-right:15px;\">
                        <strong>Error!</strong> ".$message."
                      </div>"
            ?>
        </span>
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron"  style="height:800px;padding:0px;border-radius:3px; background-size:cover; background-image: url('<?php echo base_url(); ?>img/welcome-back1.png');">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4" align="center">
                                    <img src="<?php echo base_url(); ?>img/logo.png" width="270px" style="margin-top:30px;margin-bottom:20px">
                                    <br>
                                    <form action="<?php echo base_url() ?>index.php/guest/login" method="POST">
                                        <div class="form-group" style="width:60%">
                                            <label for="usernameSignin">Username:</label>
                                            <input type="text" class="form-control" name="usernameSignin">
                                            <span><font color ="red"><?php if (isset($message) && ($message == "Wrong username")) echo $message;
                                                                           else echo form_error("usernameSignin", "<font color='red'>", "</font>"); ?></font></span>
                                        </div>
                                        <div class="form-group" style="width:60%">
                                            <label for="pwd_signin">Password:</label>
                                            <input type="password" class="form-control" name="pwd_signin">
                                            <span><font color = "red"><?php if (isset($message) && ($message == "Wrong password")) echo $message;
                                                                            else echo form_error("pwd_signin", "<font color='red'>", "</font>"); ?></font></span>
                                        </div>
                                        <div class="form-group form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox"> Remember me
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-dark">Sign in</button>
                                    </form>
                                </div>
                                <div class="col-md-4" style="padding:10px;">
                                    <div class="card" style="width:60%;padding:10px;margin:20px; margin-right:30px;text-align:center;float: right;border-width: 5px">
                                        <div class="card-header" style="background-image: url('<?php echo base_url(); ?>img/pattern2.jpg');">
                                            <h4>
                                                <strong>
                                                    Sing up	
                                                </strong>
                                                <img src="<?php echo base_url(); ?>img/man.png" width="20px" id="signup_icon">
                                            </h4>
                                        </div>
                                        <div class="card-body" align="center" style="background-image: url('<?php echo base_url(); ?>img/pattern1.jpg');" >
                                            <form action="<?php echo base_url() ?>index.php/guest/register" method="POST">
                                                <div class="form-group" style="width:90%">
                                                    <input type="text" class="form-control" name="first_name" placeholder="First name">
                                                    <span><?php echo form_error("first_name", "<font color='red'>", "</font>"); ?></span>
                                                </div>
                                                <div class="form-group" align="left" style="width:90%">
                                                    <input type="text" class="form-control" name="last_name" placeholder="Last name">
                                                    <span><?php echo form_error("last_name", "<font color='red'>", "</font>"); ?></span>
                                                </div>
                                                <div class="form-group" align="left" style="width:90%">
                                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                                    <span><?php echo form_error("username", "<font color='red'>", "</font>"); ?></span>
                                                </div>
                                                <div class="form-group" align="left" style="width:90%">
                                                    <input type="password" class="form-control" name="pwd_signup" placeholder="Password">
                                                    <span><?php echo form_error("pwd_signup", "<font color='red'>", "</font>"); ?></span>
                                                </div>
                                                <div class="form-group" style="width:90%">
                                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                                    <span><?php echo form_error("email", "<font color='red'>", "</font>"); ?></span>

                                                </div>
                                                <div class="form-group" style="width:90%">
                                                    <select class="form-control" name="gender" id ="gender" onchange="setGenderIcon()">
                                                        <option value="0" selected>Gender 
                                                        </option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <span ><font color="red"><?php if (isset($message) && ($message == "Please select gender")) echo $message; ?></font></span>
                                                </div>
                                                <span ><font color="green"><?php if (isset($message) && ($message == "Successfully registred, you can login")) echo $message; ?></font></span>
                                                <hr width="60%">
                                                <button type="submit" class="btn btn-dark">Sign up</button>
                                                <br>
                                                <br>

                                            </form>

                                            <a href="<?php echo base_url() ?>index.php/guest/load/guest_home" class="btn btn-info">Enter as guest &nbsp;<img src="<?php echo base_url(); ?>img/in-guest.png" width="15px" style="opacity:0.5"></a>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <hr>
            <footer>
                <table width="100%">
                    <tr>
                        <td align="left">
                            <i>Software engineering, Faculty of Electrical engineering, University of Belgrade</i>
                        </td>
                        <td align="right">
                            <i>&copy; Copyright 2018.</i>
                        </td>
                    </tr>

                </table>
                <br>
            </footer>
        </div>



        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>
            function setGenderIcon()
{
	//alert("test");
	if (document.getElementById("signup_icon"))
	{
		var g=document.getElementById("gender").value;
               // alert (g);
		if (g=="male"){
                     
                    document.getElementById("signup_icon").src="<?php echo base_url() ?>img/man.png";
                }
			
		else
			if (g=="female"){
                           
                            document.getElementById("signup_icon").src="<?php echo base_url() ?>img/women.png";

                        }
				
	}
}
        </script>
    </body>
</html>
