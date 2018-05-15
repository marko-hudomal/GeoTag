
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

						<div class="jumbotron" style="height:500px; padding:10px;padding-left:20px;padding-right:20px;background-size:cover; background-image: url('<?php echo base_url()?>img/brown-gradient.png');">
							<div class="search" style="margin-bottom:20px">
								<form class="search-form">
									<input type="text" placeholder="Search for destinations, people...">
									<input type="submit" value="Search">
								</form>
							</div>
							<h5>Latest comments:</h5>
							<div id="random_comments">
									<div class="card" style="margin-top:20px">
										<div class="card-header">
											<table width="100%">
												<tr>
													<td width="80%"><strong>Hudi, Zakintos </strong></td>
													<td width="10%"><a onclick="" href="#"><img src="<?php echo base_url()?>img/plus-vote.png" width="20px"></a>&nbsp;10
													<td width="10%"><a onclick="" href="#"><img src="<?php echo base_url()?>img/minus-vote.png" width="20px"></a>&nbsp;10
												</tr>
											</table>
										</div>
										<div class="card-body">
											<i>Neki tekst</i>
										</div>
									</div>
									<div class="card" style="margin-top:20px">
										<div class="card-header">
											<table width="100%">
												<tr>
													<td width="80%"><strong>Hudi, Zakintos </strong></td>
													<td width="10%"><a onclick="" href="#"><img src="<?php echo base_url()?>img/plus-vote.png" width="20px"></a>&nbsp;10
													<td width="10%"><a onclick="" href="#"><img src="<?php echo base_url()?>img/minus-vote.png" width="20px"></a>&nbsp;10
												</tr>
											</table>
										</div>
										<div class="card-body">
											<i>Neki tekst</i>
										</div>
									</div>
								</div>
						</div>
						<div class="alert alert-info" style="height:150px;">
								<h5>Biraj stil mape:[Test deo]</h5>
								<hr>
								<div class="radio">
									<form name="map_style_form" id="map_style_form">
										<input type="radio" name="r" value="desert" checked onClick="refresh()">Pustinja
										<input type="radio" name="r" value="night" onClick="refresh()">Noc
									</form>
								</div>
						</div>
						
					</div>
				</div>

