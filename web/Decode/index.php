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

        var toReturn;
        var originalMessage;

        <?php
          require_once('../../scripts/Database.php');
          require_once('../../scripts/ManipulateText.php');

          //Creates a database object
          $database = new Database();
          $database -> connect();

          //Checks if the page form had been filled and submitted
          if(!empty($_POST['publicKey']) && !empty($_POST['privateKey']) && !empty($_POST['messageToDecode'])){
            //Checks that the given address and password match
            //Otherwise, a JavaScript variable is set to false so alternate JavaScript code will run after the given public and private keys don't match or exist
            try{
              $hashedPassword = $database -> select('SELECT privateKey FROM userKeys WHERE publicKey = ' . $database -> quote($_POST['publicKey']) . ';');
              if($hashedPassword !== false && !empty($hashedPassword)){
                $hashedPassword = $hashedPassword[0]['privateKey'];
                if(password_verify($_POST['privateKey'], $hashedPassword)){
                  //Updates the 'lastUsed' column of the database if the password and address were used and matched
                  $updatedTime = $database -> query('UPDATE userKeys SET lastUsed = NOW() WHERE publicKey = ' . $database -> quote($_POST['publicKey']) . ';');
                  //Attempts to decrypt the message
                  $decrypted = '';
                  $decrypted = decodeMessage($_POST['messageToDecode'], $hashedPassword);
                  echo 'toReturn = makeSafe(' . json_encode($decrypted) . ');';
                }else{
                  throw new Exception('Keys don\'t match', 1);
                }
              }else{
                throw new Exception('Key doesn\'t exist', 1);
              }
            }catch(Exception $e){
              echo 'toReturn = false;';
            }
            echo 'originalMessage = makeSafe(' . json_encode($_POST['messageToDecode']) . ');';
            //Clears entered data just in case
            $_POST = array();
          }
         ?>

         //Checks to see if the PHP sent the decoded message
         if(toReturn !== undefined && toReturn !== null){
           //Checks to see if the PHP query amounted to nothing in the case that the query was attempted
           if(toReturn == false){
             //Sends error message of invalid username and password
             document.getElementById('status').innerHTML = 'Invalid address, password, or message';
             document.getElementById('decrypted').innerHTML = toReturn;
             document.getElementById('input').innerHTML = originalMessage;
             console.log('Address and password didn\'t match');
           }else{
             //Sends decrypted message or error message
             document.getElementById('status').innerHTML = 'The message has been decoded';
             document.getElementById('decrypted').innerHTML = toReturn;
             console.log('Successfully decoded message');
           }
           $('#myModal').modal('show');
         }
      });
    </script>

  </head>

  <body>
    <div class = 'main'>

      <div class = 'masthead'>
        <a href = '..'><img src='../Masthead.png' class = 'fit rounded-img' id = 'bannerImg'/></a>
      </div>

      <br/>

      <div class = 'navbar fit navbar-light siteNav img-rounded'>
        <ul class = 'nav navbar-nav fit img-rounded specialBlue'>
          <li><a href = '..' class = 'linkGlyph'>Home</a></li>
          <li><a href = '../Generate_Key' class = 'linkGlyph'>Generate a Key</a></li>
          <li><a href = '../Encode' class = 'linkGlyph'>Encode a Message</a></li>
          <li class = 'active'><a href = '../Decode' class = 'linkGlyph'>Decode a Message</a></li>
        </ul>
      </div>

      <div class = 'container fit'>
        <div class = 'row vertical-align'>
          <div class = 'col-sm-12 specialBlue img-rounded'>
            <h3>Decode a Message</h3>
            <p>Here you can decode an encoded message. If the original message had non-ASCII characters, the characters won't decode correctly.</p>
            <p>To decode, you must enter the encoded message as well as the public and private keys for the message's intended recipient. If the public or private keys are wrong, the decoding process will either error, or it will return something random.</p>
            <p>The decoding process works by going the same processes as the encoding step, except doing the steps backwards while generating the same random numbers that would have been generated in encoding.</p>
          </div>
        </div>
        <br/>
        <div class = 'row vertical-align'>
          <div class = 'col-sm-12 specialBlue img-rounded fit'>
            <br/>
            <form method = 'post' action = '<?php echo $_SERVER['PHP_SELF']; ?>'>
              <p>Message to decode:</p>
              <textarea id = 'input' class = 'fit' rows = '15' name = 'messageToDecode'></textarea>
              <br/><br/>
              <p>Your public key: <br/> <input class = 'fit' type = 'text' name = 'publicKey'></p>
              <p>Your private key: <br/> <input class = 'fit' type ='password' name = 'privateKey'></p>
              <br/>
              <input class = 'fit' type = 'submit'>
            </form>
            <br/>
          </div>
        </div>
      </div>

      <div id = 'myModal' class = 'modal fade' role = 'dialog'>
        <div class = 'modal-dialog'>
          <div class = 'modal-content specialBlue'>

            <div class = 'modal-header'>
              <button type='button' class='close' data-dismiss='modal'>&times;</button>
              <h3 class='modal-title'>Decoded Message</h3>
            </div>
            <div class = 'modal-body'>
              <h4 id = 'status'></h4>
              <div id = 'decrypted' class = 'fit img-rounded outputs'></div>
              <br/>
              <button id = 'copy' type = 'button' class = 'btn btn-default btn-block btn-info'>Copy to clipboard</button>
            </div>
            <div class = 'modal-footer'>
              <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
            </div>

          </div>
        </div>
      </div>

      <div id = 'spacer'></div>
      <br/>

      <div class = 'container fit footerBox img-rounded'>
        <div class = 'row'>
          <div class = 'col-sm-3'>
            <a role = 'button' href = 'mailto:SaurabhTotey@gmail.com' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator Email</h5>
              <p>SaurabhTotey@gmail.com</p>
            </a>
          </div>
          <div class = 'col-sm-3'>
            <a role = 'button' href = 'https://github.com/SaurabhTotey' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator GitHub</h5>
              <p>SaurabhTotey</p>
            </a>
          </div>
          <div class = 'col-sm-3'>
            <a role = 'button' href = 'https://saurabhtotey.github.io/' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Creator Portfolio</h5>
              <p>saurabhtotey.github.io</p>
            </a>
          </div>
          <div class = 'col-sm-3'>
            <a role = 'button' href = '#' class = 'btn btn-block footBtn' target = '_blank'>
              <h5>Donate to Creator</h5>
              <p>Every penny helps!</p>
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
