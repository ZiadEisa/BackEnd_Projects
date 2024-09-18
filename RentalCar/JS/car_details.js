    $(document).ready(function() {
    $('#rent_button').on('click', function() {
        let car_id = document.getElementById('car_id').value;
        let username = $('input[name="username"]').data('username');
        console.log('Car ID:', car_id);
        console.log('Username:', username);

        if (username) {
            $.ajax({
                url: "rent_form.php",
                method: "POST",
                data: {
                    car_id: car_id,
                    username: username,
                },
                dataType: 'json',
                success: function(response) {
                    let errorMessage = $('#error_message');
                    let successMessage = $('#success_message');
                    let rentForm = $('#rent-form');
                    let waitingListButton = $('#waitingList-btn');

                    // Hide all forms and buttons initially
                    rentForm.hide();
                    waitingListButton.hide();

                    if (response.status === 'error') {
                        errorMessage.text(response.message).show();
                        successMessage.hide();
                    } else if (response.status === 'rented') {
                        errorMessage.hide();
                        successMessage.text(response.message).show();
                        waitingListButton.text('Add to Waiting List').show();
                    } else if (response.status === 'available') {
                        errorMessage.hide();
                        rentForm.show();

                        // Set min date for the date inputs
                        let today = new Date().toISOString().split('T')[0];
                        $('#rent-from').attr('min', today);
                        $('#rent-to').attr('min', today);

                        // Validate dates
                        $('#rent-to').on('change', function() {
                            let fromDate = new Date($('#rent-from').val());
                            let toDate = new Date($('#rent-to').val());

                            if (toDate <= fromDate) {
                                $('#rent-to').val('');  // Clear the field
                                errorMessage.text('End date must be later than the start date.').show();
                                setTimeout(() => {
                                    errorMessage.hide();
                                }, 4000);
                            } else {
                                $(document).ready(function() {
                                    $('#date_form_button').on('click', function(event) {
                                        event.preventDefault();  // Prevent the default form submission
                                
                                        let car_id = $('#car_id').val();
                                        let username = $('input[name="username"]').data('username');
                                        console.log(username);
                                        $.ajax({
                                            url: "rent_date_auth.php",
                                            method: "POST",
                                            data: {
                                                car_id: car_id,
                                                username: username,
                                                rented_to: $('#rent-to').val(),
                                                rented_from: $('#rent-from').val()
                                            },
                                            dataType: 'json',
                                            success: function(response) {
                                                
                                                let errorMessage = $('#error_message');
                                                let successMessage = $('#success_message');
                                                console.log(response);
                                                if (response.status === 'success') {
                                                    successMessage.text(response.message).show();
                                                    setTimeout(() => {
                                                        successMessage.hide();
                                                        window.location.reload();
                                                    }, 5000);
                                                } else {
                                                    if (response.message === "You are not logged in. Please log in to continue") {
                                                        errorMessage.html(response.message + " (<a href='Login.php'>Log in</a>)").show();
                                                    } else {
                                                        errorMessage.text(response.message).show();
                                                    }
                                                      // Log the server response
                                                    setTimeout(() => {
                                                        errorMessage.hide();
                                                        window.location.reload();
                                                    }, 4000);
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                $('#error_message').text("An error occurred: " + error).show();
                                                $('#success_message').hide();
                                            }
                                        });
                                    });
                                });
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    $('#error_message').text("An error occurred: " + error).show();
                    $('#success_message').hide();
                }
            });
        } else {
            $('#error_message').text('Login first then rent the car.').show();
            $('#success_message').hide();
            setTimeout(function() {
                $('#error_message').hide();
            }, 6000);
        }
    });
    });