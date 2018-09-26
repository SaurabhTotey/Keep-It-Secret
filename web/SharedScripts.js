$(document).ready(function(){

  //This part of codes correctly spaces the page such that the navbar is below is the banner image and that the footerbox is at the bottom of the page
  $('.nav li').width($('ul.nav').width() / 4 - 3.7);
  var windowHeight = window.innerHeight ? window.innerHeight : $(window).height()
  while($('.main').height() < windowHeight){
    $('#spacer').height($('#spacer').height() + 1);
  }

  //This function adds the code for the button that copies the encrypted message
  var copyButton = document.querySelector('#copy');
  if(copyButton){
    copyButton.addEventListener('click', function(event){
      var text = (document.querySelector('#encrypted')) ? document.querySelector('#encrypted') : document.querySelector('#decrypted');
      var range = document.createRange();
      range.selectNode(text);
      window.getSelection().addRange(range);
      try{
        document.execCommand('copy');
      }catch(e){}
      window.getSelection().removeAllRanges();
    });
  }

});

//This function makes strings HTML safe
function makeSafe(stringToSave){
  return $('<span>').text(stringToSave).html();
}
