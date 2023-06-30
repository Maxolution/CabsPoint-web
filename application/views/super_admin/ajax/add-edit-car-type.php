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
            <div class="col-md-12 grid-margin stretch-card" style="height: fit-content;">
             <!--  <div class="card"> -->
                <div class="card-body">
                  <h4 class="card-title"><?php echo $sub_title;?> </h4>
                  
                  <form class="forms-sample">

                    
                    
                    <div class="row">
                      <div class="col-md-12">
                        <label for="pickup_code">Car Icon*</label>
                        <center><div class="col-md-6 col-sm-6 col-xs-12">
                             <div class="photo" style="width: 145px;height:145px;border-radius: 100px;border: solid;"><i class="fa fa-photo" style="margin-top: 65px;margin-left: -2px;"><img id="imagepreview" src="" style="width: 145px;border-radius: 84px;margin-top:-82px;margin-left: -0%;height: 145px;display: none"></i></div>
                              <input type="file" name="car_icon" id="car_icon" style="opacity: 0.0; position: absolute; top: 0; left: 0; bottom: 0; right: 0; width: 84%; height:100%;" alertmsg="Please upload icon" />
                          </div></center>
                      </div>
                      <div class="col-md-12">
                          <label for="car_type">Car Type *</label>
                          <input type="text" class="form-control" id="car_type" placeholder="Enter Car Type" name="car_type" alertmsg="Please enter car type" value="<?php if($action_type=="edit"){ echo $car_type->car_type; }?>">
                      </div>
                      
                    </div>
                    

                    <div class="row">
                      <div class="col-md-12">
                      <label for="seater_type">Seater Type *</label>
                      <input type="text" class="form-control" id="seater_type" placeholder="Please Enter Seater Type" name="seater_type" alertmsg="Please enter seater type">
                      </div>
                      <div class="col-md-12">
                      <label for="luggages_count">Luggage Count(big) *</label>
                      <input type="text" class="form-control" id="luggages_count" placeholder="Please Enter Luggage Count(big)" name="luggages_count" alertmsg="Please enter luggage count(big)">
                     </div>
                     <div class="col-md-12">
                      <label for="journey_time">Luggage Count(small) *</label>
                        <div class="row">
                          <div class="col-md-12 grid-margin stretch-card">
                            <input type="text" class="form-control" id="luggages_count_small" placeholder="Please Enter Luggage Count(samll)" name="luggages_count_small" alertmsg="Please enter luggage count(small)">
                          </div>
                        </div>
                    </div>
                  </div>
                  
                    
                  </div>
                    
                  </form>
                </div>
              <!-- </div> -->
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="addupdatecartype()"><?php echo $button;?></button> 
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          </div>
            

          </div>

            
           
        </div>
        
      </div>
      <script type="text/javascript">
        function addupdatecartype(){
            
      	/*===============Validation Part============*/
      	var fielddata= ["car_icon","car_type","seater_type","luggages_count","luggages_count_small"];
      	var filter="false";
         var formdata= new FormData();
      	$.each(fielddata, function(index, value){
              if(value=="car_icon"){
                var file_data = $("#"+value).prop("files")[0];
                formdata.append(value,file_data);
              }else{
                formdata.append(value,$("#"+value).val());
              }
      		    
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
        if(filter=="true"){

          $.ajax({
            url: "<?php echo base_url('92a18ebfa7b2226dcdcbf2ebc13b5697'); ?>", // Upload Script
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: formdata, // Setting the data attribute of ajax with file_data
            type: 'post',
            success: function(data) {
              if(data.status=="ok"){
                swal(data.msg);
                location.reload();
               }else{
                 sweetAlert("Oops...", data.msg, "error");
               } 
            }
          });
        }

        

      	/*===============End Validation Part============*/
        }

        /*function addupdateoffer()
        {

          var filter = validationdata();

          
        }*/

        /*====================preview icon================*/

         $('#car_icon').click(function(){
                      function readURL(input) {
                            if (input.files && input.files[0]) {
                              var reader = new FileReader();
                              reader.onload = function(e) {
                              $('#imagepreview').attr('src', e.target.result);
                              $('#imagepreview').css("display","block");
                              }
                              reader.readAsDataURL(input.files[0]);
                            }
                          }

                          $('#car_icon').change(function() {
                            readURL(this);
                          });
                      });

      </script>
    