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
                    <h2>Edit Data <small></small></h2>
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
                    <form id="data-form" data-parsley-validate class="form-horizontal form-label-left">
                      <?php
                        /* get data */
                        $data = [
                                    'fields' => ['id', 'title', 'body', 'enc_key','category_id'],
                                    'table' => 'data',
                                    'where' => ['id' => base64_decode($_GET['data'])],
                                    'where_type' => ['i'] 
                                ];
                        $d_data = get_single_row_data($data);
                        // prd($d_data);
                        echo csrf();
                      ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Title <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="title" required="required" class="form-control col-md-7 col-xs-12" name="title" value="<?php echo cryptoJsAesDecrypt($d_data["enc_key"], $d_data['title']); ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Body <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea name="body" class="form-control col-md-7 col-xs-12" id="body"><?php echo cryptoJsAesDecrypt($d_data["enc_key"], $d_data['body']); ?></textarea>
                        </div>
                      </div>
                      <input type="hidden" name="catgory_id" id="category-id" value="<?php echo base64_decode($_GET['data']);?>" />
                      
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

    <!-- CK editor -->
    <script src="//cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>

    <!-- Crypto js  -->
    <script src="vendors/cryptojs-aes-php-master/aes-json-format.js"></script>
    <script type="text/javascript" src="vendors/cryptojs-aes-php-master/example/aes.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    
    <script type="text/javascript">
      CKEDITOR.replace( 'body' );

      $('#data-form').on('submit', function(e){
          e.preventDefault();
          $('#data-title-err').remove();
          $('#data-body-err').remove();
          var title = $.trim($('#title').val());
          var body = CKEDITOR.instances['body'].getData();
          var category_id = $.trim($('#category-id').val());
          
          if(title.length > 0 && body.length > 0){
            var password_key = generatePassword(16);    
            var enc_title = CryptoJS.AES.encrypt(JSON.stringify(title), password_key, {format: CryptoJSAesJson}).toString();
            var enc_body = CryptoJS.AES.encrypt(JSON.stringify(body), password_key, {format: CryptoJSAesJson}).toString();
            
            $.post('action/data/edit_data.php',{title: enc_title, body:enc_body, category_id:category_id, k:password_key, token:$('#csrf-token').val(), id:'<?php echo base64_decode($_GET['data']); ?>'},function(resp){
              if(resp == true){
                alert('Data Added Successfully');
                window.location.href='list-data.php?data=<?php echo $d_data['category_id']; ?>';
              }
            });
          
          }else{
            if(title.length == 0){
              $('#title').after('<div id="title-err">Please Insert Title name</div>');
            }
            if(body.length == 0){
              $('#body').after('<div id="body-err">Please Insert body name</div>');
            }
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
