<!DOCTYPE HTML>
<html>

  <head>

    <meta charset = "utf-8">

    <link rel = "icon" href="images/icon.png"/>
    <title>Keep it Secret</title>

    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel = "stylesheet" href = "AllPage.css"/>

    <script>
      $(document).ready(function(){
        var toReturn;

        <?php
          include "../../scripts/Database.php";
          include "../../scripts/ManipulateText.php";

          //Creates a database object
          $database = new Database();
          $database -> connect();
          //Checks if the page form had been filled and submitted
          if(!empty($_POST["publicKey"]) && !empty($_POST["privateKey"]) && !empty($_POST["messageToDecode"])){
            //Checks that the given address and password match
            $hashedPassword = $database -> select("SELECT privateKey FROM userKeys WHERE publicKey = " . $database -> quote($_POST["publicKey"]) . ";")[0]["privateKey"];
            if(password_verify($_POST["privateKey"], $hashedPassword)){
              //Updates the "lastUsed" column of the database if the password and address were used and matched
              $updatedTime = $database -> query("UPDATE userKeys SET lastUsed = NOW() WHERE publicKey = " . $database -> quote($_POST["publicKey"]));
              //Attempts to decrypt the message
              $decrypted = "";
              try{
                $decrypted = decodeMessage($_POST["messageToDecode"], $hashedPassword);
              }catch(Exception $e){
                $decrypted = $e -> getMessage();
              }
              echo "toReturn = \"" . $decrypted . "\";";
            }else{
              echo "toReturn = false;";
            }
            //Clears entered data so that page reloads don't unecessarily trigger modals
            $_POST = array();
          }
         ?>

         //Checks to see if the PHP sent the decoded message
         if(toReturn !== undefined && toReturn !== null){
           //Checks to see if the PHP query amounted to nothing in the case that the query was attempted
           if(toReturn == false){
             //Sends error message of invalid username and password
             document.getElementById("status").innerHTML = "Invalid address and/or password";
             document.getElementById("encrypted").innerHTML = toReturn;
             console.log("Address and password didn't match");
           }else{
             //Sends decrypted message or error message
             document.getElementById("status").innerHTML = "The message was decoded with the given address/password combination";
             document.getElementById("encrypted").innerHTML = toReturn;
             console.log("Successfully decoded message");
           }
           $("#myModal").modal("show");
         }
      });
    </script>

  </head>

  <body>
    <div class = "main">

      <div class = "masthead">
        <a href = "index.html"><img src="images/Masthead.png" class = "fit rounded-img" id = "bannerImg"/></a>
      </div>

      <br/>

      <div class = "navbar fit navbar-light siteNav img-rounded">
        <ul class = "nav navbar-nav fit img-rounded specialBlue">
          <li><a href = "../index.html" class = "linkGlyph">Home</a></li>
          <li><a href = "../Generate_Key/index.php" class = "linkGlyph">Generate a Key</a></li>
          <li><a href = "../Encode/index.php" class = "linkGlyph">Encode a Message</a></li>
          <li class = "active"><a href = "index.php" class = "linkGlyph">Decode a Message</a></li>
        </ul>
      </div>

      <script>
        $(document).ready(function(){
          document.getElementsByClassName("siteNav")[0].style.marginTop = document.getElementById("bannerImg").height + "px";
        });
      </script>

      <div class = "container fit">
        <div class = "row vertical-align">
          <div class = "col-sm-12 specialBlue img-rounded">
            <h3>Decode a message</h3>
            <p>Here you can decode an encoded message.</p>
            <p>To decode, you must enter the encoded message as well as the public and private keys for the intended recipient. If the public or private keys are wrong, the decoding process will either error, or it will return something random.</p>
            <p>The decoding process works by going the same processes as the encoding step, except doing the steps backwards while generating the same random numbers that would have been generated in encoding.</p>
          </div>
        </div>
        <div class = "row vertical-align">
          <div class = "col-sm-12 specialBlue img-rounded">
            <form method = "post" action = "index.php">
              <p>Message to decode:</p>
              <textarea class = "fit" rows = "15" name = "messageToDecode"></textarea>
              <br/><br/>
              <p>Your public key:</p>
              <input class = "fit" type = "text" name = "publicKey">
              <p>Your private key:</p>
              <input class = "fit" type ="password" name = "privateKey">
              <br/><br/><br/>
              <input class = "fit" type = "submit">
            </form>
          </div>
        </div>
      </div>

      <div id = "myModal" class = "modal fade" role = "dialog">
        <div class = "modal-dialog">
          <div class = "modal-content img-rounded">

            <div class = "modal-header specialBlue">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title">Decoded Message</h3>
            </div>
            <div class = "modal-body">
              <h3 id = "status"></h3>
              <p id = "decrypted"></p>
            </div>
            <div class = "modal-footer specialBlue">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

          </div>
        </div>
      </div>

      <br/>

      <div class = "container fit footerBox img-rounded">
        <div class = "row">
          <div class = "col-sm-3">
            <a role = "button" href = "mailto:SaurabhTotey@gmail.com" class = "btn btn-block footBtn">
              <h5>Creator Email</h5>
              <p>SaurabhTotey@gmail.com</p>
            </a>
          </div>
          <div class = "col-sm-3">
            <a role = "button" href = "https://github.com/SaurabhTotey" class = "btn btn-block footBtn">
              <h5>Creator GitHub</h5>
              <p>SaurabhTotey</p>
            </a>
          </div>
          <div class = "col-sm-3">
            <a role = "button" href = "https://saurabhtotey.github.io/" class = "btn btn-block footBtn">
              <h5>Creator Portfolio</h5>
              <p>saurabhtotey.github.io</p>
            </a>
          </div>
          <div class = "col-sm-3">
            <a role = "button" href = "#" class = "btn btn-block footBtn">
              <h5>Donate to Creator</h5>
              <p>Every penny helps!</p>
            </a>
          </div>
        </div>
        <br/>
        <div class = "row col-sm-12">
          <p>Page designed by Saurabh Totey. Images created by Elia Gorokhovsky. Code written by Saurabh Totey. Made in February, 2016. Inspired by our original "<a href = "http://www.codeskulptor.org/#user40_fVbe7V0msMMBR45.py">Code Talker Script</a>" and also inspired by the <a href = "http://www.moserware.com/2009/09/stick-figure-guide-to-advanced.html">"Stick Figure Guide to the Advanced Encryption Standard (AES)" by Moserware"</a>.</p>
        </div>
      </div>

    </div>
  </body>

</html>
