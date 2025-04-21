// Función para manejar el menú móvil
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar el año en el footer
    document.getElementById('year').textContent = new Date().getFullYear();

    // Menú móvil
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            // Cambiar el icono del menú
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }

    // Manejo de dropdowns en móvil
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        // Solo para dispositivos móviles
        if (window.innerWidth <= 768) {
            const link = dropdown.querySelector('a');
            
            link.addEventListener('click', function(e) {
                // Prevenir la navegación
                e.preventDefault();
                // Toggle la clase active para mostrar/ocultar el dropdown
                dropdown.classList.toggle('active');
            });
        }
    });

    // Cerrar el menú al hacer clic fuera de él
    document.addEventListener('click', function(e) {
        if (!navMenu.contains(e.target) && !menuToggle.contains(e.target) && navMenu.classList.contains('active')) {
            navMenu.classList.remove('active');
            const icon = menuToggle.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Inicializar el slider de productos
    initProductSlider();
});

// Función para inicializar el slider de productos
function initProductSlider() {
    const sliderTrack = document.querySelector('.product-slider-track');
    const prevArrow = document.querySelector('.prev-arrow');
    const nextArrow = document.querySelector('.next-arrow');
    const dotsContainer = document.querySelector('.slider-dots');
    
    if (!sliderTrack) return;
    
    const productCards = sliderTrack.querySelectorAll('.product-card');
    const cardWidth = productCards[0].offsetWidth + 20; // Ancho + margen
    const visibleCards = getVisibleCardsCount();
    const totalSlides = Math.ceil(productCards.length / visibleCards);
    let currentSlide = 0;
    
    // Crear dots para navegación
    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('div');
        dot.classList.add('slider-dot');
        if (i === 0) dot.classList.add('active');
        dot.dataset.slide = i;
        dotsContainer.appendChild(dot);
        
        dot.addEventListener('click', function() {
            goToSlide(parseInt(this.dataset.slide));
        });
    }
    
    // Event listeners para las flechas
    prevArrow.addEventListener('click', function() {
        if (currentSlide > 0) {
            goToSlide(currentSlide - 1);
        } else {
            goToSlide(totalSlides - 1); // Ir al último slide
        }
    });
    
    nextArrow.addEventListener('click', function() {
        if (currentSlide < totalSlides - 1) {
            goToSlide(currentSlide + 1);
        } else {
            goToSlide(0); // Volver al primer slide
        }
    });
    
    // Función para ir a un slide específico
    function goToSlide(slideIndex) {
        currentSlide = slideIndex;
        const offset = -slideIndex * visibleCards * cardWidth;
        sliderTrack.style.transform = `translateX(${offset}px)`;
        
        // Actualizar dots activos
        document.querySelectorAll('.slider-dot').forEach((dot, index) => {
            dot.classList.toggle('active', index === slideIndex);
        });
    }
    
    // Función para obtener el número de tarjetas visibles según el ancho de la pantalla
    function getVisibleCardsCount() {
        const windowWidth = window.innerWidth;
        if (windowWidth < 480) return 1;
        if (windowWidth < 768) return 2;
        if (windowWidth < 1024) return 3;
        return 4; // Por defecto, mostrar 4 tarjetas
    }
    
    // Actualizar el slider cuando cambia el tamaño de la ventana
    window.addEventListener('resize', function() {
        const newVisibleCards = getVisibleCardsCount();
        if (newVisibleCards !== visibleCards) {
            // Recalcular todo
            location.reload();
        }
    });
}