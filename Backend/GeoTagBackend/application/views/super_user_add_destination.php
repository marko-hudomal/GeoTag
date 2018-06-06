
<!-- Jakov Jezdic 0043/15 -->


 <?php
    if (($this->session->userdata('user')) != NULL) {
        $user1 = $this->session->userdata('user')->status;
    }
    else
        $user1 ="guest";
?>
<div class="container-fluid" >
			<div class="row">
				<div class="col-sm-8">					
					<div onmouseover="showCoordinate()" id="map" class="card" style="height:700px;">
							<div id="map"></div>
					</div>
                                        <div id="pass_controller_type" hidden>
          <?php echo base_url().'index.php/'.$user1;?>
      </div>
					<script src="<?php echo base_url()?>js/map_styles.js"></script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGhsVpjnpP_alimoKSREfuSE8tJRA1v3U&callback=myMap"></script>
				</div>
					<div class="col-md-4">

						<div class="jumbotron" style="height:400px; padding:10px;padding-left:20px;padding-right:20px;background-size:cover; background-image: url('<?php echo base_url()?>img/brown-gradient.png');">
                                                            <?php
                                                            if (($this->session->userdata('user')) != NULL) {
                                                            $user1 = $this->session->userdata('user')->status;
                                                            }
                                                            else
                                                                $user1 ="guest";
                                                            ?>
                                                        <form action="<?php echo base_url() ?>index.php/<?php echo $user1;?>/add_destination" method="POST">
								<div class="form-group" style="width:60%">
									<label for="destination">Destination:</label>
										<input type="text" class="form-control" name="destination">
                                                                                <span><font color = "red"><?php echo form_error("destination", "<font color='red'>", "</font>"); ?></font></span>
								</div>
								<div class="form-group" style="width:60%">
									<label for="country">Country:</label>
									<input type="text" class="form-control" name="country">
                                                                        <span><font color = "red"><?php echo form_error("country", "<font color='red'>", "</font>"); ?></font></span>
								</div>
                                                                <div class="form-group" style="width:60%">
                                                                    <input type="hidden" name="longitudeH" id="longitudeH" value="">
                                                                    <input type="hidden" name="latitudeH"  id="latitudeH" value="">
                                                                        <label id="longitude" name ="longitude"></label><br>
									<label id="latitude" name = "latitude"></label>
								</div>
                                                            
								<button type="submit" class="btn btn-dark" onClick="getLatLng();">Add Location</button><br>
                                                                <span><font color = "green"><?php if (isset($message)) echo $message; ?></font></span>
							</form>
	
							<p>Drag marker until you reach to desired destination</p>
						</div>
						
					</div>
				</div>
</div>
