# tramites-omr
Prueba tecnica para desarrollador fullstack en omr - El Organismo de Mejora Regulatoria (OMR) necesita una aplicación web sencilla para el registro y consulta de Trámites Administrativos. El sistema debe permitir registrar trámites con su información básica, gestionar las instituciones que los administran y consultar el catálogo de manera paginada.


## Estructura del repositorio

```
tramites-omr
├──tramites-api <- Backend Laravel 10 + SQLite
│   ├──app
│   │   ├──Exceptions
│   │   │   └──Handler.php
│   │   ├──Http
│   │   │   ├──Controllers
│   │   │   │   ├──InstitucionController.php
│   │   │   │   └──TramiteController.php
│   │   │   ├──Requests
│   │   │   │   ├──StoreInstitucionRequest.php
│   │   │   │   ├──StoreTramiteRequest.php
│   │   │   │   └──UpdateTramiteRequest.php
│   │   │   ├──Resources
│   │   │   │   ├──InstitucionResource.php
│   │   │   │   └──TramiteResource.php
│   │   ├──Models
│   │   │   ├──Institucion.php
│   │   │   ├──Tramite.php
│   │   └──Services
│   │   │   ├──InstitucionService.php
│   │   │   └──TramiteService.php
│   ├──database
│   │   ├──migrations
│   │   │   ├──2026_05_12_211559_create_instituciones_table.php
│   │   │   └──2026_05_12_211617_create_tramites_table.php
│   │   ├──seeders
│   │   │   ├──DatabaseSeeder.php
│   │   │   ├──InstitucionSeeder.php
│   │   │   └──TramiteSeeder.php
│   │   ├──database.sqlite
│   ├──routes
│   │   ├──api.php
│   ├──.env
├──tramites-app <- Frontend Vue 3 + Vite
│   ├──src
│   │   ├──assets
│   │   │   └──main.css
│   │   ├──components
│   │   │   ├──Alert.vue
│   │   │   ├──AppNavbar.vue
│   │   │   ├──ConfirmModal.vue
│   │   │   ├──Pagination.vue
│   │   │   ├──TramitesFiltros.vue
│   │   │   └──TramitesTable.vue
│   │   ├──router
│   │   │   └──index.js
│   │   ├──services
│   │   │   └──api.js
│   │   ├──views
│   │   │   ├──InstitucionForm.vue
│   │   │   ├──TramiteForm.vue
│   │   │   └──TramitesList.vue
│   │   ├──App.vue
│   │   └──main.js
└──README.md
```

## Tiempo invertido

| Módulo | Tarea | Tiempo |
|--------|-------|--------|
| Backend | Migraciones y Modelos | 40min |
| Backend | Requests y Resources | 50min |
| Backend | Services y Controladores | 50min |
| Backend | Rutas y Seeders | 40min |
| **Subtotal Backend** | | **3h** |
| Frontend | CSS global | 1h |
| Frontend | Componentes reutilizables | 3h 30min |
| Frontend | Vistas y consumo de API | 2h |
| Frontend | Ajustes finales | 30min |
| **Subtotal Frontend** | | **7h** |
| General | README | 40min |
| **Total** | | **10h 40min** |

## Decisiones técnicas

- **Laravel 10 + SQLite**: Elegido por la simplicidad de configuración y cumplir el requisito de base de datos en archivo local.
- **Vue 3 + Composition API**: Ofrece mejor organización del código y tipado más claro que Options API.
- **Vite**: Servidor de desarrollo más rápido que Vue CLI.
- **CSS propio sin librerías**: Evita problemas de compatibilidad y dependencias adicionales, manteniendo el bundle pequeño.
- **Capa de Services en el backend**: Separa la lógica de negocio de los controladores, siguiendo el principio de responsabilidad única.
- **JsonResource de Laravel**: Garantiza una respuesta JSON consistente en todos los endpoints.
- **Validación en dos capas**: Cliente (Vue) para feedback inmediato + servidor (Form Request) como fuente de verdad.

## Inicio rápido

### Backend
    cd tramites-api
    composer install
    php artisan serve

### Frontend
    cd tramites-app
    npm install
    npm run dev