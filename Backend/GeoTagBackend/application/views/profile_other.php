
<div class="container-fluid">
    <div class="row">

        <div class="col-md-12">

            <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url() ?>img/brown-gradient.png');">					
                <div class="media">
                    <img src="<?php echo $profile_pic;?>" class="rounded_circle" width="120px" style="margin-right:20px">
                    <br>
                    <div class="media-body">
                        <h2 class="mt-2"><strong><?php echo $firstname." ".$lastname ?></strong></h2>
                        <hr>
                        <h6>Username:								<span id="username_info"><?php echo $username?></span> </h6>
                        <h6>Gender:								 	<span id="gender_info"><?php echo $gender?></span> </h6>
                        <h6>Number of reviews:						<span id="num_reviews_info"><?php  echo $review_count ?></span> </h6>	
                        <h6>Added places:							<span id="num_added_places_info"><?php echo $places_count ?></span> </h6>
                        <h6>Upvote/Downvote rate:					<span id="up_down_info"><?php echo $up_count.'/'.$down_count ?></span> </h6>										
                    </div>
                </div>
             
        </div>

    </div>


