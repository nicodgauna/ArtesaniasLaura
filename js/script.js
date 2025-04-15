// Carrito de compras
let cart = [];

// Función para manejar el menú móvil y el carrito
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

    // Cargar carrito desde localStorage si existe
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
        updateCartUI();
    }

    // Toggle del carrito
    const cartToggle = document.getElementById('cart-toggle');
    const cartDropdown = document.querySelector('.cart-dropdown');
    const overlay = document.querySelector('.overlay');

    if (cartToggle) {
        cartToggle.addEventListener('click', function(e) {
            e.preventDefault();
            cartDropdown.classList.toggle('active');
            overlay.classList.toggle('active');
            
            // Si el carrito está vacío, mostrar mensaje
            if (cart.length === 0) {
                const cartItems = document.querySelector('.cart-items');
                cartItems.innerHTML = '<div class="empty-cart-message">Tu carrito está vacío</div>';
            }
        });
    }

    // Cerrar el carrito al hacer clic en el overlay
    if (overlay) {
        overlay.addEventListener('click', function() {
            cartDropdown.classList.remove('active');
            overlay.classList.remove('active');
        });
    }

    // Botones de añadir al carrito
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productCard = this.closest('.product-card');
            const productId = productCard.dataset.id;
            const productName = productCard.dataset.name;
            const productPrice = parseFloat(productCard.dataset.price);
            const productImage = productCard.querySelector('.product-image img').src;
            
            // Verificar si el producto ya está en el carrito
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    image: productImage,
                    quantity: 1
                });
            }
            
            // Guardar carrito en localStorage
            localStorage.setItem('cart', JSON.stringify(cart));
            
            // Actualizar UI del carrito
            updateCartUI();
            
            // Mostrar el carrito
            cartDropdown.classList.add('active');
            overlay.classList.add('active');
        });
    });

    // Inicializar el slider de productos
    initProductSlider();
});

// Función para actualizar la UI del carrito
function updateCartUI() {
    const cartItems = document.querySelector('.cart-items');
    const cartTotal = document.querySelector('.cart-total span');
    const cartCount = document.querySelector('.cart-count');
    
    // Actualizar contador del carrito
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    cartCount.textContent = totalItems;
    
    // Si el carrito está vacío
    if (cart.length === 0) {
        cartItems.innerHTML = '<div class="empty-cart-message">Tu carrito está vacío</div>';
        cartTotal.textContent = '$0.00';
        return;
    }
    
    // Limpiar contenedor de items
    cartItems.innerHTML = '';
    
    // Añadir cada item al carrito
    cart.forEach(item => {
        const cartItemElement = document.createElement('div');
        cartItemElement.classList.add('cart-item');
        cartItemElement.innerHTML = `
            <div class="cart-item-image">
                <img src="${item.image}" alt="${item.name}">
            </div>
            <div class="cart-item-details">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-price">$${item.price.toFixed(2)}</div>
            </div>
            <div class="cart-item-quantity">
                <button class="decrease-quantity" data-id="${item.id}">-</button>
                <span>${item.quantity}</span>
                <button class="increase-quantity" data-id="${item.id}">+</button>
            </div>
            <div class="cart-item-remove" data-id="${item.id}">
                <i class="fas fa-trash"></i>
            </div>
        `;
        
        cartItems.appendChild(cartItemElement);
    });
    
    // Calcular y mostrar el total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    cartTotal.textContent = `$${total.toFixed(2)}`;
    
    // Añadir event listeners para los botones de cantidad y eliminar
    addCartItemEventListeners();
}

// Función para añadir event listeners a los items del carrito
function addCartItemEventListeners() {
    // Botones para aumentar cantidad
    const increaseButtons = document.querySelectorAll('.increase-quantity');
    increaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity += 1;
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            }
        });
    });
    
    // Botones para disminuir cantidad
    const decreaseButtons = document.querySelectorAll('.decrease-quantity');
    decreaseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const item = cart.find(item => item.id === id);
            if (item) {
                if (item.quantity > 1) {
                    item.quantity -= 1;
                } else {
                    // Si la cantidad es 1, eliminar el item
                    const index = cart.findIndex(cartItem => cartItem.id === id);
                    if (index !== -1) {
                        cart.splice(index, 1);
                    }
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            }
        });
    });
    
    // Botones para eliminar items
    const removeButtons = document.querySelectorAll('.cart-item-remove');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const index = cart.findIndex(item => item.id === id);
            if (index !== -1) {
                cart.splice(index, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartUI();
            }
        });
    });
}

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