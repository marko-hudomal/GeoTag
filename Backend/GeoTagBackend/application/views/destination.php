<div class="container-fluid">
<div class="row">
   <div class="col-8">
      <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url(); ?>img/brown-gradient.png'); height:85%;">
         <div class="media">
            <img src="<?php echo base_url(); ?>img/achievement-icon.png" width="120px" style="margin-right:20px">
            <br>
            <div class="media-body">
               <h2 class="mt-2"><strong><?php echo $name.", ".$country ?></strong></h2>
               <hr>
               <div class="scrollable">
                  <table style="width:100%">
                     <tr>
                        <td>
                           <div class="card">
                              <div class="card-header" style="padding:1%">
                                 <div class="card-title">
                                    <strong>jakovj</strong>
                                    <input type="button" value="Delete Review" class="float-right btn btn-outline-danger">
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/plus-vote.png"  class="float-right destination-vote"></a>
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/minus-vote.png"  class="float-right destination-vote"></a>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <i>
                                    <p>
                                       "Great place!"
                                 </i>
                                 </p>
                              </div>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <div class="card">
                              <div class="card-header" style="padding:1%">
                                 <div class="card-title">
                                    <strong>jakovj</strong>
                                    <input type="button" value="Delete Review" class="float-right btn btn-outline-danger">
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/plus-vote.png" width="30px" class="float-right destination-vote"></a>
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/minus-vote.png" width="30px" class="float-right destination-vote"></a>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <i>
                                    <p>
                                       "Great place!"
                                 </i>
                                 </p>
                              </div>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td>
                           <div class="card">
                              <div class="card-header" style="padding:1%">
                                 <div class="card-title">
                                    <strong>jakovj</strong>
                                    <input type="button" value="Delete Review" class="float-right btn btn-outline-danger">
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/plus-vote.png" width="30px" class="float-right destination-vote"></a>
                                    <a onclick="" href="#"><img src="<?php echo base_url(); ?>img/minus-vote.png" width="30px" class="float-right destination-vote"></a>
                                 </div>
                              </div>
                              <div class="card-body">
                                 <i>
                                    <p>
                                       "Great place!"
                                 </i>
                                 </p>
                              </div>
                           </div>
                        </td>
                     </tr>
                  </table>
               </div>
            </div>
         </div>
         <br><br>
      </div>
   </div>
   <div class="col-4">
      <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url(); ?>img/brown-gradient.png'); height:85%;">
         <div class="form-group">
            <label for="comment">
               <h5><strong>Write your review</strong></h5>
            </label>
            <center><textarea class="form-control" rows="10" id="comment" cols="40"></textarea></center>
            <div style="padding-top:2%">
               <input type="button" value="Browse picture" class="btn btn-light">
            </div>
            <hr>
            <input type="button" value="Add review" class="btn btn-warning">
         </div>
      </div>
   </div>
</div>