
<!-- Milos Matijasevic 0440/15 -->
<!-- Jakov Jezdic 0043/15 -->


<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">

            <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url() ?>img/brown-gradient.png');">
                <div class="row">
                <div class = "col-md-8">
                <div class="media">
                    <img src="<?php echo $profile_pic;?>" class="rounded_circle" width="150" style="margin-right:20px">
                    <br>
                    <div class="media-body">
                        <h2 class="mt-2"><strong><?php echo $firstname." ".$lastname ?></strong>
                            <?php
                                switch ($status) {
                                    case "user":
                                        echo "&nbsp;<span class=\"badge badge-success\">User</span>";
                                        break;
                                    case "super_user":
                                        echo "&nbsp;<span class=\"badge badge-warning\">SuperUser</span>";
                                        break;
                                    case "admin":
                                        echo "&nbsp;<span class=\"badge badge-danger\">Admin</span>";
                                        break;
                                    default:
                                        echo "&nbsp;<span class=\"badge badge-info\">Other</span>";
                                }                             
                            ?>
                            
                        </h2>
                        <hr>
                        <h6>Username:                                                                   <span id="username_info"><?php echo $username?></span> </h6>
                        <!--<h6>Status:								 	<span id="status_info"><?php /*echo $status*/?></span> </h6>-->
                        <h6>Gender:								 	<span id="gender_info"><?php echo $gender?></span> </h6>
                        <h6>Number of reviews:                                                          <span id="num_reviews_info"><?php  echo $review_count ?></span> </h6>	
                        <h6>Added places:                                                               <span id="num_added_places_info"><?php echo $places_count ?></span> </h6>
                        <h6>Upvote/Downvote rate:                                                       <span id="up_down_info"><?php echo $up_count.'/'.$down_count ?></span> </h6>										
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
                        
                         <?php
                            //User detection
                            if (($this->session->userdata('user')) != NULL) {
                                $user1 = $this->session->userdata('user')->status;
                            }
                            else
                                $user1 = "Guest";   
                            
                            
                            if ($user1=="admin"){
                                if ($status=="user"){
                                    $link=base_url()."index.php/".$user1."/promote_user/".$username;
                                    echo "<br>  <a href='".$link."' class='btn btn-success'>
                                                Promote user
                                                <img src=\"".base_url()."img/promote-icon.png\" width=\"15px\" style=\"opacity:1\">
                                                </a> ";
                                    
                                    $link=base_url()."index.php/".$user1."/delete_user/".$username;
                                    echo "<a href='".$link."' class='btn btn-danger'>Delete user <img src=\"".base_url()."img/delete-icon.png\" width=\"15px\" style=\"opacity:1\"></a> ";
                    
                                }
      
                            }
                            
                             if ($user1=="admin"){
                                if ($status=="super_user"){                      
                                    $link=base_url()."index.php/".$user1."/delete_user/".$username;
                                    echo "<br>  <a href='".$link."' class='btn btn-danger'>
                                                Delete user
                                                <img src=\"".base_url()."img/delete-icon.png\" width=\"15px\" style=\"opacity:1\">
                                                </a> ";

                                }
      
                            }
                            ?>
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



