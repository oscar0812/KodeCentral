$(function() {
  $('.is-empty').removeClass('is-empty');

  $('#login-form').on('submit', function(e) {
    ajaxForm(e.target, function(data) {
      console.log(data);
      if (data['success']) {
        window.location.href = data['redirect_link'];
      } else {

        // resend vefication email through snackbar to avoid screen clutter
        // show snackbar here
        text = 'Ok';
        callback = function(element) {
          $(element).remove();
        }

        if (data['confirm']) {
          text = 'Resend Email';
          username = $('input[name="Login[Username]"]');

          clicked = false;

          callback = function(element) {

            if (username.val() == "") {
              shake(username.parent());
              return;
            }

            if (clicked) {
              return;
            }

            clicked = true;

            $.ajax({
              type: "POST",
              data: {
                Resend: true,
                username: username.val()
              },
              url: $('#login-form').attr('action'),
              dataType: "json",
              success: function(data) {
                clicked = false;
                console.log(data);
                Snackbar.show({
                  actionTextColor: '#ffff00',
                  duration: 0,
                  text: 'Email sent..'
                });
              }
            });
          }
        }

        Snackbar.show({
          actionTextColor: '#ff0000',
          actionText: text,
          duration: 0,
          text: data['msg'],
          onActionClick: callback
        });
      }
    });
    return false;
  })

  $('#register-form').validate({
    rules: {
      'Register[Username]': {
        required: true,
        // check if username is already taken
        remote: {
          url: window.location.href + "/info",
          type: "POST",
          data: {
            username: function() {
              return $('input[name="Register[Username]"]').val();
            }
          }
        }
      },
      'Register[Email]': {
        required: true,
        email: true,
        // check if email is already taken
        remote: {
          url: window.location.href + "/info",
          type: "POST",
          data: {
            email: function() {
              return $('input[name="Register[Email]"]').val();
            }
          }
        }
      },
      'Register[Password]': {
        required: true
      }
    },
    // Specify validation error messages
    messages: {
      'Register[Username]': {
        remote: $.validator.format("Username is already in use")
      },
      'Register[Email]': {
        remote: $.validator.format("Email is already in use")
      }
    },
    errorPlacement: function(error, element) {
      // make the error red, and append it to the parent of the parent
      error.attr('style', 'color: #f44336 !important').appendTo(element.parent().parent());
    },
    submitHandler: function(form) {
      // form to create admin account submitted
      ajaxForm(form, function(data) {
        // show snackbar
        if (data['success']) {
          color = '#00ff00';
        } else {
          color = '#ff0000';
        }

        Snackbar.show({
          actionTextColor: color,
          duration: 0,
          text: data['msg']
        });
      });
    }
  });

  // forgot password form submitted
  $('#forgot-form').on('submit', function(e){
    Snackbar.show({
      actionTextColor: '#ffff00',
      duration: 0,
      text: 'Sending Email..'
    });

    ajaxForm(e.target, function(data){
      Snackbar.show({
        actionTextColor: '#00ff00',
        duration: 0,
        text: 'Email sent..'
      });
    });
    return false;
  })
})
