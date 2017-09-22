<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Vault</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <link href="build/css/login-style.css" rel="stylesheet">

    <!-- still using jQuery v2.2.4 because Bootstrap doesn't support v3+ -->
    <script src="vendors/Keyboard-master/docs/js/jquery-latest.min.js"></script>
    <script src="vendors/Keyboard-master/docs/js/jquery-ui.min.js"></script>
    <!--  Virtual keyboard  -->
    <!-- keyboard widget css & script (required) -->
    <link href="vendors/Keyboard-master/css/keyboard.css" rel="stylesheet">
    <script src="vendors/Keyboard-master/js/jquery.keyboard.js"></script>

    <!-- keyboard extensions (optional) -->
    <script src="vendors/Keyboard-master/js/jquery.mousewheel.js"></script>
    <script src="vendors/Keyboard-master/js/jquery.keyboard.extension-typing.js"></script>
    <script src="vendors/Keyboard-master/js/jquery.keyboard.extension-autocomplete.js"></script>
    <script src="vendors/Keyboard-master/js/jquery.keyboard.extension-caret.js"></script>

  </head>

  <body class="login">
    <!-- Loader -->
    <div class="loading">Loading&#8230;</div>

    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" name="login_form" id="login-form">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control login-input-form" placeholder="Username" id="login-username" required="" />
                <img id="password-opener1" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="password" class="form-control login-input-form" placeholder="Password" id="login-password" required="" />
                <img id="password-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Log in</a>
                <a class="reset_pass" href="#">Lost your password?</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">New to site?
                  <a href="#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-truck"></i> My Vault</h1>
                  <p>&copy; <?php echo date('Y'); ?> All Rights Reserved My Vault. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="POST" name="registration_form" id="registration-form" >
              <h1>Create Account</h1>
              <div>
                <input type="text" name="username" id="reg-username" class="form-control" placeholder="Username" required="required" data-validate-length-range="6" data-validate-words="2" />
                <img id="reg-username-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="email" name="email" id="reg-email" class="form-control" placeholder="Email" required="required"/>
                <img id="reg-email-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="password" name="password" id="reg-password" class="form-control" placeholder="Password" required="required"/>
                <img id="reg-password-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <button type="submit" class="btn btn-default submit">Submit</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-truck"></i> My Vault</h1>
                  <p>&copy; <?php echo date('Y'); ?> All Rights Reserved My Vault. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <script src="vendors/CryptoJS-master/rollups/aes.js"></script>
    <script src="vendors/CryptoJS-master/components/enc-base64-min.js"></script>

    <script type="text/javascript">
      $('#login-password')
        .keyboard({
          openOn : null,
          stayOpen : true,
          layout : 'qwerty'
          /*layout: 'custom',
          customLayout: {
            'normal': [
              '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
              '{tab} q w e r t y u i o p [ ] \\',
              'a s d f g h j k l ; \' {enter}',
              '{shift} z x c v b n m , . / {shift}',
              '{accept} {space} {left} {right}'
            ],
            'shift': [
              '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
              '{tab} Q W E R T Y U I O P { } |',
              'A S D F G H J K L : " {enter}',
              '{shift} Z X C V B N M &lt; &gt; ? {shift}',
              '{accept} {space} {left} {right}'
            ]
          }*/
        })
        .addTyping();

        $('#reg-username')
        .keyboard({
          openOn : null,
          stayOpen : true,
          layout : 'qwerty'
          /*layout: 'custom',
          customLayout: {
            'normal': [
              '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
              '{tab} q w e r t y u i o p [ ] \\',
              'a s d f g h j k l ; \' {enter}',
              '{shift} z x c v b n m , . / {shift}',
              '{accept} {space} {left} {right}'
            ],
            'shift': [
              '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
              '{tab} Q W E R T Y U I O P { } |',
              'A S D F G H J K L : " {enter}',
              '{shift} Z X C V B N M &lt; &gt; ? {shift}',
              '{accept} {space} {left} {right}'
            ]
          }*/
        })
        .addTyping();

        $('#reg-email')
        .keyboard({
          openOn : null,
          stayOpen : true,
          layout : 'qwerty'
          /*layout: 'custom',
          customLayout: {
            'normal': [
              '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
              '{tab} q w e r t y u i o p [ ] \\',
              'a s d f g h j k l ; \' {enter}',
              '{shift} z x c v b n m , . / {shift}',
              '{accept} {space} {left} {right}'
            ],
            'shift': [
              '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
              '{tab} Q W E R T Y U I O P { } |',
              'A S D F G H J K L : " {enter}',
              '{shift} Z X C V B N M &lt; &gt; ? {shift}',
              '{accept} {space} {left} {right}'
            ]
          }*/
        })
        .addTyping();

        $('#reg-password')
        .keyboard({
          openOn : null,
          stayOpen : true,
          layout : 'qwerty'
          /*layout: 'custom',
          customLayout: {
            'normal': [
              '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
              '{tab} q w e r t y u i o p [ ] \\',
              'a s d f g h j k l ; \' {enter}',
              '{shift} z x c v b n m , . / {shift}',
              '{accept} {space} {left} {right}'
            ],
            'shift': [
              '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
              '{tab} Q W E R T Y U I O P { } |',
              'A S D F G H J K L : " {enter}',
              '{shift} Z X C V B N M &lt; &gt; ? {shift}',
              '{accept} {space} {left} {right}'
            ]
          }*/
        })
        .addTyping();

        $('#login-username')
        .keyboard({
          openOn : null,
          stayOpen : true,
          layout : 'qwerty'
          /*layout: 'custom',
          customLayout: {
            'normal': [
              '` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
              '{tab} q w e r t y u i o p [ ] \\',
              'a s d f g h j k l ; \' {enter}',
              '{shift} z x c v b n m , . / {shift}',
              '{accept} {space} {left} {right}'
            ],
            'shift': [
              '~ ! @ # $ % ^ & * ( ) _ + {bksp}',
              '{tab} Q W E R T Y U I O P { } |',
              'A S D F G H J K L : " {enter}',
              '{shift} Z X C V B N M &lt; &gt; ? {shift}',
              '{accept} {space} {left} {right}'
            ]
          }*/
        })
        .addTyping();

      $('#password-opener').click(function(){
        var kb = $('#login-password').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });
      $('#password-opener1').click(function(){
        var kb = $('#login-username').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });

      $('#reg-email-opener').click(function(){
        var kb = $('#reg-email').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });

      $('#reg-username-opener').click(function(){
        var kb = $('#reg-username').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });

      $('#reg-password-opener').click(function(){
        var kb = $('#reg-password').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });

      $('#reg-password').on('focusout',function(){
          

      });
      function generatePassword(len, charSet){
          charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!';
          var randomString = '';
          for (var i = 0; i < len; i++) {
              var randomPoz = Math.floor(Math.random() * charSet.length);
              randomString += charSet.substring(randomPoz,randomPoz+1);
          }
          return randomString;
      }

      /* Register user */
      $('#registration-form').submit(function(e){
          e.preventDefault();
          
          /* Validations */
          var password  = $.trim($('#reg-password').val());
          var username  = $.trim($('#reg-username').val());
          var email     = $.trim($('#reg-email').val());
          var is_valid  = new Array();

          var password_result = /^[A-Za-z0-9\d=!\-@._*]*$/.test(password) // consists of only these
                                && /[a-z]/.test(password) // has a lowercase letter
                                && /\d/.test(password) // has a digit
                                && password.length >= 8;
          
          $('#reg-password-err').remove();
          $('#reg-username-err').remove();
          $('#reg-email-err').remove();

          if(password_result){
            is_valid.push("true");
          }else{
            is_valid.push("false");
            $('#reg-password-opener').after('<div id="reg-password-err">Invalid Password! Password consists of alphanumeric character with <b>-@._*</b> special characters</div>');
          }

          if(username.length >= 3){
            /* Check username is unique */
            $.post('action/users/user_checker.php',{username:username, token:'verify_username'}, function(resp){
              if(resp == "false"){
                $('#reg-username-opener').after('<div id="reg-username-err">Username Alredy Exists. Please choose another!</div>');
                is_valid.push("false");
              }
            });
            
            is_valid.push("true");
          }else{
            is_valid.push("false");
            $('#reg-username-opener').after('<div id="reg-username-err">Username must be greater than 3 characters</div>');
          }

          var email_pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\u.36FDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
          var email_verify = email_pattern.test(email);

          if(email_verify){
            is_valid.push("true");

            /* Check unique email id */
            $.post('action/users/user_checker.php',{email:email, token:'verify_email'}, function(resp){
              if(resp == "false"){
                $('#reg-email-opener').after('<div id="reg-email-err">Email already present. Please login!</div>');
                is_valid.push("false");
              }
            });

          }else{
            is_valid.push("false");
            $('#reg-email-opener').after('<div id="reg-email-err">Email is Invalid</div>');
          }

          setTimeout(function(){
            $('.loading').show();

            if($.inArray("false",is_valid) > -1){
              $('.loading').hide();
              return false;
            }else{

                /* Submit form */
                var password_key = generatePassword(11);
                var password_iv = generatePassword(10);

                var key = CryptoJS.enc.Base64.parse(password_key);
                var iv  = CryptoJS.enc.Base64.parse(password_iv);

                var encrypted = CryptoJS.AES.encrypt(password, key, {iv: iv}).toString();
                var epassword = encrypted;

                $.post('action/users/user_checker.php',{username:username, email:email,  password:epassword, key: password_key, iv:password_iv, token:'user_register'}, function(resp){
                  if(resp > 0){
                    alert('You have successfully registered. Please Login');
                    window.location.href = 'index.php';
                  }
                });

                $('.loading').hide();


                // var decrypted = CryptoJS.AES.decrypt(encrypted, key, {iv: iv});
                // console.log(decrypted.toString(CryptoJS.enc.Utf8));
            }
          }, 3000);
      });

      /* Login user */
      $('#login-form').submit(function(e){
          e.preventDefault();
          
          /* Validations */
          var password  = $.trim($('#login-password').val());
          var username  = $.trim($('#login-username').val());
          var is_valid  = new Array();

          var password_result = /^[A-Za-z0-9\d=!\-@._*]*$/.test(password) // consists of only these
                                && /[a-z]/.test(password) // has a lowercase letter
                                && /\d/.test(password) // has a digit
                                && password.length >= 8;
          
          $('#login-password-err').remove();
          $('#login-username-err').remove();
         
          if(password_result){
            is_valid.push("true");
          }else{
            is_valid.push("false");
            $('#password-opener').after('<div id="login-password-err">Invalid Password! Password consists of alphanumeric character with <b>-@._*</b> special characters</div>');
          }

          if(username.length >= 3){
            is_valid.push("true");
          }else{
            is_valid.push("false");
            $('#reg-username-opener').after('<div id="login-username-err">Username must be greater than 3 characters</div>');
          }

            $('.loading').show();

            if($.inArray("false",is_valid) > -1){
              $('.loading').hide();
              return false;
            }else{

                /* Submit form */
                var password_key = generatePassword(11);
                var password_iv = generatePassword(10);

                var key = CryptoJS.enc.Base64.parse(password_key);
                var iv  = CryptoJS.enc.Base64.parse(password_iv);

                var encrypted = CryptoJS.AES.encrypt(password, key, {iv: iv}).toString();
                var epassword = encrypted;

                $.post('action/users/user_checker.php',{username:username, email:email,  password:epassword, key: password_key, iv:password_iv, token:'user_login'}, function(resp){
                  if(resp > 0){
                    alert('You have successfully registered. Please Login');
                    // window.location.href = 'index.php';
                  }
                });

                $('.loading').hide();


                // var decrypted = CryptoJS.AES.decrypt(encrypted, key, {iv: iv});
                // console.log(decrypted.toString(CryptoJS.enc.Utf8));
            }
      });
    </script>

  </body>
</html>
