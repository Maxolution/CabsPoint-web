<!DOCTYPE html>
<html lang="en">
<?php include('includes/header.php'); ?>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <?php include('includes/navbar.php'); ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <?php include('includes/sidebar.php'); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <!-- <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <h4 class="font-weight-bold text-dark">Hi, welcome back!</h4>
              <p class="font-weight-normal mb-2 text-muted">APRIL 1, 2019</p>
            </div>
          </div> -->
          <div class="col-lg-12 ">
              <div class="header">
				  <a href="#default" class="logo">Offer Job</a>
				  <div class="header-right">
				    <a class="dropdown-item preview-item active" href="<?php echo base_url('Super_admin/Offerjobs/addeditofferjobs');?>" role="button" data-toggle="modal" data-target="#addeditofferjobs" data-remote="false"><button type="button" class="btn btn-info font-weight-bold">+ Add a new job offer</button></a>
				  </div>
				</div>
             
          </div>
          
          <div class="col-lg-12 grid-margin stretch-card">
          	  
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example" class="display" style="width:100%">
				        <thead>
				            <tr>
				            	<!-- <th>#</th> -->
				                <th>Job Ref.</th>
				                <th>Job Date</th>
				                <th>Pickup</th>
				                <th>Dropoff</th>
				                <th>City,Flight,Meet Time</th>
				                <th>Car Type</th>
				                <th>Original Price</th>
				                <th>By It Now</th>
				                <th>Lowest Price</th>
				                <th>Bid Close Time</th>
				                <th>Status</th>
				                <th>Action</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php 
				        		for($i=0;$i<50;$i++)
				        		{
				        			?>
				        			<tr>
				        				<!-- <td><?php echo $i+1; ?></td> -->
						                <td>Job Ref</td>
						                <td>Job Date</td>
						                <td>Pickup</td>
						                <td>Dropoff</td>
						                <td>City,Flight,Meet Time</td>
						                <td>Car Type</td>
						                <td>Original Price</td>
						                <td>By It Now</td>
						                <td>Lowest Price</td>
						                <td>Bid Close Time</td>
						                <td>Status</td>
						                <td>Action</td>
						            </tr>

				        			<?php
				        		}
				        	?>

				            
				        </tbody>
				        <!-- <tfoot>
				            <tr>
				                <th>Name</th>
				                <th>Position</th>
				                <th>Office</th>
				                <th>Age</th>
				                <th>Start date</th>
				                <th>Salary</th>
				            </tr>
				        </tfoot> -->
				    </table>
                  </div>
                </div>
              </div>
            </div>

           <!--=================== Modal=========================== -->
          <div class="modal fade" id="addeditofferjobs" role="dialog">
            <div class="modal-dialog modal-lg" id="modaldialog">
            
              <!-- Modal content-->
            
              
            </div>
          </div>
          <!--=================== Modal=========================== -->
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include('includes/footer.php'); ?>
        <script type="text/javascript">


		       $("#addeditofferjobs").on("show.bs.modal",function(e){
		          var link =  $(e.relatedTarget);
		          $(this).find("#modaldialog").load(link.attr("href"));
		          
		        });
 

        	$(document).ready( function () {
			    $('#example').DataTable();

			} );
        	
        	/*jQuery(document).ready(function($){
			  $('#example').DataTable({
			    language: {
			      lengthMenu: "T'en veux _MENU_ par page",
			      info: "T'es bigleux ? c'est la page _PAGE_ sur _PAGES_",
			      search: "Cherche bouffon !",
			      paginate: {
			        first:      "Premier",
			        last:       "Précédent",
			        next:       "Suivant",
			        previous:   "Dernier"
			      }
			    }
			  });
			});*/
        </script>
        
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  
</body>

</html>

