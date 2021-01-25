$('#more_url').click(function() {
     var urlNr = $('.url_field').length + 1;
        $('#url_container').append('<div id="' + urlNr + '" class="url_field" style="padding-top: 5px;"> \
    <label class="url_label" >URL: </label> \
    <input class="form-control" name="url[]" type="text" placeholder="M3U or TXT playlist URL" /> \
   </div>');
        if ($('.url_field').length == 1) {
            $('#less_url').hide();
        } else {
            $('#less_url').show();
        }
    });


 $('#less_url').click(function() {
        var urlNr = $('.url_field').length;
        if (urlNr > 1) {
            $('#' + urlNr).remove();
        }
        if ($('.url_field').length == 1) {
            $('#less_url').hide();
        } else {
            $('#less_url').show();
        }
        $('#more_url').show();
    });