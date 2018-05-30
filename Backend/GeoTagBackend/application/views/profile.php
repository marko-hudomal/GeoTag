
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">

            <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url() ?>img/brown-gradient.png');">					
                <div class="media">
                    <img src="<?php echo $profile_pic;?>" class="rounded_circle" width="120px" style="margin-right:20px">
                    <br>
                    <div class="media-body">
                        <h2 class="mt-2"><strong><?php echo $this->session->userdata('user')->firstname." ".$this->session->userdata('user')->lastname ?></strong></h2>
                        <hr>
                        <h6>Username:								<span id="username_info"><?php echo $this->session->userdata('user')->username?></span> </h6>
                        <h6>Gender:								 	<span id="gender_info"><?php echo $this->session->userdata('user')->gender?></span> </h6>
                        <h6>Number of reviews:						<span id="num_reviews_info">X</span> </h6>	
                        <h6>Added places:							<span id="num_added_places_info">X</span> </h6>
                        <h6>Upvote/Downvote rate:					<span id="up_down_info">X</span> </h6>										
                    </div>
                </div>
                <br><br>
                <p>
                    <a class="btn btn-secondary" data-toggle="collapse" href="#changeUsername" role="button" aria-expanded="false" aria-controls="changeUsername">Change Username</a>
                    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#changePicture" aria-expanded="false" aria-controls="changePicture">Change Picture</button>
                    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#changePassword" aria-expanded="false" aria-controls="changePassword">Change Password</button>
                </p>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="collapse multi-collapse" id="changeUsername">
                            <div class="card card-body">
                                <?php
                        if (($this->session->userdata('user')) != NULL) {
                        $user1 = $this->session->userdata('user')->status;
                        }
                        else
                            $user1 ="guest";
                        ?>
                                <form action="<?php echo base_url() ?>index.php/<?php echo $user1;?>/change_username" method="POST">
                                    <div class="form-group" style="width:60%">
                                        <label for="usernameChange">New username:</label>
                                        <input type="text" class="form-control" name="usernameChange">

                                    </div>

                                    <button type="submit" class="btn btn-dark">Submit</button>
                                </form>
                            </div>
                        </div>
                        <span><font color ="green"><?php
                            if (isset($message) && ($message == "Successfully changed username"))
                                echo $message;
                            else
                                echo form_error("usernameChange", "<font color='red'>", "</font>");
                            ?></font></span>
                    </div>
                    <div class="col-sm-8">
                        <div class="collapse multi-collapse" id="changePicture">
                            <div class="card card-body">
<?php
                        if (($this->session->userdata('user')) != NULL) {
                        $user1 = $this->session->userdata('user')->status;
                        }
                        else
                            $user1 ="guest";
                        ?>

                                <form action="<?php echo base_url() ?>index.php/<?php echo $user1;?>/do_upload" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">

                                        <input type="file" class="form-control-file m-3" name="pic" id="pic">
                                        <button type="submit" class="btn btn-dark m-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            if (isset($message) && $message!="Successfully changed password" && $message!="Wrong old password" && $message!="Successfully changed username")
                                echo "<font color='red'>".$message. "</font>";?>
                    </div>
                    <div class="col-sm-8">
                        <div class="collapse multi-collapse" id="changePassword">
                            <div class="card card-body">
                                <?php
                        if (($this->session->userdata('user')) != NULL) {
                        $user1 = $this->session->userdata('user')->status;
                        }
                        else
                            $user1 ="guest";
                        ?>
                                <form action="<?php echo base_url() ?>index.php/<?php echo $user1;?>/change_password" method="POST">

                                    <div class="form-group" style="width:60%">
                                        <label for="oldPass">Old password:</label>
                                        <input type="password" class="form-control" name="oldPass">
                                        
                                    </div>
                                    <div class="form-group" style="width:60%">
                                        <label for="newPass1">New password:</label>
                                        <input type="password" class="form-control" name="newPass1">
                                        
                                    </div>
                                    <div class="form-group" style="width:60%">
                                        <label for="newPass2">Confirm new password:</label>
                                        <input type="password" class="form-control" name="newPass2">
                                        
                                    </div>
                                    <button type="submit" class="btn btn-dark">Submit</button>
                                </form>
                            </div>
                        </div>
                        <span><font color ="green"><?php
                            if (isset($message) && ($message == "Successfully changed password"))
                                echo $message;
                             else if (isset($message) && ($message == "Wrong old password"))
                                echo "<font color='red'>".$message. "</font>";
                            else{
                                echo form_error("oldPass", "<font color='red'>", "</font>");
                                echo form_error("newPass1", "<font color='red'>", "</font>");
                                echo form_error("newPass2", "<font color='red'>", "</font>");
                            }
                                
                            ?></font></span>
                    </div
                </div>

            </div>
        </div>

    </div>


