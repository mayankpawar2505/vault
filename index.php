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
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form>
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control login-input-form" placeholder="Username" id="password1" required="" />
                <img id="password-opener1" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="password" class="form-control login-input-form" placeholder="Password" id="password" required="" />
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
            <form method="post" action="javascript:void(0);" name="registration_form" id="registration-form">
              <h1>Create Account</h1>
              <div>
                <input type="text" name="username" id="reg-username" class="form-control" placeholder="Username" />
                <img id="reg-username-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="email" name="email" id="reg-email" class="form-control" placeholder="Email"/>
                <img id="reg-email-opener" class="tooltip-tipsy" title="Click to open the virtual keyboard" src="vendors/Keyboard-master/css/images/keyboard.svg">
              </div>
              <div>
                <input type="text" name="password" id="reg-password" class="form-control" placeholder="Password" />
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
    <script src="vault/vendors/validator/validator.js"></script>
    <script type="text/javascript">
      $('#password')
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

        $('#password1')
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
        var kb = $('#password').getkeyboard();
        // close the keyboard if the keyboard is visible and the button is clicked a second time
        if ( kb.isOpen ) {
          kb.close();
        } else {
          kb.reveal();
        }
      });
      $('#password-opener1').click(function(){
        var kb = $('#password1').getkeyboard();
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

      $('#registration-form').on('submit',function(e){
          e.preventDefault();
          alert('here');

          var password  = $('#reg-password').val();
          var username  = $('#reg-username').val();
          var email     = $('#reg-email').val();

          var password_key = generatePassword(11);
          var password_iv = generatePassword(10);

          var key = CryptoJS.enc.Base64.parse(password_key);
          var iv  = CryptoJS.enc.Base64.parse(password_iv);

          var encrypted = CryptoJS.AES.encrypt(password, key, {iv: iv});
          $(this).val(encrypted);
          console.log(encrypted.toString());

          /*var decrypted = CryptoJS.AES.decrypt(encrypted, key, {iv: iv});
          console.log(decrypted.toString(CryptoJS.enc.Utf8));*/
      });
    </script>

  </body>
</html>
