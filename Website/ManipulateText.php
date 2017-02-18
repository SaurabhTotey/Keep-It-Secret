<?php

  $allChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890,./<>?;\':[]{}-=_+"\\|!@#$%^&*()';

  function randLetter(){
    global $allChars;
    return substr($allChars, mt_rand(0, strlen($allChars)), 1);
  }

  function stringToNumber($toNumerize){
    global $allChars;
    $sum = 0;
    for($i = 0; $i < strlen($toNumerize); $i++){
      $sum += 1 + strpos($allChars, substr($toNumerize, $i, 1));
    }
    return $sum;
  }

  function numberToLetter($toLetterize){
    global $allChars;
    return substr($allChars, $toLetterize % strlen($allChars), 1);
  }

  function encodeMessage($message, $private_key){
    global $allChars;

    mt_srand(stringToNumber($private_key));
    $toReturn = "";
    $messageLength = strlen($message);

    for($i = 0; $i < $messageLength; $i++){
      $message = substr_replace($message, numberToLetter(stringToNumber(substr($message, $i, 1)) + mt_rand(0, strlen($allChars))), $i, 1);
    }

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

    $alreadyUsed = array();
    $randSpot = -1;
    $encoded = "";
    while(sizeof($alreadyUsed) < $jumped){
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

    //TODO put original messageLength in toReturn
    for($i = 0; $i < strlen($encoded) * 2; $i++){
      if($i % 2 == 0){

      }else{

      }
    }

    return $toReturn;
  }

  function decodeMessage($message, $private_key){
    global $allChars;

    mt_srand(stringToNumber($private_key));
    $decoded = "";
    $messageLength = 0;

    $shifts = array();
    for($i = 0; $i < $messageLength; $i++){
      $shifts[] = mt_rand(0, strlen($allChars));
    }

    $jumpLength = mt_rand(1, $messageLength / 2);

    //TODO unjump the message

    //TODO unshift the message

    return $decoded;
  }
 ?>
