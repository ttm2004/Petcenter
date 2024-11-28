
function dis_lock() {
  let date = new Date();
  let day = date.getDate();
  let month = date.getMonth() + 1;
  let year = date.getFullYear();
  let hours = date.getHours();
  let minutes = date.getMinutes();
  let seconds = date.getSeconds();
  let Before_none = "AM";
  if (hours < 10) {
    hours = "0" + hours;
  }
  if (minutes < 10) {
    minutes = "0" + minutes;
  }
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  if (hours > 12) { 
    Before_none = "PM";
  }
  document.getElementById("oclock").innerHTML = 
    day +
    "/" +
    month +
    "/" +
    year +
    " " +
    hours +
    ":" +
    minutes +
    ":" +
    seconds +
    " " +
    Before_none;
}
setInterval(function () {
  dis_lock();
}, 1000);

$(document).ready(function() {
  $(window).scroll(function() {
      if($(this).scrollTop())
          $(".back-to-top").fadeIn();
      else
          $(".back-to-top").fadeOut();
  });
  $(".back-to-top").click(function(){
      $('html').animate({scrollTop:0},500);
  });
});