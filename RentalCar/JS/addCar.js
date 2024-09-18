let showMessageSec = 5000;

$(document).ready(function() {
  // Handle file selection for car detailed images
  $('#car-detailed-images').on('change', function() {
    const files = this.files;
    if (files.length < 4 || files.length > 6) {
      $('#error_message').html("You should select at least 4 files and not more than 6 files").show();
      setTimeout(() => {
        $('#error_message').html('').hide(); // Hide the error message
      }, showMessageSec);
    } else {
      $('#choosen-files').text(files.length + " selected images");
    }
  });

  // Handle form submission and validation
  $('#add-car-form').on('submit', function(event) {
    event.preventDefault();
    CarDataValidation();  // Call the validation function
  });

  // Validation logic for car data
  function CarDataValidation() {
    let carBrandName = $('#carType').val().trim();
    let carName = $('#car-name').val().trim();
    let carSpeed = $('#car-speed').val().trim();
    let carPrice = $('#car-rent-price').val().trim();

    let numberOfCharacters = 0;

    // Validate car brand name
    for (let i = 0; i < carBrandName.length; i++) {
      if (/[a-zA-Z0-9]/.test(carBrandName[i])) {
        if (/[a-zA-Z]/.test(carBrandName[i])) {
          numberOfCharacters++;
        }
      } else {
        $('#error_message').html("The car brand name should consist only of letters and numbers.").show();
        setTimeout(() => {
          $('#error_message').html('').hide();
        }, showMessageSec);
        return;
      }
    }

    if (numberOfCharacters === 0) {
      $('#error_message').html("The car brand name must have at least 1 letter.").show();
      setTimeout(() => {
        $('#error_message').html('').hide();
      }, showMessageSec);
      return;
    }

    // Validate car name
    if (!/^[A-Za-z0-9\s-]+$/.test(carName) || carName === '') {
      let error_message = carName === '' ? "The car name cannot be empty." : "The car name should only contain letters and numbers.";
      $('#error_message').html(error_message).show();
      setTimeout(() => {
        $('#error_message').html('').hide();
      }, showMessageSec);
      return;
    }

    // Validate car speed
    if (!/^(\d+(\.\d+)?)(km\/h|m\/s)$/.test(carSpeed)) {
      $('#error_message').html("The car speed must be a valid number followed by 'km/h' or 'm/s'. Example: '556km/h' or '452m/s'.").show();
      setTimeout(() => {
        $('#error_message').html('').hide();
      }, showMessageSec);
      return;
    }

    // Validate car price
    if (!/^\d+(\.\d{1,2})?$/.test(carPrice)) {
      $('#error_message').html("The car price must be a positive number, up to two decimal places. Example: '5445.46'.").show();
      setTimeout(() => {
        $('#error_message').html('').hide();
      }, showMessageSec);
      return;
    }

    // If validation is successful, proceed with form submission via AJAX
    let formData = new FormData($('#add-car-form')[0]);

    $.ajax({
      url: "authAddCar.php",
      method: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        let trimmedResponse = response.trim();
        if (trimmedResponse === "Your car added successfully!") {
          $('#success_message').html(trimmedResponse).show();
          setTimeout(() => {
            $('#success_message').fadeOut();
            window.location.reload(); // Reload the page after success
          }, showMessageSec);
        } else {
          $('#error_message').html(trimmedResponse).show();
          setTimeout(() => {
            $('#error_message').fadeOut();
          }, 5000); // Wait before fading out
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('AJAX error:', textStatus, errorThrown);
        $('#error_message').html("An error occurred while submitting the form.").show();
        setTimeout(() => {
          $('#error_message').fadeOut();
        }, showMessageSec);
      }
    });
  }
});
