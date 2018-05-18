		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8">					
					<div id="map" class="card" style="height:700px;">
							<div id="map"></div>
					</div>

					<script src="<?php echo base_url()?>js/map_styles.js"></script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCGhsVpjnpP_alimoKSREfuSE8tJRA1v3U&callback=myMap"></script>
				</div>

					<div class="col-md-4">

						<div class="jumbotron" style="height:300px; padding:10px;padding-left:20px;padding-right:20px;background-size:cover; background-image: url('<?php echo base_url()?>img/brown-gradient.png');">
							<form>
								<div class="form-group" style="width:60%">
									<label for="destination">Destination:</label>
										<input type="text" class="form-control" id="destination">
								</div>
								<div class="form-group" style="width:60%">
									<label for="country">Country:</label>
									<input type="text" class="form-control" id="country">
								</div>
								<button type="submit" class="btn btn-dark" onClick="getLatLng();">Add Location</button>
							</form>
							<br>
							<p>Drag marker until you reach to desired destination</p>
						</div>
						
					</div>
				</div>
</div>
