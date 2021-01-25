$(document).ready(function() {
    $(document).scroll(function() {
      if ($(this).scrollTop() > 650) {
        $('#nav-bar-overlay').fadeIn(120);
      }
      
      if ($(this).scrollTop() < 650) {
        $('#nav-bar-overlay').fadeOut(120);
      }
    });
    
    $("#location-section").click(function(e){
        e.preventDefault();
        $("html, body").animate({scrollTop: 3361}, 1250);
    });
    
    $("#nav-bar-item-top").click(function(e){
        e.preventDefault();
        $("html, body").animate({scrollTop: 0}, 1250);
    });

    $('#reservation-button').click(function() {        
        $("#dialog-box").fadeIn(150);
        $("#dialog-overlay").fadeIn(150);
    });
    
    $("#close-dialog-menu").click(function() {        
        $("#dialog-box").fadeOut(150);
        $("#dialog-overlay").fadeOut(150);
    });
    
    $("#dialog-overlay").click(function() {        
        $("#dialog-box").fadeOut(150);
        $("#dialog-overlay").fadeOut(150);
    });
});