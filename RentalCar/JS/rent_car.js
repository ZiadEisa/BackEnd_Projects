$(document).ready(function(){
  $('#rent_button').on('clcik',function(){
    let car_id = this.data('car-id');
    let username = this.data('username');

      if(username){
      $ajax({
        url: "rent_form.php",
        method: "GET",
        data:{
          car_id : car_id,
        },
        success:function(response){
          let message , dateFormRent , waintingListBtn;
          if(response.status === "available"){
            message = $('#success_message');
          }else{
            message = $('#error_message');
          }
          waintingListBtn = $('#waitingList-btn');
          dateFormRent = $('#date-form');

          if(response.status === "rented"){
            message.
          }else if(response.status === "available"){

          }else if(response.status === "error"){

          }
        },
        error:
        function(JqXhr, textStatus ,errorThrown){
          $('error_message').html("An error thrown While getting the form please try later" + errorThrown);
        }
      });
    }else{
      $('#error_message').html('Login first then rent the car.').show();
      setTimeout(()=>function(){
        $('#error_message').html('').hide();
      },4000)
    }
  });
});