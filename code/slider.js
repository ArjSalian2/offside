// slide function for the home page
let slideIndex= 0;
const slides= document.querySelector(".slides");
const images= document.querySelectorAll(".slide");
const prevButton= document.querySelector(".prev");
const nextButton= document.querySelector(".next");
const visibleSlides= 3;

const slideWidth = 100 / visibleSlides;

prevButton.style.display= "block";
nextButton.style.display= "block";

function toggleArrowVisbility(){
  nextButton.style.display= slideIndex + visibleSlides>= images.length ? "none" : "block";
  prevButton.style.display= slideIndex<= 0 ? "none": "block"; 
}

function moveSlide(n){
  slideIndex += n;

  if(slideIndex < 0){
    slideIndex = 0;
  } else if(slideIndex > images.length-visibleSlides){
    slideIndex = images.length - visibleSlides;
  }
  slides.style.transform = `translateX(-${slideIndex * slideWidth}%)`;
 toggleArrowVisbility();
}
toggleArrowVisbility();


