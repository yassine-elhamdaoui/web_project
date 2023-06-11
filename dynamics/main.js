const burgerMenu = document.getElementById('menu-icon');
const navMenu = document.getElementById('navigation');


//the menu after clicking on the burger menu
burgerMenu.addEventListener('click', () => {
  if (navMenu.style.opacity === '0') {
    burgerMenu.classList.toggle('fa-x');
    navMenu.style.opacity = '1'; 
    navMenu.style.display = 'flex';
  } else {
    burgerMenu.classList.remove('fa-x');
    navMenu.style.opacity = '0';
    navMenu.style.display = 'none';
  }
});
//changing the menu icon to an X
window.onscroll = function(){
  if (window.innerWidth < 590) {
    navMenu.style.opacity = '0';
    navMenu.style.display = 'none';
    burgerMenu.classList.remove('fa-x');
  }
};
window.onload = function () {
  if (window.innerWidth < 590) {
  navMenu.style.display = 'none';
  }
}

//clearing the data in the inputs !!
// function eraseInput() {
//   document.querySelector('.Input').value = "";
// }


//scroll effect ou dakchi
ScrollReveal({
    reset: true,
    distance :'140px',
    duration: 2000,
    delay: 200
});
ScrollReveal().reveal('.content h2 , .info ,.gallery h1 , .contact h2', { origin:'top'});
ScrollReveal().reveal('.content p ,.info_container ,  .input-box , .booking_form', { origin:'left'});
ScrollReveal().reveal('.home-page h2', { origin:'top'});
ScrollReveal().reveal('.booking-form form,#info_container2 , .holder textarea', { origin:'right'});


// the response div
const check_available = document.getElementById('check');
const response = document.getElementById('response');
const response_close = document.getElementById('response-close');
const check_in = document.getElementById('check-in');
const check_out = document.getElementById('check-out');


let check_in_value = check_in.value;
let check_out_value = check_out.value;
check_available.addEventListener('click', function() {
  if (check_in_value !== "" && check_out_value !== "") {
    response.style.display = 'flex';
  
  }  
});

response_close.addEventListener('click', function() {
  // setTimeout(function() {
  //   response.style.display = 'none';
  // }, 2000);
  response.style.display = 'none';

});

var typed = new Typed('.type', {
  strings: ['Experience', 'Luxury'],
  typeSpeed: 100,
  backSpeed: 100,
  loop: true,
  showCursor: false,
  startDelay: 500
});

