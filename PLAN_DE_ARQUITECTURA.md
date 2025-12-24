# Plan de Arquitectura de Vistas en Laravel

Este documento describe la estructura acordada para las plantillas Blade de Laravel, con el objetivo de asegurar un proyecto escalable, mantenible y bien organizado.

## 1. Estructura de Directorios

Organizaremos nuestras vistas dentro de `resources/views/` de la siguiente manera:

-   `layouts/`: Contendrá las plantillas base o "layouts" principales.
    -   `app.blade.php`: Será nuestra plantilla principal que incluirá el `header`, `footer` y los assets (CSS/JS) comunes para todo el sitio.

-   `pages/`: Contendrá las vistas específicas para cada página. Cada sección principal del sitio tendrá su propio subdirectorio para mayor claridad.
    -   `home/`: Para la página de inicio.
        -   `index.blade.php`
    -   `blog/`: Para las páginas relacionadas con el blog.
        -   `index.blade.php` (Listado de artículos)
        -   `show.blade.php` (Detalle de un artículo)
        -   `search.blade.php` (Resultados de búsqueda)
    -   `shop/`: Para las páginas de la tienda.
        -   `index.blade.php` (Listado de productos)
        -   `show.blade.php` (Detalle de un producto)
    -   *Y así sucesivamente para otras secciones...*

-   `components/`: Contendrá pequeños fragmentos de vista reutilizables. Los agruparemos en subdirectorios para mantener el orden, basándonos en la página o sección a la que pertenecen.
    -   `layouts/`: Componentes que forman parte de la estructura principal.
        -   `header.blade.php`
        -   `footer.blade.php`
    -   `home/`: Componentes específicos de la página de inicio.
        -   `slider.blade.php`
        -   `category-tabs.blade.php`
    -   `shop/`: Componentes generales para la tienda.
        -   `product-card.blade.php`
    -   `blog/`: Componentes específicos para el blog.
        -   `post-card.blade.php`
    -   *Cualquier otro elemento que se repita.*

## 2. Flujo de Trabajo

1.  **Crear el Layout Principal:** Tomaremos el `index.html` como base para crear `layouts/app.blade.php`.
2.  **Extraer Componentes:** Separaremos el `header` y el `footer` del layout principal y los guardaremos en `components/layouts/`. Haremos lo mismo con otras secciones reutilizables (sliders, banners, etc.), agrupándolos en sus respectivos directorios dentro de `components/`.
3.  **Crear la Vista de Página:** Crearemos la vista para la página de inicio en `pages/home/index.blade.php`. Esta vista extenderá el layout principal y utilizará los componentes que necesite.
4.  **Definir Rutas y Controladores:** Ajustaremos el archivo `routes/web.php` para que la ruta principal `/` llame a un método en un `HomeController`. Este controlador se encargará de obtener los datos dinámicos (desde la base de datos) y pasarlos a la vista.

Esta metodología nos permitirá tener un código limpio, reutilizable y fácil de mantener a medida que el proyecto crezca.
