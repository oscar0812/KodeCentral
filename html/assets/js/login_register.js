$(function() {
  $('.is-empty').removeClass('is-empty');

  $('#login-form').on('submit', function(e) {
    ajaxForm(e.target, function(data) {
      if (data['success']) {
        window.location.href = data['redirect_link'];
      } else {
        $("#login-label").removeClass('invisible');
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
        label = $('#register-label');
        label.removeClass('invisible');
        if (data['success']) {
          label.addClass('text-success').text('Account Created! Please visit your email to verify.')
        } else {
          label.addClass('text-danger').text('Something went wrong!')
        }
      });
    }
  });
})
