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

  </head>

  <body>
    <div class = "main">

      <div class = "masthead">
        <a href = "../www"><img src="Masthead.png" class = "fit rounded-img" id = "bannerImg"/></a>
      </div>

      <br/>

      <div class = "navbar fit navbar-light siteNav img-rounded">
        <ul class = "nav navbar-nav fit img-rounded specialBlue">
          <li class = "active"><a href = "../www" class = "linkGlyph">Home</a></li>
          <li><a href = "Generate_Key" class = "linkGlyph">Generate a Key</a></li>
          <li><a href = "Encode" class = "linkGlyph">Encode a Message</a></li>
          <li><a href = "Decode" class = "linkGlyph">Decode a Message</a></li>
        </ul>
      </div>

      <script>
        $(document).ready(function(){
          document.getElementsByClassName("siteNav")[0].style.marginTop = document.getElementById("bannerImg").height + "px";
        });
      </script>

      <div class = "jumbotron jumbotron-fluid img-rounded fit">
        <div class = "container">
          <div id = "headCarousel" class="carousel slide" data-ride="carousel">
            <ol class = "carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
              <li data-target="#myCarousel" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
              <div class = "item active">

              </div>
              <div class = "item">

              </div>
              <div class = "item">

              </div>
              <div class = "item">

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class = "container fit">
        <div class = "row vertical-align">
          <div class = "col-sm-8 specialBlue img-rounded">
            <h3>About</h3>
            <p>Have you ever sent a private message to someone, only for the message to get intercepted or looked upon by a different person? With KeepItSecret, you won't need to have that problem anymore. With this service, you can create an address and a password, or write messages intended for specific addresses. Once a message is written for an address, the message gets encoded. Whenever anyone recieves an encoded message, they can try to decode it, but the only way to actually get the original message is to use the intended recipient's address and password.</p>
            <h3>How It Works - <a href = "Generate_Key/index.php" class = "linkGlyph">Key Creation</a></h3>
            <p>The type of encryption KeepItSecret uses is similar to <a href = "https://en.wikipedia.org/wiki/Public-key_cryptography">public key cryptography</a>, and so for public key cryptography to work, as the name suggests, keys would need to be generated. When you register an address and a password, they get stored in a database along with the date of creation and whether they have a hard expiration date. If the key has a hard expiration date, it will get deleted after one day of its creation regardless of usage. Otherwise, the key will get deleted after a week of disuse.</p>
            <h3>How It Works - <a href = "Encode/index.php" class = "linkGlyph">Encoding</a></h3>
            <p>Through encryption, a message goes through two main phases to make it unreadable. The first step taken is that the recipient's private key is found out from their public key. The user's private key is then used as the random number generator's (RNG's) seed. This is a necessary step due to how <a href = "https://en.wikipedia.org/wiki/Pseudorandom_number_generator">pseudo-random number generation</a> works: the same seed will always generate the same "random" numbers (this is used later for decoding the message). Then, the message gets <a href = "https://en.wikipedia.org/wiki/Caesar_cipher">Caeser Ciphered</a> with each shift amount being a random number for each letter. Then, each letter of the message gets shuffled. Afterwards, random letters are inserted in the message. Then, the original message's length is concatenated at the end of the message to be used for decrypting it.</p>
            <h3>How It Works - <a href = "Decode/index.php" class = "linkGlyph">Decoding</a></h3>
            <p>To decrypt a message, the user must enter their password. If their password was the private key used to encrypt the message, the message will decrypt correctly. Otherwise, decryption will either error or return something random. In decryption, the computer finds the message's length, and then seeds the RNG with the entered private key. The computer then generates and saves the same random numbers that it generated for encryption. It then takes the message through a backwards version of the encryption process to instead of getting from a message to an encoded message, will instead go from an encoded message to the original message. This is possible because it seeded the RNG the same way in both encryption and decryption, so the same "random" numbers were generated both times.</p>
          </div>
          <div class = "col-sm-4 imgContainer">

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
