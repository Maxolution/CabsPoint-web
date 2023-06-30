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
          <div class="row">
            <div class="col-sm-12 mb-4 mb-xl-0">
              <h4 class="font-weight-bold text-dark">Hi, welcome back!</h4>
              <p class="font-weight-normal mb-2 text-muted">APRIL 1, 2019</p>
            </div>
          </div>
         
          <div class="row">
            <div class="col-xl-12 grid-margin-lg-0 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Top Sellers</h4>
                    <div class="table-responsive mt-3">
                      <table class="table table-header-bg" id="allScholarshipResult">
                        <thead>
                          <tr>
                            <th>
                                Job Ref.
                            </th>
                            <th>
                                Client Info
                            </th>
                            <th>
                                Pick Up Time
                            </th>
                            <th>
                                Journey Details
                            </th>
                            <th>
                                Price(£)	
                            </th>
                            <th>
                                Operator	
                            </th>
                            <th>
                            	Status
                            </th>
                            <th>
                            	Transfer Action
                            </th>
                          </tr>
                        </thead>
                        
                      </table>
                    </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <?php include('includes/footer.php'); ?>
        <script type="text/javascript">
        	 $(document).ready(function() {
		       var url = '<?php echo base_url('Super_admin/dashboard/getdatalist');?>';
			   var pageNumber;
			   var pageSize;
			   var table =  $('#allScholarshipResult').DataTable({
		          "processing": true,
		          "serverSide": true,
		          "paging": true,
		          "searching": { "regex": true },
		          ajax: function ( data, callback, settings ) {

		               $.ajax({
		                    url: url,
		                    type: 'POST',
		                    data: {
		                         pageNumber: pageNumber,
		                         pageSize: pageSize
		                    },
		                    success: function( response, textStatus, jQxhr ){
		                         pageNumber = table.page.info().page;
		                         pageSize= table.page.info().length;
		                         console.log('Page Number '+pageNumber + ' Page Size ' + pageSize);
		                         callback({
		                              data: response.responseObject.data,
		                              recordsTotal:  response.responseObject.recordsTotal,
		                              recordsFiltered:  response.responseObject.recordsFiltered
		                         });
		                    },
		                    error: function( jqXhr, textStatus, errorThrown ){
		                    }
		               });
		          },
		          columns: [
		               { data: "id" },
		               { data: "examYear" },
		               { data: "scholarshipLevelId" },
		               { data: "candidateTotal" },
		               { data: "candidateBoy" },
		               { data: "candidateGirl" },
		            ]

		     });
		    } );
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

