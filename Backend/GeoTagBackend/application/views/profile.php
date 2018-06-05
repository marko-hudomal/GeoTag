<div class="container-fluid">
<div class="row">
<div class="col-md-12">
   <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url() ?>img/brown-gradient.png');">
      <div class="row">
         <div class = "col-md-8">
            <div class="media">
               <img src="<?php echo $profile_pic;?>" class="rounded_circle" width="120px" style="margin-right:20px">
               <br>
               <div class="media-body">
                  <h2 class="mt-2"><strong><?php echo $this->session->userdata('user')->firstname." ".$this->session->userdata('user')->lastname ?></strong></h2>
                  <hr>
                  <h6>Username:								<span id="username_info"><?php echo $this->session->userdata('user')->username?></span> </h6>
                  <h6>Gender:								<span id="gender_info"><?php echo $this->session->userdata('user')->gender?></span> </h6>
                  <h6>Number of reviews:						<span id="num_reviews_info"><?php  echo $review_count ?></span> </h6>
                  <h6>Added places:							<span id="num_added_places_info"><?php echo $places_count ?></span> </h6>
                  <h6>Upvote/Downvote rate:                                             <span id="up_down_info"><?php echo $up_count.'/'.$down_count ?></span> </h6>                
                        <div class="progress" style="width:190px; height:20px;">
                            <?php if (($up_count+$down_count)==0)
                            {
                                echo "  <div class=\"progress-bar-striped progress-bar-success progress-bar-animated\" role=\"progressbar\" aria-valuenow=\"90\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"text-align:center; background-color: #ff9900;width: 100%\">
                                        <h6 style=\"color:white;font-weight: 600;\">No votes</h6>
                                        </div>";
                            }else
                            {
                                echo "  <div class=\"progress-bar-striped progress-bar-success progress-bar-animated\" role=\"progressbar\" aria-valuenow=\"90\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"text-align:center; background-color: #339933;width: ".(($up_count*1.0/($up_count+$down_count))*100.0)."%\">
                                        <h6 style=\"color:white;font-weight: 600;\">".$up_count."</h6>
                                        </div>
                                        <div class=\"progress-bar-striped progress-bar-danger progress-bar-animated\" role=\"progressbar\" aria-valuenow=\"90\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"text-align:center; background-color: #b30000;width: ".(($down_count*1.0/($up_count+$down_count))*100.0)."%\">
                                                <h6 style=\"color:white;font-weight: 600;\">".$down_count."</h6>
                                        </div>";
                            }
                            ?>                  
                        </div>
               </div>
            </div>
            <br><br>
            <p>
               <a class="btn btn-secondary" data-toggle="collapse" href="#changeUsername" role="button" aria-expanded="false" aria-controls="changeUsername">Change Username</a>
               <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#changePicture" aria-expanded="false" aria-controls="changePicture">Change Picture</button>
               <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#changePassword" aria-expanded="false" aria-controls="changePassword">Change Password</button>
            </p>
            <div class="row">
               <div class="col-sm-4">
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
                              <label for="oldPass1">Password:</label>
                              <input type="password" class="form-control" name="oldPass1">
                           </div>
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
                     else if (isset($message) && ($message == "Wrong old password!"))
                         echo "<font color='red'>".$message. "</font>";
                     else{
                         echo form_error("oldPass1", "<font color='red'>", "</font>");
                         echo form_error("usernameChange", "<font color='red'>", "</font>");            
                     }
                    
                     ?></font></span>
                   
               </div>
               <div class="col-sm-4">
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
                     if (isset($message) && $message!="Successfully changed password" && $message!="Wrong old password" && $message!="Wrong old password!" && $message!="Successfully changed username")
                         echo "<font color='red'>".$message. "</font>";?>
               </div>
               <div class="col-sm-4">
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
         <div class="col-md-4">
            <input class="form-control" name="search_text_people" id="search_text_people" type="text" placeholder="Search for people">
            <div id="result_people"></div>
         </div>
      </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
   $("#search_text_people").focus(function(){
          
   	load_data();
   
   	function load_data(query)
   	{
   		$.ajax({
                           <?php
      if (($this->session->userdata('user')) != NULL) {
      $user1 = $this->session->userdata('user')->status;
      }
      else
          $user1 ="guest";
      ?>
   			url:"<?php echo base_url(); ?>index.php/<?php echo $user1;?>/search_people",
   			method:"POST",
   			data:{query:query},
   			success:function(data){
   				$('#result_people').html(data);
   			}
   		})
   	}
   
   	$('#search_text_people').keyup(function(){
   		var search = $(this).val();
   		if(search != '')
   		{
   			load_data(search);
   		}
   		else
   		{
   			load_data();
   		}
   	});
   });
   
</script>