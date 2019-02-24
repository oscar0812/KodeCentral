$(function() {
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
