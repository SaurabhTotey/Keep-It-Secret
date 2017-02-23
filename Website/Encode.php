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
          include "Database.php";
          include "ManipulateText.php";
          //Creates a database object
          $database = new Database();
          $database -> connect();
          //Checks if the page form had been filled and submitted
          if(!empty($_POST["recipientPublic"]) && !empty($_POST["messageToEncode"])){
            //Attempts to retrieve recipient's private key from their public key
            //The specified row's "lastUsed" column is then updated with a more recent time
            $privateKey = $database -> select("SELECT privateKey FROM userKeys WHERE publicKey = " . $database -> quote($_POST["recipientPublic"]) . ";")[0]["privateKey"];
            $updatedTime = $database -> query("UPDATE userKeys SET lastUsed = NOW() WHERE publicKey = " . $database -> quote($_POST["recipientPublic"]));
            //Sets the "toReturn" variable to the encoded message unless the main query fails
            if($privateKey === false){
              echo "toReturn = false;";
            }else{
              echo "toReturn = \"" . encodeMessage($_POST["messageToEncode"], $privateKey) . "\";";
            }
            //Clears entered data so that reloads don't unecessarily trigger modals
            $_POST = array();
          }
        ?>

        //Checks to see if the PHP sent the encoded message
        if(toReturn !== undefined && toReturn !== null){
          //Checks to see if the PHP query amounted to nothing in the case that the query was attempted
          if(toReturn = false){
            console.log("Could not find public key");
            //TODO send up modal with error message
          }else{
            //Displays the encoded message
            console.log("Successfully found public/private key pair and encoded message");
            //TODO send up modal with toReturn displayed
          }
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
          <li><a href = "index.html" class = "linkGlyph">Home</a></li>
          <li><a href="NewKey.php" class = "linkGlyph">Generate a Key</a></li>
          <li class = "active"><a href="Encode.php" class = "linkGlyph">Encode a Message</a></li>
          <li><a href="Decode.php" class = "linkGlyph">Decode a Message</a></li>
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
            <h3>Encode a message</h3>
            <p>Here you can encode a message.</p>
            <p>To encode a message, write your message and the recipient's address or public key below. An encoded version of the message will be returned.</p>
            <p>Once your message is encoded, you will need to send the encoded version yourself to the recipient; however, you won't need to worry about your original message being read.</p>
            <p>The encoding process involves a message going through many different phases to make it unreadable. The first step taken is that the recipient's private key is found out from their public key. The user's private key is then used as the random number generator's (RNG's) seed. Then, the message gets <a href = "https://en.wikipedia.org/wiki/Caesar_cipher">Caeser Ciphered</a> with each shift amount being a random number for each letter. Then, each letter of the message gets shuffled. Afterwards, random letters are inserted in the message. Finally, the message's length and the recipient's public key are inserted into the message to be used for decrypting it.</p>
          </div>
        </div>
        <br/>
        <div class = "row vertical-align">
          <div class = "col-sm-12 specialBlue img-rounded">
            <br/>
            <form method = "post" action = "Encode.php">
              <p>Message to encode:</p>
              <textarea class = "fit" rows = "15" name = "messageToEncode"></textarea>
              <br/><br/>
              <p>Recipient's public key:</p>
              <input class = "fit" type = "text" name = "recipientPublic">
              <br/><br/><br/>
              <input class = "fit" type = "submit">
            </form>
            <br/>
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
              <h5>Creator Github</h5>
              <p>SaurabhTotey</p>
            </a>
          </div>
          <div class = "col-sm-3">
            <a role = "button" href = "#" class = "btn btn-block footBtn">
              <h5>Creator Portfolio</h5>
              <p>Ideally would be SaurabhTotey.com</p>
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
