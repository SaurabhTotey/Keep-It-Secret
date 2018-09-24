<!DOCTYPE HTML>
<html>

  <head>

    <meta charset = 'utf-8'>

    <link rel = 'icon' href='../icon.png'/>
    <title>Keep it Secret</title>

    <script src = 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
    <link rel = 'stylesheet' href = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'/>
    <script src = 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>

    <link rel = 'stylesheet' href = '../AllPage.css'/>
    <script src = '../SharedScripts.js'></script>

    <script>
      $(document).ready(function(){

        <?php
          require_once('../../scripts/Database.php');

          //Constructs a database object
          $database = new Database();
          $database -> connect();

          //Checks if the page form had been filled and submitted
          if(!empty($_POST['publicKey']) && !empty($_POST['privateKey']) && !empty($_POST['confirmPrivate'])){
            //Attempts to insert user's keys into the database if the keys match
            if(strcmp($_POST['privateKey'], $_POST['confirmPrivate']) == 0){
              $result = $database -> query('INSERT INTO userKeys (publicKey, privateKey, forceExpire) VALUES (' . $database -> quote($_POST['publicKey']) . ', ' . $database -> quote(password_hash($_POST['privateKey'], PASSWORD_BCRYPT)) . ',' . (isset($_POST['forcedExpiration'])? 'TRUE' : 'FALSE') . ');');
            }else{
              $result = false;
            }
            //Sends out a notification saying whether the key insertion had been successful
            if($result){
              echo 'console.log(\'Successfully inserted keys into database\'); document.getElementById(\'keyAlert\').className = \'alert alert-success\'; document.getElementById(\'keyAlert\').innerHTML = \'Your keys have been generated!\';';
            }else{
              echo 'console.log(\'Could not insert keys into database\'); document.getElementById(\'keyAlert\').className = \'alert alert-danger\'; document.getElementById(\'keyAlert\').innerHTML = \'Address was already taken or private keys don\'t match. Try checking your connection, changing your public key, and checking your private keys.\';';
            }

            //Clears entered information so that future reloads don't try and re-insert keys and send an error notification
            $_POST = array();
          }
        ?>

      });
    </script>

  </head>

  <body>
    <div class = 'main'>

      <div class = 'masthead'>
        <a href = 'https://keep-it-secret.herokuapp.com/'><img src='../Masthead.png' class = 'fit rounded-img' id = 'bannerImg'/></a>
      </div>

      <br/>

      <div class = 'navbar fit navbar-light siteNav img-rounded'>
        <ul class = 'nav navbar-nav fit img-rounded specialBlue'>
          <li><a href = 'https://keep-it-secret.herokuapp.com/' class = 'linkGlyph'>Home</a></li>
          <li class = 'active'><a href='https://keep-it-secret.herokuapp.com/Generate_Key' class = 'linkGlyph'>Generate a Key</a></li>
          <li><a href = 'https://keep-it-secret.herokuapp.com/Encode' class = 'linkGlyph'>Encode a Message</a></li>
          <li><a href = 'https://keep-it-secret.herokuapp.com/Decode' class = 'linkGlyph'>Decode a Message</a></li>
        </ul>
      </div>

      <div class = 'container fit'>

        <div class = 'row vertical-align'>
          <div class = 'col-sm-12 specialBlue img-rounded'>
            <h3>Generate a Key</h3>
            <p>Here, you can generate yourself a private key (password) and a public key (address). The public and private keys can be any set of ASCII characters.</p>
            <p>To use the public key (address), just give it to anyone who may want to write you a message. When they write you a message, they need to input your public key (address). To decode the message, you take the message and input your private key (password). The original message will be displayed back.</p>
            <p>When you generate a private key (password), make sure you keep it secret. This software is only as strong as your private key (password). If someone can guess your private key, they can decrypt messages meant for only you. If you want a group to be able to decode messages, make a shared set of keys for the group.</p>
            <p>A forced expiration key is extra secure. Normally, keys get deleted within a week of disuse; however, with a forced expiration key, the key will get deleted within a day, no matter how much it was used.</p>
          </div>
        </div>

        <br/>

        <div class = 'row vertical-align'>
          <button type = 'button' class = 'btn btn-lg specialBlue btn-block genKey' data-toggle = 'modal' data-target = '#myModal'>Generate Keys</button>
        </div>

      </div>

      <div id = 'myModal' class = 'modal fade' role = 'dialog'>
        <div class = 'modal-dialog'>
          <div class = 'modal-content specialBlue'>

            <div class = 'modal-header'>
              <button type='button' class='close' data-dismiss='modal'>&times;</button>
              <h3 class='modal-title'>Generate Keys</h3>
            </div>
            <div class = 'modal-body'>
              <form method = 'post' action = '<?php echo $_SERVER['PHP_SELF']; ?>'>
                <p class = 'fit'>Public Key (Address): <br/> <input type = 'text' name = 'publicKey' value = '' class = 'fit'></p>
                <p class = 'fit'>Private Key (Password): <br/> <input type = 'password' name = 'privateKey' value = '' class = 'fit'></p>
                <p class = 'fit'>Confirm Private Key (Password): <br/> <input type = 'password' name = 'confirmPrivate' value = '' class = 'fit'></p>
                <p class = 'fit'>Force Expire? <input type = 'checkbox' name = 'forcedExpiration'></p>
                <input type = 'submit' class = 'fit submit'>
              </form>
            </div>
            <div class = 'modal-footer'>
              <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
            </div>

          </div>
        </div>
      </div>

      <br/>

      <div id = 'keyAlert' class = 'fit alert'>
      </div>

      <div id = 'spacer'></div>
      <br/>

      <div class = 'container fit footerBox img-rounded'>
        <div class = 'row'>
          <div class = 'col-sm-4'>
            <a role = 'button' href = 'mailto:SaurabhTotey@gmail.com' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator Email</h5>
              <p>SaurabhTotey@gmail.com</p>
            </a>
          </div>
          <div class = 'col-sm-4'>
            <a role = 'button' href = 'https://github.com/SaurabhTotey' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator GitHub</h5>
              <p>SaurabhTotey</p>
            </a>
          </div>
          <div class = 'col-sm-4'>
            <a role = 'button' href = 'http://www.SaurabhTotey.com' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator Portfolio</h5>
              <p>www.SaurabhTotey.com</p>
            </a>
          </div>
        </div>
        <br/>
        <div class = 'row col-sm-12'>
          <p>Page design and code by Saurabh Totey. Made in February, 2017. Inspired by our original '<a href = 'http://www.codeskulptor.org/#user40_fVbe7V0msMMBR45.py' target = '_blank'>Code Talker Script</a>' and also inspired by the <a href = 'http://www.moserware.com/2009/09/stick-figure-guide-to-advanced.html' target = '_blank'>'Stick Figure Guide to the Advanced Encryption Standard (AES)' by Moserware'</a>.</p>
        </div>
      </div>

    </div>
  </body>

</html>
