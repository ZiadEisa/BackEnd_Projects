$(document).ready(function(){
  $('#loggout_btn').on('click', function(e){
    e.preventDefault(); 
    
    $.ajax({
      url: 'logout.php', 
      type: 'POST',
      dataType: 'json',
      success: function(response) {
        alert(response.message);
        if (response.status === "success") {
          window.location.href = 'Login.php'; 
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);  
      }
    });
  });
});
