# Impulsa Local

Aplicación web de la **Alcaldía de Ciudad Nueva** para apoyar a pequeños emprendedores del municipio: el administrador registra a los emprendedores y publica capacitaciones, y los emprendedores se inscriben en ellas. El sistema permite además hacer seguimiento al avance de cada inscripción y consultar reportes.

Proyecto de la **Fase 3** del curso *Framework para el Desarrollo Web* (UNAD), grupo **202047928_3**.

## Equipo

| Integrante | Rol |
|---|---|
| Sebastián Calvo Osorio | Líder del proyecto |
| Jaime Arguelles | Desarrollo |
| Mariana León | Desarrollo y pruebas |
| Rous Zabaleta | Desarrollo y documentación |

## Tecnologías

- **Laravel 12** (PHP 8.2 o superior), patrón MVC
- **Laravel Breeze** para la autenticación (Blade, Tailwind CSS, Alpine.js)
- **MySQL** con **XAMPP** (Apache + MySQL)
- **Vite** y **npm** para compilar los estilos
- **Git y GitHub** con ramas y Pull Requests

## Funcionalidades

### Administrador
- Registrar emprendedores (**no existe registro público**: `/register` está cerrado).
- Crear, editar y eliminar capacitaciones.
- Ver las inscripciones de cada capacitación.
- Actualizar el estado y el avance (0 a 100) de cada inscripción. Al llegar a 100 queda como *Finalizado*.
- Consultar reportes: emprendedores activos, sectores más comunes y cursos más solicitados, con filtro por sector.

### Emprendedor
- Ver las capacitaciones disponibles con fecha y cupos restantes.
- Inscribirse en una capacitación, con control de cupo y de inscripciones duplicadas.
- Ver sus inscripciones y su avance.
- Actualizar su perfil (actividad económica, ubicación y teléfono).

El menú y el dashboard cambian según el rol del usuario. Las rutas del administrador están protegidas con el middleware `rol:administrador` (responde 403 a cualquier otro rol).

## Instalación (Windows con XAMPP)

**Requisitos:** XAMPP con PHP 8.2 o superior (extensión `intl` activada), Composer, Node.js LTS y Git.

1. Abre XAMPP y enciende **Apache** y **MySQL**.
2. Clona el proyecto e instala las dependencias:

```bash
cd C:\xampp\htdocs
git clone https://github.com/sebastianosorio-7/impulsa-local.git
cd impulsa-local
composer install
npm install
npm run build
copy .env.example .env
php artisan key:generate
```

3. Crea la base de datos y los datos iniciales. Si pregunta por crear la base `impulsa_local`, responde `yes`:

```bash
php artisan migrate --seed
```

4. Abre en el navegador: `http://localhost/impulsa-local/public`

Si la página se ve sin estilos, en el archivo `.env` pon `APP_URL=http://localhost/impulsa-local/public`, ejecuta `php artisan config:clear` y recarga con Ctrl + F5.

### Usuarios de prueba

| Rol | Correo | Contraseña |
|---|---|---|
| Administrador | `admin@impulsalocal.gov.co` | `Admin12345` |
| Emprendedor | Se crea desde el panel del administrador (menú **Emprendedores**) | La que se defina al registrarlo |

> Credenciales solo para pruebas en entorno local.

El seeder crea el administrador y 3 capacitaciones de ejemplo.

## División del trabajo

Cada integrante construyó funciones completas (ruta, controlador, vista y validación) en su propia rama, para no depender de los demás.

| Integrante | Responsabilidad |
|---|---|
| **Sebastián** | Registro de emprendedores por el administrador (CU01), cierre del registro público, seguimiento del progreso de inscripciones, dashboard y menú por rol, integración final de las ramas y pruebas |
| **Jaime** | Gestión de capacitaciones del administrador (CU05), catálogo para el emprendedor (CU06) y actualización del perfil (CU03) |
| **Mariana** | Inscripción con control de cupo (CU07), "Mis inscripciones" y listado de inscripciones del administrador |
| **Rous** | Reportes (CU09 y CU10) y documentación (esquemas de BackEnd y FrontEnd) |

### Flujo de trabajo con Git

- `main` es la versión estable: nadie trabaja directamente en ella.
- Cada tarea se hace en una rama propia creada desde `main` actualizado (`git checkout main`, `git pull`, `git checkout -b nombre-de-la-tarea`).
- Al terminar se abre un **Pull Request**. El líder lo revisa, lo prueba y lo une a `main`.
- Los Pull Requests (#1 al #5) y el historial de commits muestran el aporte de cada integrante.

## Pruebas y depuración

Antes de unir las ramas a `main` se probaron juntas en una rama de integración, recorriendo el flujo completo:

- [x] El administrador inicia sesión y registra emprendedores con distintos sectores
- [x] El administrador crea, edita y elimina capacitaciones
- [x] El emprendedor inicia sesión y ve el catálogo con cupos restantes
- [x] El emprendedor se inscribe y los cupos bajan en 1
- [x] Una segunda inscripción en el mismo curso es rechazada con un mensaje
- [x] "Mis inscripciones" muestra el curso
- [x] El administrador ve la inscripción y actualiza su avance
- [x] Los reportes muestran sectores y cursos más pedidos, y el filtro por sector funciona
- [x] Un emprendedor no puede entrar a las rutas del administrador (403)

Problemas encontrados y cómo se resolvieron:

| Problema | Causa | Solución |
|---|---|---|
| MySQL de XAMPP no arrancaba | El servicio `MySQL80` de Windows ocupaba el puerto 3306 | Detener y deshabilitar `MySQL80` |
| Error `hasRole()` en el menú | El modelo `User` no tenía ese método | Usar `Auth::user()->rol` y agregar `hasRole()` al modelo |
| Rutas con `role:` daban error | El alias del middleware se llama `rol` | Corregir a `rol:administrador` |
| `View [...] not found` | Vistas en carpeta equivocada o sin subir al repositorio | Mover y subir las vistas faltantes |
| Parámetro `{capacitacione}` en las rutas | Plural en español mal singularizado por Laravel | `->parameters(['capacitaciones' => 'capacitacion'])` |
| Error de columna `role` en reportes | La tabla usa `rol` | Corregir el nombre de la columna |
| Estilos nuevos no aparecían | Tailwind solo incluye las clases vistas al compilar | Ejecutar `npm run build` |
| Historial no relacionado en una rama | La rama venía de otro proyecto | No unirla; se rehízo el trabajo sobre `main` |
