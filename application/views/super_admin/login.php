<!DOCTYPE html>
<html lang="en">

<?php include('includes/header.php'); ?>

<?php $assets = "assets/superadmin/";?>
<link rel="stylesheet" href="<?php echo base_url($assets);?>css/style.css">
<link rel="stylesheet" href="<?php echo base_url($assets);?>css/sweetalert.css">
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="<?php echo base_url($assets);?>images/cabspointlogo.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              <form class="pt-3">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg"  placeholder="Username" id="EMAIL" alertmsg="Please Enter Username/Email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="PASSWORD" placeholder="Password" alertmsg="Please enter password">
                </div>
                <div class="mt-3">
                  <a class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" href="javascript:void()" onclick="superadminlogin()">SIGN IN</a>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="mdi mdi-facebook mr-2"></i> Connect using facebook
                  </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.html" class="text-primary">Create</a>
                </div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <?php include('includes/footer.php'); ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script type="text/javascript">
           function superadminlogin(){
            
            var formdata= new FormData();
            /*===============Validation Part============*/
            var fielddata= ["EMAIL","PASSWORD"];
            var filter="false";
            $.each(fielddata, function(index, value){
                    formdata.append(value,$("#"+value).val());
                    if($("#"+value).val()==""){
                        $("#"+value).focus();
                        filter="false";
                        swal($("#"+value).attr('alertmsg'));
                        return false;
                    }else{
                        filter="true";
                    }
                    
                });

            /*===============End Validation Part============*/
                if(filter=="true"){
                   $.ajax({
                        url: '<?php echo base_url('67a86d29dd2494711a0d032fd62e0ec7')?>',
                        data: formdata,
                        contentType: false,
                        processData:false,
                        dataType: "json",
                        async: 'true',
                        cache: 'false',
                        type: 'post',
                        success: function (data) {
                           if(data.status=="ok"){
                            setTimeout(function () {
                                window.location.href = "<?php echo base_url('fc67acb6f59ebc033d412b614f82ecd4'); ?>";
                              }, 1000);
                             /*alert(data.msg);*/
                           }else{
                             alert(data.msg);
                           }
                        }
                    });
                }

           }
        </script>
</body>

</html>
