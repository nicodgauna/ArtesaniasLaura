# Artesanías Laura 🧵

Aplicación web desarrollada para la gestión y exhibición de productos de
un comercio local.

El objetivo principal del proyecto fue brindar una solución simple para
mostrar productos online y permitir que potenciales clientes contacten
directamente al negocio, sin integración de pagos electrónicos ni
checkout.

------------------------------------------------------------------------

## 📌 Características principales

-   Catálogo de productos público
-   Visualización de detalle de productos
-   Panel de administración protegido
-   Gestión completa de productos (CRUD)
    -   Crear productos
    -   Editar productos
    -   Eliminar productos
    -   Visualizar listado
-   Carga de imágenes
-   Control de stock
-   Mensajes de confirmación y error
-   Diseño responsive para desktop y mobile
-   Contacto directo mediante WhatsApp

------------------------------------------------------------------------

## 🛠️ Tecnologías utilizadas

### Frontend

-   HTML5
-   CSS3
-   JavaScript
-   Font Awesome

### Backend

-   PHP

### Base de datos

-   MySQL

### Seguridad y funcionalidades

-   Sesiones PHP para autenticación
-   Prepared Statements (consultas preparadas)
-   Validación de formularios
-   Subida y gestión de archivos

------------------------------------------------------------------------

## 📂 Estructura del proyecto

``` bash
artesanias-laura/
│
├── admin/              # Panel administrativo
├── config/             # Configuración DB
├── css/                # Estilos
├── includes/           # Auth, logout y utilidades
├── js/                 # Scripts frontend
├── pages/              # Páginas de la vista del cliente
├── uploads/            # Imágenes subidas
├── IMAGENES/           # Assets estáticos
└── index.php           # Página principal
```

------------------------------------------------------------------------

## 🔐 Acceso administrador

El panel administrativo permite:

-   Alta de productos
-   Edición de información
-   Actualización de stock
-   Eliminación de productos

Acceso protegido mediante autenticación con sesión.

------------------------------------------------------------------------

## 📱 Responsive Design

El sitio fue adaptado para:

-   Desktop
-   Tablet
-   Mobile

Incluye navegación responsive y tablas adaptables.

------------------------------------------------------------------------

## 🚀 Instalación local

1.  Clonar repositorio

``` bash
git clone https://github.com/nicodgauna/artesaniaslaura
```

2.  Importar base de datos MySQL

3.  Configurar conexión en:

``` bash
config/conndb.php
```

4.  Ejecutar proyecto en servidor local (XAMPP, Laragon, etc.)

------------------------------------------------------------------------

## 🎯 Objetivo del proyecto

Proyecto desarrollado en base a requerimientos reales del cliente, quien
necesitaba:

-   Mostrar catálogo online
-   Gestionar productos internamente
-   Evitar pagos online
-   Facilitar contacto directo con clientes

------------------------------------------------------------------------

## 👨‍💻 Autor

**Nicolás Gauna**\
Desarrollador Full Stack Jr.

-   GitHub: https://github.com/nicodgauna
-   LinkedIn: https://www.linkedin.com/in/nicolas-gauna-510029115
