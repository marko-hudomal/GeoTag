
<!-- Marko Hudomal 0112/15 -->
<!-- Dejan Ciric 570/15 -->

                <?php
                //User detection
                if (($this->session->userdata('user')) != NULL) {
                    $user1 = $this->session->userdata('user')->status;
                }
                else
                    $user1 = "guest";      
                ?>
		<div class="container-fluid">
			<div class="row">

					<div class="col-md-12">

						<div class="jumbotron" style="height:700px;background-size:cover; background-image: url('<?php echo base_url()?>img/brown-gradient.png');">					
							<div class="media">
								<img src="<?php echo base_url()?>img/statistics-icon.png" width="120px" style="margin-right:20px">
								<br>
								<div class="media-body">
									 <h2 class="mt-2"><strong>GeoTag weekly page statistics</strong></h2>
										<hr>
										<h6>New users:							<span id="new_users_stat"><?php echo $userCount;?></span> </h6> 
										<h6>Number of reviews:						<span id="num_reviews_stat"><?php echo $reviewCount;?></span> </h6>
										<h6>Number of positive reviews in last week:                    <span id="num_pos_reviews_stat"><?php echo $posReviews;?></span> </h6>	
										<h6>Added places:						<span id="num_added_places_stat"><?php echo $destinationCount;?></span> </h6>	
								</div>
							</div>


							<br>

								<div class="alert alert-dark" style="margin-top:70px">
									<div class="media">
										<img src="<?php echo base_url()?>img/achievement-icon.png" width="50px" style="margin-right:20px">
										<br>
										<div class="media-body">
											<h4 class="mt-2 mb-3">News</h4>
                                             <p>[30.5.2018] Today we added <strong>SuperUser</strong>! See more info in <a href="<?php echo base_url()?>index.php/<?php echo $user1;?>/load/guest_help">Help</a> tab.</p>
                                             <p>[3.6.2018] We hit <strong>100</strong> users!</p>
										</div>
									</div>

							</div>
						</div>
					</div>
			</div>


				