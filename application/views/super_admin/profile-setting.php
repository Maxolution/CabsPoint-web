     
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: #0000ff;color: #ffffff;">
        	<h4 class="modal-title"><?php echo $title; ?></h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body admin_profile">

      

			<div class="form-group">
		      <label for="usr">NAME:</label>
		      <input type="text" id="name" value="<?php echo $admin_details['NAME']; ?>" class="form-control" name="name" alertmsg="Please Enter Name" maxlength = "10">
		    </div>

		    <div class="form-group">
		      <label for="usr">USER NAME:</label>
		      <input type="text" class="form-control" id="username" value="<?php echo $admin_details['USERNAME']; ?>" name="username" alertmsg="Enter User Name">
		    </div>

		    
		    <div class="form-group">
		      <label for="usr">EMAIL:</label>
		      <input type="text" class="form-control" id="email" value="<?php echo $admin_details['EMAIL']; ?>" name="amount" alertmsg="Enter Email Address">
		    </div>

		    <div class="form-group">
		      <label for="usr">PASSWORD:</label>
    		    <div class="input-group mb-3">
						  <input type="password" class="form-control" id="password" placeholder="Password" aria-label="Password" value="<?php echo $admin_details['PASSWORD']; ?>" aria-describedby="basic-addon2"/>
						  <span class="input-group-text toggle-password" show="0"><a href="javascript:void()"><i class="fa fa-eye toggle" aria-hidden="true"></i></a></span>
						</div>
		    </div>



           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="addupdate('<?php echo $admin_details['ID']; ?>')"><?php echo $button;?></button>	
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
      <script type="text/javascript">
  function addupdate(id){
      var formdata= new FormData();
	/*===============Validation Part============*/
	var fielddata= ["name","username","email","password"];
	var filter="false";
	$.each(fielddata, function(index, value){
		    formdata.append(value,$("#"+value).val());
            if($("#"+value).val()==""){
            	$("#"+value).focus();
            	filter="false";
            	alert($("#"+value).attr('alertmsg'));
            	return false;
            }else{
            	filter="true";
            }
            
        });

	/*===============End Validation Part============*/
	
	formdata.append('id',id);
	if(filter=="true"){
		   $.ajax({
		        url: '<?=base_url('4902a77a081a80ef0e8b1940076dc67e')?>',
		        data: formdata,
	            contentType: false,
	            processData:false,
	            dataType: "json",
	            async: 'true',
	            cache: 'false',
	            type: 'post',
		        success: function (data) {
		           if(data.status=="ok"){
		           	/*setTimeout(function () {

				        location.reload(true);
				      }, 1000);*/
		           	 swal(data.msg);
		           }else{
		           	 sweetAlert("Oops...", data.msg, "error");
		           }
		        }
		    });
		}
  }

      	$(".toggle-password").click(function() {
           var input = $(this).attr("show");
           if(input=="0"){
                 $(this).attr("show", "1");
                 $('.toggle').addClass("fa fa-eye");
                 $("#password").attr("type", "text");
           }else{
                 $(this).attr("show", "0");
                  $('.toggle').addClass("fa fa-eye-slash");
                 $("#password").attr("type", "password");
           }
				});
      </script>
    