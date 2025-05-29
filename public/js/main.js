

document.addEventListener('DOMContentLoaded', function () {

});

// const swiper = new Swiper('.hero-swiper', {
//   loop: true,
//   effect: 'fade',
//   autoplay: {
//     delay: 5000,
//     disableOnInteraction: false,
//   },
//   speed: 1000
// });




document.addEventListener('DOMContentLoaded', () => {
  gsap.from(".hero-label", {
    opacity: 0,
    y: -30,
    duration: 1,
    delay: 0.3
  });

  gsap.from(".hero-heading span", {
    opacity: 0,
    y: 50,
    duration: 1,
    stagger: 0.2,
    delay: 0.6
  });

  gsap.from(".hero-cta", {
    opacity: 0,
    y: 30,
    duration: 1,
    delay: 1.2
  });

  gsap.from(".hero-testimonial", {
    opacity: 0,
    x: 50,
    duration: 1,
    delay: 1.5
  });



  // Tab Switching Logic
  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Remove active class from all buttons and hide all content
      tabButtons.forEach(btn => btn.classList.remove('active'));
      tabContents.forEach(content => content.classList.add('hidden'));

      // Add active class to the clicked button
      button.classList.add('active');

      // Show the corresponding content
      const targetTab = button.dataset.tab;
      document.getElementById(`${targetTab}-content`).classList.remove('hidden');
    });
  });
  // // Tab Switching Logic
  // const tabButtons = document.querySelectorAll('.tab-button');
  // const tabContents = document.querySelectorAll('.tab-content');

  // tabButtons.forEach(button => {
  //   button.addEventListener('click', () => {
  //     // Remove active class from all buttons and hide all content
  //     tabButtons.forEach(btn => btn.classList.remove('active'));
  //     tabContents.forEach(content => content.classList.add('hidden'));

  //     // Add active class to the clicked button
  //     button.classList.add('active');

  //     // Show the corresponding content
  //     const targetTab = button.dataset.tab;
  //     document.getElementById(`${targetTab}-content`).classList.remove('hidden');
  //   });
  // });





});
