<?php
  include_once('layouts/header.php');
  include_once('action/functions.php');
  include_once('action/config.php');
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
                    <h2>Edit Category <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li> -->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="category-form" data-parsley-validate class="form-horizontal form-label-left">
                      <?php 
                        echo csrf();

                        /* get data */
                        $data = [
                                    'fields' => ['id', 'category_name', 'enc_key'],
                                    'table' => 'categories',
                                    'where' => ['user_id' => $_SESSION['id'], 'id' => base64_decode($_GET['data'])],
                                    'where_type' => ['i','i'] 
                                ];
                        $category_data = get_single_row_data($data);
                      ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="category-name" required="required" class="form-control col-md-7 col-xs-12" name="category_name" value="<?php echo cryptoJsAesDecrypt($category_data["enc_key"], $category_data['category_name']); ?> ">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button class="btn btn-primary" type="button">Cancel</button>
                          <button class="btn btn-primary" type="reset">Reset</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>      
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

    <!-- Crypto js  -->
    <script src="vendors/cryptojs-aes-php-master/aes-json-format.js"></script>
    <script type="text/javascript" src="vendors/cryptojs-aes-php-master/example/aes.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    
    <script type="text/javascript">
      $('#category-form').on('submit', function(e){
          e.preventDefault();
          $('#category-err').remove();
          var category_name = $.trim($('#category-name').val());
          if(category_name.length > 0){
            var password_key = generatePassword(16);    
            var enc_category_name = CryptoJS.AES.encrypt(JSON.stringify(category_name), password_key, {format: CryptoJSAesJson}).toString();
            
            $.post('action/categories/add_category.php',{category_name: enc_category_name, k:password_key, token:$('#csrf-token').val()},function(resp){
              if(resp > 0){
                alert('Category Updated Successfully');
                window.location.href='dashboard.php';
              }
            });
          
          }else{
            $('#category-name').after('<div id="category-err">Please Insert Category name</div>');
            return false;
          }

      });

      function generatePassword(len, charSet){
          charSet = charSet || '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@-';
          var randomString = '';
          for (var i = 0; i < len; i++) {
              var randomPoz = Math.floor(Math.random() * charSet.length);
              randomString += charSet.substring(randomPoz,randomPoz+1);
          }
          return randomString;
      }
    </script>
  </body>
</html>
