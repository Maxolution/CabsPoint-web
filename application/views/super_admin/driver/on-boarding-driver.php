<!DOCTYPE html>
<style type="text/css">
  .dot {
       height: 25px;
       width: 25px;
       border-radius: 50%;
       display: inline-block;
      }

      .badge {
          background: radial-gradient( 5px -9px, circle, white 8%, red 26px );
          /*background-color: red;*/
          border: 2px solid white;
          border-radius: 12px; /* one half of ( (border * 2) + height + padding ) */
          /*box-shadow: 1px 1px 1px black;*/
          color: white;
          font: bold 15px/13px Helvetica, Verdana, Tahoma;
          height: 24px;
          min-width: 14px;
          padding: 4px 3px 0 3px;
          text-align: center;
      }

    .notification {
    color: white;
    text-decoration: none;
    padding: 0px 26px;
    position: relative;
    display: inline-block;
    border-radius: 2px;
  }


    .notification .badge {
      position: absolute;
      top: -10px;
      right: -10px;
      padding: 5px 10px;
      border-radius: 50%;
      background-color: red;
      color: white;
    }
</style>


<!-----------------------Header----------------->
   <?php include dirname(__FILE__).'/../includes/header.php'; ?>



   <!-- https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap.min.css
https://cdn.datatables.net/fixedheader/3.3.2/css/fixedHeader.bootstrap.min.css
https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap.min.css -->
<!---------------------/Header------------------->

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <!------------------------ Sidebar --------------------------->
        <?php include dirname(__FILE__).'/../includes/sidebar.php'; ?>
        <!-------------------------/Sidebar --------------------------->
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
         
          <?php include dirname(__FILE__).'/../includes/navbar.php'; ?>

         
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y" style="background-color: white;">
      <div class="row">
        
        <div class="col-md-9 col-sm-9 col-xs-9">
        <div class="border1" >
        <?php echo $page_title;?>
        </div>
        </div>
         <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="border2"  style="margin-left:89px;" >
         <i class="fa fa-calendar"></i>&nbsp; 26 may 2023&nbsp;&nbsp;
         <i class="fa fa-clock-o"></i>&nbsp; 19:00 (7 pm)
        </div>
        </div>
        <div class="row" style="padding: 16px;">
        
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
        
        
      </div>
       
       <div class="table-responsive" style="background-color: #ebecf1;padding: 12px;">      
        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Vehicle Type</th>
                <th>Area</th>
                <th>Status</th>
              </tr>
        </thead>
        <tbody>
            <?php if(!empty($all_driver)){
                 $i=1;
                foreach($all_driver as $driver){
                  ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $driver->driver_name;?></td>
                  <td><?php echo $driver->mobile;?></td>
                  <td><?php echo $driver->vehicle_type;?></td>
                  <td><?php echo $driver->driver_city;?></td> 
                  <td><a href="<?php echo base_url('c78c863c8df705ed4219c05d9aef69e1/'.$driver->id); ?>">View</a>&nbsp;&nbsp;<i class="fa fa-check-circle" style="font-size:18px;color:red"></i></td>
              </tr>

                  <?php
                  $i++;
                }

              }
              ?>
               </tbody>
            </table>
          </div>
                
            <div class="content-backdrop fade"></div>
          </div>
      </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

 

    <!--------------------------Footer----------------------->
    <?php include dirname(__FILE__).'/../includes/footer.php'; ?>
   <!--------------------------Footer-------------------------->
   <script type="text/javascript">
     
     $(document).ready( function () {
          $('#example').DataTable();

      } );
   </script>
  </body>
</html>
