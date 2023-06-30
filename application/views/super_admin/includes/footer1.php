<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
  </div>
  <span class="text-muted d-block text-center text-sm-left d-sm-inline-block mt-2">Distributed By: <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a></span> 
</footer>
 <!-- base:js -->
  <script src="<?php echo base_url($assets);?>vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="<?php echo base_url($assets);?>js/off-canvas.js"></script>
  <script src="<?php echo base_url($assets);?>js/hoverable-collapse.js"></script>
  <script src="<?php echo base_url($assets);?>js/template.js"></script>
  <script src="<?php echo base_url($assets);?>js/sweetalert.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url($assets);?>js/jquery.dataTables.min.js"></script>
  
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script src="<?php echo base_url($assets);?>vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url($assets);?>vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="<?php echo base_url($assets);?>js/dashboard.js"></script>
  <!-- End custom js for this page-->

 <script type="text/javascript">
       $("#profilesetting").on("show.bs.modal",function(e){
          var link =  $(e.relatedTarget);
          $(this).find("#modaldialog").load(link.attr("href"));
          
        });
  </script>