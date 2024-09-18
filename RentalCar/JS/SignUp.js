document.addEventListener("DOMContentLoaded" , function(){

  let successMessage = document.getElementById('success');
  let errorMessage = document.getElementById('error');


  function Remove(Message){
    Message.style.display = 'block';
    Message.style.opacity = 1;
    setTimeout(()=> {
      Message.style.display = 'none'
      Message.style.opacity = 0;
    },4000);
  }


  
  if(successMessage){

    Remove(successMessage);

  }else if(errorMessage){

    Remove(errorMessage);
  }
});

function scrollToSignUpForm() {
  const form = document.getElementById('SignUp-form');
  if (form) {
      form.scrollIntoView({ behavior: 'smooth' });
  }
}