$(function() {
  var width = $('.g-recaptcha').parent().width();
  if (width < 302) {
    var scale = width / 302;
    $('.g-recaptcha').css('transform', 'scale(' + scale + ')');
    $('.g-recaptcha').css('-webkit-transform', 'scale(' + scale + ')');
    $('.g-recaptcha').css('transform-origin', '0 0');
    $('.g-recaptcha').css('-webkit-transform-origin', '0 0');
  }
  
  $('#contact-form').on('submit', function(e) {
    Snackbar.show({
      actionTextColor: '#ffff00',
      text: 'Sending email...'
    });


    $.ajax({
      type: "POST",
      url: "",
      dataType: "json",
      data: {
        email: $('#inputEmail').val(),
        message: $('#textArea').val(),
        captcha: grecaptcha.getResponse()
      },

      success: function(data) {

        color = '#ff0000';
        if (data['success']) {
          color = '#00ff00';
        }

        Snackbar.show({
          actionTextColor: color,
          text: data['msg']
        });

        return false;
      }
    });



    return false;
  });
});
