$(document).ready(function(){
  $('#Update').on('click', function(event) {
      event.preventDefault();
      // let ReloadPage = window.location.reload()
      let current_pass = $('#current-password').val().trim();
      let new_pass = $('#new-password').val().trim();
      let confirm_new_pass = $('#confirm-password').val().trim();
      let email = $('#new-email').val().trim();
      
      if (current_pass === "") {
          alert("Current password can't be empty.");
          return;
      }
      
      if (new_pass && new_pass !== confirm_new_pass) {
          $('#error_message').text("Passwords don't match").show();
          setTimeout(function() {
              $('#error_message').text('').hide();
          }, 4000);
          return;
      }
      
      if (email || (new_pass && confirm_new_pass)) {
          $.ajax({
              url: "update_data.php",
              method: 'POST',
              dataType: 'json',
              data: {
                  password: current_pass,
                  new_password: new_pass,
                  confirm_password: confirm_new_pass,
                  email: email
              },
              success: function(response) {
                  if (response.status === 'success') {
                      $('#success_message').text(response.message).show();
                      setTimeout(function() {
                          $('#success_message').text('').hide();
                      }, 4000);
                  } else {
                      $('#error_message').text(response.message).show();
                      setTimeout(function() {
                          $('#error_message').text('').hide();
                      }, 4000);
                  }
              },
              error: function(xhr, textStatus, errorThrown) {
                  $('#error_message').text("An error occurred while updating your data: " + errorThrown).show();
                  setTimeout(function() {
                      $('#error_message').text('').hide();
                  }, 4000);
              }
          });
      } else {
          $('#error_message').text("Either the email or password fields must be filled").show();
          setTimeout(function() {
              $('#error_message').text('').hide();
          }, 4000);
      }
  });
});
