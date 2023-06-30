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
				  <a href="#default" class="logo">Car Type</a>
				  <div class="header-right">
				    <a class="dropdown-item preview-item active" href="<?php echo base_url('Super_admin/CarTypeController/addeditcartype');?>" role="button" data-toggle="modal" data-target="#addeditcartype" data-remote="false"><button type="button" class="btn btn-info font-weight-bold">+ Add Car Type</button></a>
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
				            	  <th>Icon</th>
				                <th>Car Type.</th>
				                <th>Seater Type</th>
				                <th>Luggages Count	</th>
				                <th>Staus</th>
				                <th>Action</th>
				            </tr>
				        </thead>
				        <tbody>
				        	<?php 
				        	  if(!empty($car_type)){
				        	  	foreach($car_type as $val){
				        	  		if($val->status==1){
                           $button_status = "success";
                           $status = "Active";
				        	  		}else{
                           $button_status = "warning";
                           $status = "InActive";
				        	  		}
				        	  		?>

				        	  		  <tr>
				        	  		    <td style="background-image:url(<?php echo base_url($val->car_icon); ?>);background-size: 153px 92px;height: 65px;width: 135px;"></td>
						                <td><?php echo $val->car_type; ?></td>
						                <td><?php echo $val->seater_type; ?></td>
						                <td><?php echo $val->luggages_count; ?></td>
						                <td><button type="button" class="btn btn-<?php echo $button_status; ?>"><?php echo $status; ?></button></td>
						                <td><a class="edit" title="Edit" href="<?php echo base_url('Super_admin/CarTypeController/addeditcartype/'.$val->id);?>" role="button" data-toggle="modal" data-target="#addeditcartype" data-remote="false"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                            <a class="delete" title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
						             </tr>
						            <?php
				        	  	}
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
          <div class="modal fade" id="addeditcartype" role="dialog">
            <div class="modal-dialog modal-md" id="modaldialog">
            
              <!-- Modal content-->
            
              
            </div>
          </div>
          <!--=================== Modal=========================== -->
          
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include('includes/footer.php'); ?>
        <script type="text/javascript">


		       $("#addeditcartype").on("show.bs.modal",function(e){
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

