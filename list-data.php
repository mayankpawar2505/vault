<?php
  include_once('layouts/header.php');
  include_once('action/functions.php');
  include_once('vendors/cryptojs-aes-php-master/cryptojs-aes.php');
?>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php
            include_once('layouts/side_bar.php')
        ?>

        <!-- top navigation -->
        <?php
          include_once('layouts/top_nav.php');
        ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Data <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="add-data.php?data=<?php echo $_GET['data'] ?>">Add Data</a>
                          </li>
                          <!-- <li><a href="#">Settings 2</a>
                          </li> -->
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Data
                      <span class="pull-right"> <a class="btn btn-sm btn-default" href="add-data.php?data=<?php echo $_GET['data'] ?>"><span class="fa fa-plus"></span> Add  Data</a></span>
                      <?php  
                        if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                      ?>
                          <small><?php echo $_SESSION['error']; ?></small>
                      <?php
                          unset($_SESSION['error']);
                        }
                      ?>
                    </p>

                    <?php
                      /* Get all categories of logged in users */
                      $data = [
                                'fields' => ['id', 'category_id', 'title', 'body', 'enc_key'],
                                'table' => 'data',
                                'where' => ['category_id' => base64_decode($_GET['data'])],
                                'where_type' => ['i'],
                                'order' => 'title ASC'  
                            ];
                      $records = get_multiple_row_data($data);
                    ?>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S. No.</th>
                          <th>Title</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          if( !empty($records) && count($records) > 0){
                            foreach ($records as $key => $data) {
                        ?>
                              <tr>
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo cryptoJsAesDecrypt($data["enc_key"], $data['title']); ?></td>
                                <td>
                                    <a href="edit-data.php?data=<?php echo base64_encode($data['id']) ?>" class="btn btn-xs btn-warning" title="Edit Data"><i class="fa fa-pencil"></i></a> 
                                    <a href="delete-data.php?data=<?php echo base64_encode($data['id']) ?>" class="btn btn-xs btn-danger" title="Delete Data" onclick="return confirm('Are you sure you want to delete this Data ?')"><i class="fa fa-trash"></i></a> 
                                </td>
                              </tr>
                        <?php
                            }
                          }else{
                            echo '<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No matching records found</td></tr>';
                          }
                        ?>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
         <br />

          </div>


        </div>
        <!-- /page content -->

        <!-- footer content -->
        <?php
          include_once('layouts/footer.php');
        ?>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>

    <!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	
  </body>
</html>
