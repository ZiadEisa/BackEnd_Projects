$(document).ready(function() {
  // Attach the event handler to form submission
  $('#login-form').on('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission

    CheckLogin(); 
  });

  function CheckLogin() {
    let username = $('#username').val();
    let password = $('#password').val().trim();

    if (password === "") {
      $('#message').html("Password is empty").addClass('show').show();
      setTimeout(() => {
        $('#message').fadeOut(1000, function() {
          $(this).html("").removeClass('show').hide();
        });
      }, 4000);
    } else {
      $.ajax({
        url: 'authLogin.php',
        method: 'POST',
        data: {
          username: username,
          password: password
        },
        success: function(response) {
          try {
            // Parse the response to JSON if it's not already
            let jsonResponse = typeof response === 'object' ? response : JSON.parse(response);

            if (jsonResponse.status === 'error') {
              $('#message').html(jsonResponse.message).addClass('show').show();
              setTimeout(() => {
                $('#message').fadeOut(1000, function() {
                  $(this).html("").removeClass('show').hide();
                });
              }, 4000);
            } else if (jsonResponse.status === "success") {
              console.log(jsonResponse.message);
              window.location.href = "index.php"; // Redirect on success
            }
          } catch (e) {
            $('#message').html("Invalid response from server").addClass('show').show();
          }
        },
        error: function(xhr, status, error) {
          $('#message').html("An error occurred. Please try again later.").addClass('show').show();
          setTimeout(()=>{
            $('#message').fadeOut(1000, function() {
              $(this).html("").removeClass('show').hide();
            });
          }, 6000);
        }
      });
    }
  }
});
