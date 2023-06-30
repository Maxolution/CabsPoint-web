<!DOCTYPE html>

<!-----------------------Header----------------->
   <?php $this->load->view('super_admin/includes/header.php');?>
<!---------------------/Header------------------->

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <!--------------------- Sidebar ------------------>
          
          <?php $this->load->view('super_admin/includes/sidebar.php');?>
        <!--------------------/Sidebar -------------------->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <?php $this->load->view('super_admin/includes/navbar.php');?>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
				<div class="row">
				
				<div class="col-md-9 col-sm-9 col-xs-9">
				<div class="border1">
				On Boarding Driver
				</div>
				</div>
			   <div class="col-md-3 col-sm-3 col-xs-3">
				<div class="border1" >
				<i class="fa fa-calendar"></i>&nbsp; 26 may 2023&nbsp;&nbsp;
				<i class="fa fa-clock-o"></i>&nbsp; 19:00 (7 pm)
				</div>
				</div>
				
				
				</br></br></br>
				<div class="maine" style=" background: #d3f5fc; padding:15px;">
			
			<div class="row">
				
				<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="border" style="border: 1px solid #23344678 !important;
                     width: 137px;
               padding: 8px; border-radius:8px;">
				New Driver <img src="<?php echo base_url(); ?>/assets/img/images/Group 74.png" class="responsive">
				</div>
				</div>
			   <div class="col-md-3 col-sm-3 col-xs-3">
				<div class="border" style="border: 1px solid #23344678 !important;
                     width: 137px;
               padding: 8px; border-radius:8px;">
				Details Fill <img src="<?php echo base_url(); ?>/assets/img/images/Group 74.png" class="responsive">
				</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<div class="border" style="border: 1px solid #23344678 !important;
                     width: 165px;
               padding: 8px; border-radius:8px;">
				Pending Details <img src="<?php echo base_url(); ?>/assets/img/images/Group 74.png" class="responsive">
				</div>
				
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
				<div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                 <!-- <i class="bx bx-search fs-4 lh-0"></i>--->
				  
                  <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
				 <i class="bx bx-search fs-4 lh-0" style="margin-left: -30px;"> </i>
                </div>
              </div>
				
				</div>
				
			</div>
			</div>
			<div class="row" style="margin-top:10px;">
				<div class="col-md-6">
			<div class="row">
			
				<!-- <div class="col-md-3">
				  <img src="<?php echo base_url(); ?>/assets/img/images/Rectangle 32.png" class="responsive">
	        <div class="edit" style="margin-top: -102px;margin-left: 90px; ">
					 <a href="#">Edit</a>
				  </div>
				   <p style="text-align:center; margin-top: 83px;">Photo</p>
				</div> -->

			  <div class="col-md-3">
			    <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['driver_license_f'];} ?>" class="responsive">
           <div class="edit" style="margin-top: -102px;margin-left: 90px; ">
				    <a href="#">Edit</a>
				   </div>
				  <p style="text-align:center; margin-top: 83px;">Driving License</p>
				</div>

				<div class="col-md-3">
				  <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['driver_pco'];} ?>" class="responsive">
          <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				  <a href="#">Edit</a>
				  </div>
				   <p style="text-align:center; margin-top: 83px;">Driver PCO</p>
				</div>

				<div class="col-md-3">
				  <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['N_I'];} ?>" class="responsive">
          <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				  <a href="#">Edit</a>
				  </div>
				  <p style="text-align:center; margin-top: 83px;">Insurance Number</p>
				</div>
				
			</div>
			</div>
			<div class="col-md-6">
			<div class="row">
				<div class="col-md-3">
				    <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['logbook'];} ?>" class="responsive">
           <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				     <a href="#">Edit</a>
				   </div>
				  <p style="text-align:center; margin-top: 83px;">Log book</p>
				</div>

			   <div class="col-md-3">
			      <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['rental_agreement'];} ?>" class="responsive">
            <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				     <a href="#">Edit</a>
				    </div>
				     <p style="text-align:center; margin-top: 83px;">Rental Agreement</p>
				<!-- <img src="<?php echo base_url(); ?>/assets/img/images/Rectangle 83.png" class="responsive" style="margin-top: -110px;"> -->
				</div>

				<div class="col-md-3">
				  <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['insurance'];} ?>" class="responsive">
          <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				   <a href="#">Edit</a>
				  </div>
				  <p style="text-align:center; margin-top: 83px;">Insurance</p>
				</div>

				<div class="col-md-3">
				  <img src="<?php if(!empty($driver_details)){ echo $driver_details->driver_document['vehicle_pco'];} ?>" class="responsive">
          <div class="edit" style="margin-top: -102px; margin-left: 90px; ">
				  <a href="#">Edit</a>
				  </div>
				  <p style="text-align:center; margin-top: 83px;">Vehicle PCO</p>
				</div>

			</div>
			</div>
			</div>
               <div class="row">
                <!-- Basic Layout -->
                <div class="col-md-8">
                  <div class="card mb-4">
                    
                    <div class="card-body">
                      <form>
	                
						<label class="radio-inline"  style="margin-left: 145px;">
						  <input type="radio" name="optradio" checked>&nbsp;&nbsp;Male
						</label>
						<label class="radio-inline">
						  <input type="radio" name="optradio">&nbsp;&nbsp;Female
						</label><br>
						
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-name">Full name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-name" placeholder="John Doe" style="width: 270px;">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-company">Mobile Number</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="basic-default-company" placeholder="9597687502" style="width: 270px;">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                          <div class="col-sm-10">
                            <div class="">
                             <input type="text" class="form-control" id="basic-default-name" placeholder="Email id" style="width: 270px;">
                            
                            </div>
                            <div class="form-text">You can use letters, numbers &amp; periods</div>
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">driving License</label>
                          <div class="col-sm-4">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">driver PCO</label>
                          <div class="col-sm-4">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">NI Number</label>
                          <div class="col-sm-4">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="Number" aria-label="Number" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                      </form>
					   
                    </div>
					
                  </div>
				  
                </div>
				
                <!-- Basic with Icons -->
                <div class="col-md-4">
                  <div class="card mb-4">
                  
                    <div class="card-body" style="background:#d3f5fc;">
                      
                      <img src="<?php echo base_url(); ?>/assets/img/images/driver 2 1.png" class="responsive" >
                     
                    </div>
                  </div>
                </div>
              </div>
			  <!----Second data--->
			   <div class="row">
                <!-- Basic Layout -->
                <div class="col-md-8" style="
    margin-top: -82px;"
>
                  <div class="card mb-4">
                    
                    <div class="card-body">
                      <form>
	                 <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Log Book</label>
                          <div class="col-sm-2">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="Reg NO" aria-label="Reg NO" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-2">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="Make" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-3">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="model" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-3">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="colour" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                        
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone"> Agreement</label>
                          <div class="col-sm-6">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
						 <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Insurance</label>
                          <div class="col-sm-6">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">Vehicle PCO</label>
                          <div class="col-sm-6">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
                        <div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">	MOT</label>
                          <div class="col-sm-6">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
						<div class="row mb-3">
                          <label class="col-sm-2 col-form-label" for="basic-default-phone">	Vehicle Valid</label>
                          <div class="col-sm-6">
                            <input type="text" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
						   <div class="col-sm-4">
                            <input type="date" id="basic-default-phone" class="form-control phone-mask" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                          </div>
                        </div>
						<div class="row mb-3" style=" float: right;">
                                 
                          <div class="col-sm-6">
                           <button class="btn btn-default" style="background: gray; color:white;">Reset</button>
						   <button class="btn btn-success" style="    margin-top: -64px;
    margin-left: 93px;">Submit</button>
                          </div>
						   
                        </div>
                      </form>
					   
                    </div>
					
                  </div>
				  
                </div>
				
                <!-- Basic with Icons -->
                <div class="col-md-4">
                  
                  
                   
                      <img src="<?php echo base_url(); ?>/assets/img/images/Rectangle 60.png" class="responsive" >
                     
  
                </div>
              </div>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

   <!--------------------------Footer----------------------->
   <?php $this->load->view('super_admin/includes/footer.php');?>
   <!--------------------------Footer-------------------------->
 

   
  </body>
</html>
