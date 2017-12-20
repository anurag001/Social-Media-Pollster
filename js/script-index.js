/* $(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top
        }, 500);
        return false;
      }
    }
  });
});  */


$(document).ready(function(){
    $("#reg-header").click(function(){
        $("#logintab").removeClass("active in");
        $("#registertab").addClass("active in"); 
        $("#login-tab").removeClass("active");
        $("#reg-tab").addClass("active");
    });
    
    $("#login-header").click(function(){
        $("#registertab").removeClass("active in");
        $("#logintab").addClass("active in");
        $("#reg-tab").removeClass("active");
        $("#login-tab").addClass("active");
        
    });
        
        
});