function generateKeys(form){
  $("#myModal").modal('hide');
  var keys = {publicKey : form.publicKey.value, privateKey : form.privateKey.value}
  console.log("\"" + keys.publicKey + "\"" + " is the public key");
  console.log("\"" + keys.privateKey + "\"" + " is the private key");
  if(!(publicKey != "" || privateKey != "")){
    $.post("Database.php", keys, function(){

    });
  }
}

function randBetween(lowerLimit, upperLimit){

}

function randLetter(){
  var chars = "abcdefghijklmnopqrstuvwxyz1234567890,./<>?;':'[]{}-=_+\"\\|!@#$%^&*()";
  return chars[Math.floor((Math.random() * (chars.length + 1))) - 1];
}

function encodeMessage(message, public_key){

}

function decodeMessage(message, private_key){

}
