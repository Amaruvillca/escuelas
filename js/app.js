let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        dots[i].classList.remove('active');
    });

   
    slides[index].classList.add('active');
    dots[index].classList.add('active');
}

function nextSlide() {
    
    currentIndex = (currentIndex + 1) % slides.length; 
    showSlide(currentIndex);
}


setInterval(nextSlide, 4000);


dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentIndex = index;
        showSlide(currentIndex);
    });
});


showSlide(currentIndex);
