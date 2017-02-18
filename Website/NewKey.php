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
      $(document).ready(function(){<?php
        include "Database.php";

        $database = new Database();
        $database -> connect();

        if(!empty($_POST["publicKey"]) && !empty($_POST["privateKey"])){

          $result = $database -> query("INSERT INTO userKeys (publicKey, privateKey, forceExpire) VALUES (" . $database -> quote($_POST["publicKey"]) . ", " . $database -> quote($_POST["privateKey"]) . ", 0);");
          if($result){
            echo "console.log(\"Successfully inserted keys into database\"); document.getElementById(\"keyAlert\").className = \"alert alert-dismissable alert-success\"; document.getElementById(\"keyAlert\").innerHTML = \"<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Your keys have been generated!\";";
          }else{
            echo "console.log(\"Could not insert keys into database\"); document.getElementById(\"keyAlert\").className = \"alert alert-dismissable alert-danger\"; document.getElementById(\"keyAlert\").innerHTML = \"<a href= '#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Cannot connect to database or address was already taken. Try checking your connection or changing your address.\";";
          }

          $_POST = array();
        }
      ?>});
    </script>

  </head>

  <body>
    <div class = "main">

      <div class = "masthead">
        <a href = "Home.html"><img src="images/Masthead.png" class = "fit rounded-img" id = "bannerImg"/></a>
      </div>

      <br/>

      <div class = "navbar fit navbar-light siteNav img-rounded">
        <ul class = "nav navbar-nav fit img-rounded specialBlue">
          <li class = "active"><a href = "Home.html" class = "linkGlyph">Home</a></li>
          <li><a href="NewKey.php" class = "linkGlyph">Generate a Key</a></li>
          <li><a href="Encode.php" class = "linkGlyph">Encode a Message</a></li>
          <li><a href="Decode.php" class = "linkGlyph">Decode a Message</a></li>
        </ul>
      </div>

      <script>
        $(document).ready(function(){
          document.getElementsByClassName("siteNav")[0].style.marginTop = document.getElementById("bannerImg").height + "px";
          document.getElementsByClassName("main")[0].style.height = window.innerHeight + "px";
        });
      </script>

      <div class = "container fit">

        <div class = "row vertical-align">
          <div class = "col-sm-12 specialBlue img-rounded">
            <h3>Generate a Key</h3>
            <p>Here, you can generate yourself a private key (password) and a public key (address).</p>
            <p>To use the public key, just give it to anyone who may want to write you a message. When they write you a message, they need to set the recipient's address as your public key. To decode the message, you take the message and input your private key (password). The original message will be displayed back.</p>
            <p>When you generate a private key, make sure you keep it secret. This software is only as strong as your private key (password). If someone can guess your private key, they can decrypt messages meant for only you. If you want a group to be able to recieve messages, make a public and private key for a group.</p>
          </div>
        </div>

        <br/>

        <div class = "row vertical-align">
          <button type = "button" class = "btn btn-lg specialBlue btn-block genKey" data-toggle = "modal" data-target = "#myModal">Generate Keys</button>
        </div>

      </div>

      <div id = "myModal" class = "modal fade" role = "dialog">
        <div class = "modal-dialog">
          <div class = "modal-content">
            <div class = "modal-header specialBlue">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Generate Keys</h4>
            </div>
            <div class = "modal-body">
              <form method = "post" action = "NewKey.php">
                <p class = "fit">Public Key (Address): <br/> <input type = "text" name = "publicKey" value = "" class = "fit"></p>
                <p class = "fit">Private Key (Password): <br/> <input type = "password" name = "privateKey" value = "" class = "fit"></p>
                <!--TODO get a checkbox for a forceExpire option-->
                <input type = "submit" class = "fit submit">
              </form>
            </div>
            <div class = "modal-footer specialBlue">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <br/>

      <div id = "keyAlert" class = "fit alert alert-dismissable">
      </div>

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
