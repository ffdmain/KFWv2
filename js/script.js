let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index) {
  slides.forEach(slide => slide.classList.remove('active'));
  slides[index].classList.add('active');
}

function changeSlide(n) {
  currentSlide = (currentSlide + n + totalSlides) % totalSlides;
  showSlide(currentSlide);
}

setInterval(() => changeSlide(1), 3000); // Change slide every 3 seconds (adjust as needed)
showSlide(currentSlide);

function calculatePrice() {
  const costPerGramSpan = document.getElementById('cost-per-gram');
      const pricePerGram = parseFloat(costPerGramSpan.textContent);
      const quantity = document.getElementById('quantity').value;
      const totalPrice = (pricePerGram * quantity).toFixed(2); // Calculate total price
      document.getElementById('total-price').textContent = totalPrice;
}

// JavaScript for changing transparency on scroll
window.addEventListener('scroll', function() {
  const header = document.querySelector('.home-header');
  const scrollPos = window.scrollY;

  if (scrollPos > 100) { // Change this value to adjust when the transparency changes
    header.style.backgroundColor = 'rgba(255, 255, 255, 1)'; // Fully opaque background
  } else {
    header.style.backgroundColor = 'rgba(255, 255, 255, 0.9)'; // Semi-transparent background
  }
});
