<div class="container-fluid">
<div class="row">
   <div class="col-12">
       
      <div class="jumbotron" style="background-size:cover; background-image: url('<?php echo base_url(); ?>img/brown-gradient.png'); height:85%; overflow:auto;">
         <div class="media">
            <img src="<?php if ($image==null) echo base_url().'img/destination-icon.png'; else echo $image; ?>" width="180px" style="margin-right:20px;border: 3px solid #333333;">
           
            <br>
            <div class="media-body" style="overflow:auto;">
                <table>
                    <tr>
                        <td style="width: 100%">
                            <h2 class="mt-2">
                                <strong>
                                    <?php echo $dest_name.", ".$dest_country ?> 
                                </strong> 
                            </h2>
                        </td>
                        <!--
                        <td style="width: 60%">
                            <div class="progress" style="margin-left:50px;width:100%; height:20px">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style=" background-color: COLOR;width: <?php echo $review_balance_percentage;?>%">
                                  PERCENTAGE%
                                </div>
                            </div>
                        </td>
                        -->
                    </tr>
                </table>
         
               <hr>
               <div style="width: 100%;height:80%;overflow:auto;marign-bottom:10px;">
                      
                     <?php echo $all_reviews_current_destination_html; ?>
                     
               </div>
            </div>
         </div>
         <br><br>
      </div>
   </div>
</div>