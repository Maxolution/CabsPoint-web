     <style type="text/css">
     	.admin_profile {
     /* background-image: url("<?php //echo base_url('assets/superadmin/img/images.jfif'); ?>");*/
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      opacity: 0.6;
    }
    .form-control {
        border: 1px solid #7a7b83;
        font-weight: 400;
        font-size: $input-font-size;
        
      }
     select.form-control{
      border: 1px solid #7a7b83;

     }

     </style>
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #0000ff;color: #ffffff;">
        	<h6 class="modal-title"><?php echo $title; ?></h6>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body admin_profile">
             <div class="row">
            <div class="col-md-8 grid-margin stretch-card" style="height: fit-content;">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Job Information</h4>
                  
                  <form class="forms-sample">
                    <div class="row">
                        <div class="col-md-12">
                        <label for="job_reference">Job Reference *</label>
                        <input type="text" class="form-control" id="job_reference" placeholder="Job Reference" name="job_reference" alertmsg="Please enter job reference">
                      </div>
                      
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <label for="pickup_code">Pickup Code *</label>
                        <input type="text" class="form-control" id="pickup_code" placeholder="Pickup Code" name="pickup_code" alertmsg="Please enter pickup code">
                      </div>
                      <div class="col-md-6">
                          <label for="pickup_address">Pickup Address *</label>
                          <input type="text" class="form-control" id="pickup_address" placeholder="Pickup Address" name="pickup_address" alertmsg="Please enter pickup address">
                      </div>
                      
                    </div>
                    

                    <div class="row">
                      <div class="col-md-6">
                      <label for="dropoff_code">Dropoff Code *</label>
                      <input type="text" class="form-control" id="dropoff_code" placeholder="Dropoff Code" name="dropoff_code" alertmsg="Please enter dropoof code">
                      </div>
                      <div class="col-md-6">
                      <label for="dropoff_address">Dropoff Address *</label>
                      <input type="text" class="form-control" id="dropoff_address" placeholder="Dropoff Address" name="dropoff_address" alertmsg="Please enter dropoff address">
                     </div>
                     <div class="col-md-12">
                      <label for="journey_time">Journey Time *</label>
                        <div class="row">
                          <div class="col-md-6 grid-margin stretch-card">
                            <input class="form-control" placeholder="" name="journey_time" type="date" id="journey_time" value="" alertmsg="Please select journey time">
                          </div>
                          <div class="col-md-6 grid-margin stretch-card">
                            <select name="OfferjobHour" class="require valid" id="OfferjobHour">
                              <?php
                              $jobHour = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
                                for($i=0;$i<count($jobHour);$i++){
                                if(strlen($jobHour[$i])==1){
                                    $jobHour[$i] = "0".$jobHour[$i];
                                }
                                ?>
                                  <option value="<?php echo $jobHour[$i]; ?>"><?php echo $jobHour[$i]; ?></option>
                                <?php
                              }
                              ?>
                            
                            </select>
                            <select name="OfferjobMinute" class="require" id="OfferjobMinute">
                              <?php
                              $jobMinutes = array(00,05,10,15,20,25,30,35,40,45,50,55,59);
                              for($i=0;$i<count($jobMinutes);$i++){
                                if(strlen($jobMinutes[$i])==1){
                                    $jobMinutes[$i] = "0".$jobMinutes[$i];
                                }
                                ?>
                                  <option value="<?php echo $jobMinutes[$i]; ?>"><?php echo $jobMinutes[$i]; ?></option>
                                <?php
                              }
                              ?>
                              </select>
                          </div>
                          
                        </div>
                    </div>
                  </div>


                  <div class="row">
                      <div class="col-md-6">
                        <label for="child_seat">Child Seat *</label>
                        <select name="child_seat" class="form-control require valid" id="child_seat" alertmsg="Please select child seat">
                        <option value="N" selected>No</option>
                        <option value="Y">Yes</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="car_type">Car Type *</label>
                      <select name="car_type" class="form-control require valid" id="car_type" alertmsg="Please select car type">
                      <option value="" selected="selected">--Select--</option>
                      <?php 
                       if(!empty($car_type)){
                        foreach($car_type as $val){
                          ?>
                            <option value="<?php echo $val->id; ?>"><?php echo $val->car_type; ?></option>
                          <?php
                        }
                       }

                       ?>
                      
                      </select>
                    </div>
                  </div>


                  <div class="row">
                      <div class="col-md-6">
                        <label for="payment_type">Payment Type *</label>
                            <select class="form-control" id="payment_type" name="payment_type" alertmsg="Please select payment type">
                              <option>--Select--</option>
                              <?php if(!empty($payment_type)){
                                 foreach($payment_type as $Payment_type){
                                  ?>
                                    <option value="<?php echo $Payment_type->id;  ?>"><?php echo $Payment_type->payment_type;  ?></option>
                                  <?php
                                 }

                              } ?>
                            </select>

                      </div>
                      <div class="col-md-6">
                        <label for="Price">Price *</label>
                        <div class="row">
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="original_price" placeholder="Original Price" name="original_price" alertmsg="Please enter original price">
                          </div>
                          <div class="col-md-6">
                            <input type="text" class="form-control" id="byit_now_price" placeholder="Buy It Now" name="byit_now_price" alertmsg="Please enter by it now price">
                          </div>
                          <div class="col-md-12">
                            <label for="exampleInputConfirmPassword1">Lowest Bid</label>
                            <label for="exampleInputConfirmPassword1">Not Completed</label>
                          </div>
                          
                        </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <label for="Notes">Notes</label>
                          <textarea type="text" class="form-control" id="notes" name="notes" placeholder="Notes" cols="10" rows="5" alertmsg="Please enter notes"></textarea>
                      </div>
                      <div class="col-md-6">
                        <label for="bid_open_time">Bid Open For *</label>
                          <select class="form-control require valid" id="bid_open_time" name="bid_open_time" alertmsg="Please select bid open for">
                          <option value="5">5 minutes</option>
                          <option value="10">10 minutes</option>
                          <option value="15">15 minutes</option>
                          <option value="30">30 minutes</option>
                          <option value="60" selected="selected">1 hour</option>
                          <option value="120">2 hours</option>
                          </select>  
                      </div>
                  </div>
                    
                  </form>
                </div>
              </div>
            </div>
            
           <!-- =======================Customer Information=============== -->
            <div class="col-md-4 grid-margin stretch-card" style="height: fit-content;">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Customer Information</h4>
                  
                  <form class="forms-sample">
                    <div class="">
                      <label for="phone">Phone *</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter phone.." alertmsg="please enter phone number">
                    </div>
                    <div class="">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Enter email" alertmsg="Please enter email address">
                    </div>
                    <div class="">
                      <label for="passenger_count">Passengers (upto)</label>
                      <input type="text" class="form-control" name="passenger_count" id="passenger_count" placeholder="Enter passengers (upto).." alertmsg="Please enter number of passenger">
                    </div>
                    <div class="">
                      <label for="luggages_count">Luggages (upto)</label>
                      <input type="text" class="form-control" name="luggages_count" id="luggages_count" placeholder="Enter luggages (upto).." alertmsg="Please enter number of luggages">
                    </div>

                    <div class="">
                      <label>Additional Information</label>
                    </div>

                    <div class="">
                      <label for="flight_name">Flight</label>
                      <input type="text" class="form-control" name="flight_name" id="flight_name" placeholder="Enter flight.." alertmsg="Please enter flight details">
                    </div>


                   
                      <div class="">
                        <label for="city_of_arrival">City of Arrival</label>
                        <input type="text" class="form-control" name="city_of_arrival" id="city_of_arrival" placeholder="Enter city of arrival.." alertmsg="Please enter city of arrival">
                        
                      </div>

                      <div class="">
                        <label for="meet_after_time">Meet After </label>
                        
                        <select name="meet_after_time" class="form-control" id="meet_after_time" alertmsg="Please select meet after time">
                          <option value="0" selected="selected">immediately</option>
                          <option value="15">15 minutes</option>
                          <option value="20">20 minutes</option>
                          <option value="25">25 minutes</option>
                          <option value="30">30 minutes</option>
                          <option value="35">35 minutes</option>
                          <option value="40">40 minutes</option>
                          <option value="45">45 minutes</option>
                          <option value="50">50 minutes</option>
                          <option value="55">55 minutes</option>
                          <option value="60">60 minutes</option>
                          <option value="75">75 minutes</option>
                          <option value="90">90 minutes</option>
                          <option value="120">120 minutes</option>
                          </select>
                      </div>
                   

                    <div class="">
                      <label for="booker_agency">Booker/Agency*</label>
                          <input type="text" class="form-control" id="booker_agency" placeholder="Booker Agency" name="booker_agency" alertmsg="Please enter booker agency">
                      
                    </div>

                   
                    
                  </form>
                </div>
              </div>
            </div>

            <!-- =======================End Customer Information=============== -->

          </div>


           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="addupdateoffer()"><?php echo $button;?></button>	
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <script type="text/javascript">
        function validationdata(){
            
      	/*===============Validation Part============*/
      	var fielddata= ["job_reference","pickup_code","pickup_address","dropoff_code","dropoff_address","journey_time","child_seat","car_type","payment_type","original_price","byit_now_price","notes","bid_open_time","phone","email","passenger_count","luggages_count","flight_name","city_of_arrival","meet_after_time","booker_agency"];
      	var filter="false";
         var formdata= new FormData();
      	$.each(fielddata, function(index, value){
          
      		    formdata.append(value,$("#"+value).val());
                  if($("#"+value).val()==""){
                  	filter="false";
                    sweetAlert("Oops...", $("#"+value).attr('alertmsg'), "error").then(function() {
                          $("#"+value).focus();
                      });
                    
                  	return false;
                  }else{
                  	filter="true";
                  }
              });
        return filter;

      	/*===============End Validation Part============*/
        }

        function addupdateoffer()
        {
          var filter = validationdata();
          /*alert(filter);*/
        }

      </script>
    