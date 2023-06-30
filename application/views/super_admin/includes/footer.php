 
 <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?php echo base_url(); ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?php echo base_url(); ?>assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url(); ?>assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url(); ?>assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <script src="<?php echo base_url($assets);?>js/off-canvas.js"></script>
    <script src="<?php echo base_url($assets);?>js/hoverable-collapse.js"></script>
    <script src="<?php echo base_url($assets);?>js/template.js"></script>
    <script src="<?php echo base_url($assets);?>js/sweetalert.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url($assets);?>js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
       $("#profilesetting").on("show.bs.modal",function(e){
          var link =  $(e.relatedTarget);
          alert(link.attr("href"));
          $(this).find("#modaldialog").load(link.attr("href"));
          
        });
  </script>