<?php

  $allChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890,./<>?;\':[]{}-=_+"\\|!@#$%^&*()';

  /*
   *  This function returns a random letter from the above string of all characters
   */
  function randLetter(){
    global $allChars;
    return substr($allChars, mt_rand(0, strlen($allChars)), 1);
  }

  /*
   *  This function turns a string into a number based on the above string of characters
   *  The index of each character is its number
   *  The function sums each character's number and returns the sum
   */
  function stringToNumber($toNumerize){
    global $allChars;
    $sum = 0;
    for($i = 0; $i < strlen($toNumerize); $i++){
      $sum += 1 + strpos($allChars, substr($toNumerize, $i, 1));
    }
    return $sum;
  }

  /*
   *  This function turns a number into a single letter
   *  if a number is too big for the above character map, the number continues counting from the beginning
   */
  function numberToLetter($toLetterize){
    global $allChars;
    return substr($allChars, $toLetterize % strlen($allChars), 1);
  }

  /*
   *  This function predictably encodes a message into a string based on a given key or password
   */
  function encodeMessage($message, $private_key){
    global $allChars;
    //Seeds the RNG with the user's password (as a number) and records original message length
    //Mess length is needed for decryption
    mt_srand(stringToNumber($private_key));
    $toReturn = "";
    $messageLength = strlen($message);
    //This loop goes through each letter of the message and then shifts it up a certain amount of characters using the numberToLetter method
    //It takes the letter's number (with stringToNumber) and then adds a random amount on to that number and then reconverts the number to a letter
    for($i = 0; $i < $messageLength; $i++){
      $message = substr_replace($message, numberToLetter(stringToNumber(substr($message, $i, 1)) + mt_rand(0, strlen($allChars))), $i, 1);
    }
    //Shifts the message into a square of a random side length as exemplified below
    //"this is a message" in a 5x4 square (not a square, but usually will be a square)
    // - - - - - -
    // |t|h|i|s| |
    // - - - - - -
    // |i|s| |a| |
    // - - - - - -
    // |m|e|s|s|a|
    // - - - - - -
    // |g|e|!| | |
    // - - - - - -
    //turns to "timghseei s!sas   a "
    $jumpLength = mt_rand(1, $messageLength / 2);
    $jumped = "";
    for($i = 0; $i < $jumpLength; $i++){
      for($j = 0; $j < ceil($messageLength / $jumpLength); $j++){
        if($i + $j * $jumpLength < $messageLength){
          $jumped .= substr($message, $i + $j * $jumpLength, 1);
        }else{
          $jumped .= " ";
        }
      }
    }
    //This part "fills" and anagrams the message from its current stage
    //"filling" is inserting random letters in between all "legit" letters
    //anagramming happens when random "legit" letters are inserted in no particular order
    $alreadyUsed = array();
    $randSpot = -1;
    $encoded = "";
    while(sizeof($alreadyUsed) < strlen($jumped)){
      while(mt_rand(0, 1) == 1){
        $encoded .= randLetter();
      }
      while($randSpot < 0 || in_array($randSpot, $alreadyUsed)){
        $randSpot = mt_rand(0, strlen($jumped) - 1);
      }
      $alreadyUsed[] = $randSpot;
      $encoded .= substr($jumped, $randSpot, 1);
    }
    while(mt_rand(0, 1) == 1){
      $encoded .= randLetter();
    }
    //This part adds the encoded message and concatenates it with a ";" and the original message length
    //The original message length is necessary for decryption because it was used for loop counters and such in encryption
    $toReturn = $encoded . ";" . $messageLength;
    return $toReturn;
  }

  /*
   *  This function decodes messages that were encrypted from the above method based on the same key or password used for encryption
   */
  function decodeMessage($message, $private_key){
    global $allChars;
    //This part just seeds the RNG with the user's password that was used to encrypt the message
    //This way, the RNG will generate the same numbers it generated during encryption in the same order it did during encryption
    mt_srand(stringToNumber($private_key));
    $decoded = "";
    //This part unconcatenates the message from the message length and the ";" that joined them at the end
    $temp = "  ";
    for($i = 2; strcmp((string) substr($temp, 0, 1), ";") !== 0; $i++){
      $temp = substr($message, -$i);
    }
    $messageLength = intval(substr($temp, 1));
    $message = substr($message, 0, -strlen($temp));
    //This part generates the same shifts that were generated at this step of the encryption
    //These shifts will be used at a later stage to unshift all letters
    $shifts = array();
    for($i = 0; $i < $messageLength; $i++){
      $shifts[] = mt_rand(0, strlen($allChars));
    }
    //This part generates the same square length for "jumping" the message
    //The RNG will make the same jump length here as it did for encryption if the password was the same
    $jumpLength = mt_rand(1, $messageLength / 2);
    //This part mimics the encoding process of filling and anagramming a message with a few key differences
    //It does the same process for filling with generating the same random letters (because of the same RNG seed)
    //But for anagramming, it just records the location of the letter it would have taken and the location of where the letter was put
    $orderUsed = array();
    $legitLocations = array();
    $randSpot = -1;
    $tempLength = 0;
    while(sizeof($orderUsed) < $messageLength){
      while(mt_rand(0, 1) == 1){
        randLetter();
        $tempLength++;
      }
      while($randSpot < 0 || in_array($randSpot, $orderUsed)){
        $randSpot = mt_rand(0, strlen($messageLength) - 1);
      }
      $orderUsed[] = $randSpot;
      $legitLocations[] = $tempLength;
      $tempLength++;
    }
    while(mt_rand(0, 1) == 1){
      randLetter();
      $tempLength++;
    }

    //TODO use obtained indices of legit jumped and shifted letters to reconstruct the message at this step

    //TODO unjump the message

    //TODO unshift the message

    return $decoded;
  }
 ?>
