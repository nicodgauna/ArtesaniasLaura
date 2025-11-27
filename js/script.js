// Carrito de compras
let cart = []

// Función para manejar el menú móvil y el carrito
document.addEventListener("DOMContentLoaded", () => {
  // Actualizar el año en el footer
  const yearElement = document.getElementById("year")
  if (yearElement) {
    yearElement.textContent = new Date().getFullYear()
  }

  // Menú móvil
  const menuToggle = document.querySelector(".menu-toggle")
  const navMenu = document.querySelector(".nav-menu")

  if (menuToggle) {
    menuToggle.addEventListener("click", function () {
      navMenu.classList.toggle("active")
      // Cambiar el icono del menú
      const icon = this.querySelector("i")
      if (icon.classList.contains("fa-bars")) {
        icon.classList.remove("fa-bars")
        icon.classList.add("fa-times")
      } else {
        icon.classList.remove("fa-times")
        icon.classList.add("fa-bars")
      }
    })
  }

  // Manejo de dropdowns en móvil
  const dropdowns = document.querySelectorAll(".dropdown")

  dropdowns.forEach((dropdown) => {
    // Solo para dispositivos móviles
    if (window.innerWidth <= 768) {
      const link = dropdown.querySelector("a")

      if (link) {
        link.addEventListener("click", (e) => {
          // Prevenir la navegación
          e.preventDefault()
          // Toggle la clase active para mostrar/ocultar el dropdown
          dropdown.classList.toggle("active")
        })
      }
    }
  })

  // Cerrar el menú al hacer clic fuera de él
  document.addEventListener("click", (e) => {
    if (
      navMenu &&
      menuToggle &&
      !navMenu.contains(e.target) &&
      !menuToggle.contains(e.target) &&
      navMenu.classList.contains("active")
    ) {
      navMenu.classList.remove("active")
      const icon = menuToggle.querySelector("i")
      icon.classList.remove("fa-times")
      icon.classList.add("fa-bars")
    }
  })

  // Cargar carrito desde localStorage si existe
  if (localStorage.getItem("cart")) {
    cart = JSON.parse(localStorage.getItem("cart"))
    updateCartUI()
  }

  // Toggle del carrito
  const cartToggle = document.getElementById("cart-toggle")
  const cartDropdown = document.querySelector(".cart-dropdown")
  const overlay = document.querySelector(".overlay")

  if (cartToggle) {
    cartToggle.addEventListener("click", (e) => {
      e.preventDefault()
      cartDropdown.classList.toggle("active")
      overlay.classList.toggle("active")

      // Si el carrito está vacío, mostrar mensaje
      if (cart.length === 0) {
        const cartItems = document.querySelector(".cart-items")
        if (cartItems) {
          cartItems.innerHTML = '<div class="empty-cart-message">Tu carrito está vacío</div>'
        }
      }
    })
  }

  // Cerrar el carrito al hacer clic en el overlay
  if (overlay) {
    overlay.addEventListener("click", () => {
      cartDropdown.classList.remove("active")
      overlay.classList.remove("active")
    })
  }

  // Botones de añadir al carrito
  const addToCartButtons = document.querySelectorAll(".add-to-cart")

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const productCard = this.closest(".product-card")
      const productId = productCard.dataset.id
      const productName = productCard.dataset.name
      const productPrice = Number.parseFloat(productCard.dataset.price)
      const productImage = productCard.querySelector(".product-image img").src

      // Verificar si el producto ya está en el carrito
      const existingItem = cart.find((item) => item.id === productId)

      if (existingItem) {
        existingItem.quantity += 1
      } else {
        cart.push({
          id: productId,
          name: productName,
          price: productPrice,
          image: productImage,
          quantity: 1,
        })
      }

      // Guardar carrito en localStorage
      localStorage.setItem("cart", JSON.stringify(cart))

      // Actualizar UI del carrito
      updateCartUI()

      // Mostrar el carrito
      if (cartDropdown && overlay) {
        cartDropdown.classList.add("active")
        overlay.classList.add("active")
      }
    })
  })

  // Inicializar el slider de productos
  initProductSlider()

  initAdminLogin()

  initProductFilters()
})

// Función para actualizar la UI del carrito
function updateCartUI() {
  const cartItems = document.querySelector(".cart-items")
  const cartTotal = document.querySelector(".cart-total span")
  const cartCount = document.querySelector(".cart-count")

  if (!cartItems || !cartTotal || !cartCount) return

  // Actualizar contador del carrito
  const totalItems = cart.reduce((total, item) => total + item.quantity, 0)
  cartCount.textContent = totalItems

  // Si el carrito está vacío
  if (cart.length === 0) {
    cartItems.innerHTML = '<div class="empty-cart-message">Tu carrito está vacío</div>'
    cartTotal.textContent = "$0.00"
    return
  }

  // Limpiar contenedor de items
  cartItems.innerHTML = ""

  // Añadir cada item al carrito
  cart.forEach((item) => {
    const cartItemElement = document.createElement("div")
    cartItemElement.classList.add("cart-item")
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
        `

    cartItems.appendChild(cartItemElement)
  })

  // Calcular y mostrar el total
  const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0)
  cartTotal.textContent = `$${total.toFixed(2)}`

  // Añadir event listeners para los botones de cantidad y eliminar
  addCartItemEventListeners()
}

// Función para añadir event listeners a los items del carrito
function addCartItemEventListeners() {
  // Botones para aumentar cantidad
  const increaseButtons = document.querySelectorAll(".increase-quantity")
  increaseButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.dataset.id
      const item = cart.find((item) => item.id === id)
      if (item) {
        item.quantity += 1
        localStorage.setItem("cart", JSON.stringify(cart))
        updateCartUI()
      }
    })
  })

  // Botones para disminuir cantidad
  const decreaseButtons = document.querySelectorAll(".decrease-quantity")
  decreaseButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.dataset.id
      const item = cart.find((item) => item.id === id)
      if (item) {
        if (item.quantity > 1) {
          item.quantity -= 1
        } else {
          // Si la cantidad es 1, eliminar el item
          const index = cart.findIndex((cartItem) => cartItem.id === id)
          if (index !== -1) {
            cart.splice(index, 1)
          }
        }
        localStorage.setItem("cart", JSON.stringify(cart))
        updateCartUI()
      }
    })
  })

  // Botones para eliminar items
  const removeButtons = document.querySelectorAll(".cart-item-remove")
  removeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.dataset.id
      const index = cart.findIndex((item) => item.id === id)
      if (index !== -1) {
        cart.splice(index, 1)
        localStorage.setItem("cart", JSON.stringify(cart))
        updateCartUI()
      }
    })
  })
}

// Función para inicializar el slider de productos
function initProductSlider() {
  const sliderTrack = document.querySelector(".product-slider-track")
  const prevArrow = document.querySelector(".prev-arrow")
  const nextArrow = document.querySelector(".next-arrow")
  const dotsContainer = document.querySelector(".slider-dots")

  if (!sliderTrack) return

  const productCards = sliderTrack.querySelectorAll(".product-card")
  if (productCards.length === 0) return

  const cardWidth = productCards[0].offsetWidth + 20 // Ancho + margen
  const visibleCards = getVisibleCardsCount()
  const totalSlides = Math.ceil(productCards.length / visibleCards)
  let currentSlide = 0

  // Crear dots para navegación
  if (dotsContainer) {
    dotsContainer.innerHTML = ""
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement("div")
      dot.classList.add("slider-dot")
      if (i === 0) dot.classList.add("active")
      dot.dataset.slide = i
      dotsContainer.appendChild(dot)

      dot.addEventListener("click", function () {
        goToSlide(Number.parseInt(this.dataset.slide))
      })
    }
  }

  // Event listeners para las flechas
  if (prevArrow) {
    prevArrow.addEventListener("click", () => {
      if (currentSlide > 0) {
        goToSlide(currentSlide - 1)
      } else {
        goToSlide(totalSlides - 1) // Ir al último slide
      }
    })
  }

  if (nextArrow) {
    nextArrow.addEventListener("click", () => {
      if (currentSlide < totalSlides - 1) {
        goToSlide(currentSlide + 1)
      } else {
        goToSlide(0) // Volver al primer slide
      }
    })
  }

  // Función para ir a un slide específico
  function goToSlide(slideIndex) {
    currentSlide = slideIndex
    const offset = -slideIndex * visibleCards * cardWidth
    sliderTrack.style.transform = `translateX(${offset}px)`

    // Actualizar dots activos
    document.querySelectorAll(".slider-dot").forEach((dot, index) => {
      dot.classList.toggle("active", index === slideIndex)
    })
  }

  // Función para obtener el número de tarjetas visibles según el ancho de la pantalla
  function getVisibleCardsCount() {
    const windowWidth = window.innerWidth
    if (windowWidth < 480) return 1
    if (windowWidth < 768) return 2
    if (windowWidth < 1024) return 3
    return 4 // Por defecto, mostrar 4 tarjetas
  }

  // Actualizar el slider cuando cambia el tamaño de la ventana
  window.addEventListener("resize", () => {
    const newVisibleCards = getVisibleCardsCount()
    if (newVisibleCards !== visibleCards) {
      // Recalcular todo
      location.reload()
    }
  })
}

function initAdminLogin() {
  const loginForm = document.getElementById("admin-login-form")
  const togglePassword = document.getElementById("toggle-password")
  const passwordInput = document.getElementById("password")

  // Toggle para mostrar/ocultar contraseña
  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("click", function () {
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
      passwordInput.setAttribute("type", type)

      const icon = this.querySelector("i")
      if (type === "password") {
        icon.classList.remove("fa-eye-slash")
        icon.classList.add("fa-eye")
      } else {
        icon.classList.remove("fa-eye")
        icon.classList.add("fa-eye-slash")
      }
    })
  }

  // Manejo del formulario de login
  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault()

      const username = document.getElementById("username").value
      const password = document.getElementById("password").value
      const remember = document.getElementById("remember").checked

      // Validación básica
      if (!username || !password) {
        showMessage("Por favor, completa todos los campos", "error")
        return
      }

      // Aquí puedes añadir la lógica para enviar los datos al servidor PHP
      // Por ahora, simulamos una validación
      if (username === "admin" && password === "admin123") {
        showMessage("Login exitoso", "success")
        // Redirigir al panel de administración
        setTimeout(() => {
          window.location.href = "admin-panel.html"
        }, 1500)
      } else {
        showMessage("Usuario o contraseña incorrectos", "error")
      }
    })
  }
}

function initProductFilters() {
  const categoryFilter = document.getElementById("category-filter")
  const priceFilter = document.getElementById("price-filter")
  const sortFilter = document.getElementById("sort-filter")
  const searchInput = document.getElementById("search-input")
  const clearFiltersBtn = document.getElementById("clear-filters")

  // Filtro por categoría
  if (categoryFilter) {
    categoryFilter.addEventListener("change", applyFilters)
  }

  // Filtro por precio
  if (priceFilter) {
    priceFilter.addEventListener("change", applyFilters)
  }

  // Ordenamiento
  if (sortFilter) {
    sortFilter.addEventListener("change", applyFilters)
  }

  // Búsqueda
  if (searchInput) {
    searchInput.addEventListener("input", debounce(applyFilters, 300))
  }

  // Limpiar filtros
  if (clearFiltersBtn) {
    clearFiltersBtn.addEventListener("click", () => {
      if (categoryFilter) categoryFilter.value = ""
      if (priceFilter) priceFilter.value = ""
      if (sortFilter) sortFilter.value = ""
      if (searchInput) searchInput.value = ""
      applyFilters()
    })
  }
}

function applyFilters() {
  const products = document.querySelectorAll(".product-card")
  const categoryFilter = document.getElementById("category-filter")
  const priceFilter = document.getElementById("price-filter")
  const sortFilter = document.getElementById("sort-filter")
  const searchInput = document.getElementById("search-input")

  let visibleProducts = Array.from(products)

  // Filtrar por categoría
  if (categoryFilter && categoryFilter.value) {
    visibleProducts = visibleProducts.filter((product) => product.dataset.category === categoryFilter.value)
  }

  // Filtrar por precio
  if (priceFilter && priceFilter.value) {
    const [min, max] = priceFilter.value.split("-").map(Number)
    visibleProducts = visibleProducts.filter((product) => {
      const price = Number.parseFloat(product.dataset.price)
      return max ? price >= min && price <= max : price >= min
    })
  }

  // Filtrar por búsqueda
  if (searchInput && searchInput.value) {
    const searchTerm = searchInput.value.toLowerCase()
    visibleProducts = visibleProducts.filter((product) => product.dataset.name.toLowerCase().includes(searchTerm))
  }

  // Ordenar productos
  if (sortFilter && sortFilter.value) {
    visibleProducts.sort((a, b) => {
      switch (sortFilter.value) {
        case "price-asc":
          return Number.parseFloat(a.dataset.price) - Number.parseFloat(b.dataset.price)
        case "price-desc":
          return Number.parseFloat(b.dataset.price) - Number.parseFloat(a.dataset.price)
        case "name-asc":
          return a.dataset.name.localeCompare(b.dataset.name)
        case "name-desc":
          return b.dataset.name.localeCompare(a.dataset.name)
        default:
          return 0
      }
    })
  }

  // Mostrar/ocultar productos
  products.forEach((product) => {
    product.style.display = "none"
  })

  visibleProducts.forEach((product) => {
    product.style.display = "block"
  })

  // Actualizar contador de productos
  const productCount = document.querySelector(".products-count")
  if (productCount) {
    productCount.textContent = `Mostrando ${visibleProducts.length} de ${products.length} productos`
  }
}

function showMessage(message, type = "info") {
  const messageDiv = document.createElement("div")
  messageDiv.className = `message message-${type}`
  messageDiv.textContent = message

  // Estilos inline para el mensaje
  messageDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 5px;
        color: white;
        font-weight: bold;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        ${type === "success" ? "background-color: #28a745;" : ""}
        ${type === "error" ? "background-color: #dc3545;" : ""}
        ${type === "info" ? "background-color: #17a2b8;" : ""}
    `

  document.body.appendChild(messageDiv)

  // Remover el mensaje después de 3 segundos
  setTimeout(() => {
    messageDiv.remove()
  }, 3000)
}

function debounce(func, wait) {
  let timeout
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout)
      func(...args)
    }
    clearTimeout(timeout)
    timeout = setTimeout(later, wait)
  }
}

function initPagination() {
  const paginationContainer = document.querySelector(".pagination")
  const productsPerPage = 12
  const products = document.querySelectorAll(".product-card")
  const totalPages = Math.ceil(products.length / productsPerPage)
  let currentPage = 1

  if (!paginationContainer || totalPages <= 1) return

  // Crear botones de paginación
  function createPaginationButtons() {
    paginationContainer.innerHTML = ""

    // Botón anterior
    const prevBtn = document.createElement("button")
    prevBtn.textContent = "Anterior"
    prevBtn.disabled = currentPage === 1
    prevBtn.addEventListener("click", () => goToPage(currentPage - 1))
    paginationContainer.appendChild(prevBtn)

    // Botones de números
    for (let i = 1; i <= totalPages; i++) {
      const pageBtn = document.createElement("button")
      pageBtn.textContent = i
      pageBtn.classList.toggle("active", i === currentPage)
      pageBtn.addEventListener("click", () => goToPage(i))
      paginationContainer.appendChild(pageBtn)
    }

    // Botón siguiente
    const nextBtn = document.createElement("button")
    nextBtn.textContent = "Siguiente"
    nextBtn.disabled = currentPage === totalPages
    nextBtn.addEventListener("click", () => goToPage(currentPage + 1))
    paginationContainer.appendChild(nextBtn)
  }

  // Ir a una página específica
  function goToPage(page) {
    if (page < 1 || page > totalPages) return

    currentPage = page
    const startIndex = (page - 1) * productsPerPage
    const endIndex = startIndex + productsPerPage

    products.forEach((product, index) => {
      product.style.display = index >= startIndex && index < endIndex ? "block" : "none"
    })

    createPaginationButtons()

    // Scroll al inicio de los productos
    const productsSection = document.querySelector(".products-grid")
    if (productsSection) {
      productsSection.scrollIntoView({ behavior: "smooth" })
    }
  }

  // Inicializar paginación
  createPaginationButtons()
  goToPage(1)
}

// Inicializar paginación cuando el DOM esté listo
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(initPagination, 100) // Pequeño delay para asegurar que los productos estén renderizados
})
