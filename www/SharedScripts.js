$(document).ready(function(){

  document.getElementsByClassName("siteNav")[0].style.marginTop = document.getElementById("bannerImg").height + "px";
  var windowHeight = window.innerHeight ? window.innerHeight : $(window).height()
  while($(".main").height() < windowHeight){
    $("#spacer").height($("#spacer").height() + 1);
  }

});

function makeSafe(stringToSave){
  return $('<span>').text(stringToSave).html();
}
