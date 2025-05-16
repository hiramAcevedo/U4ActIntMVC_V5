# Hiram U4ActInt - Gestor de Archivos e Imágenes

[![Repositorio GitHub](https://img.shields.io/badge/GitHub-Repositorio-blue?logo=github)](https://github.com/hiramAcevedo/U4ActIntMVC_V5)

Una aplicación web para gestionar archivos e imágenes con roles de usuario y administrador, desarrollada con Laravel y Tailwind CSS.

## 🌟 Características

- **Gestión de archivos**: Subir, descargar, visualizar y eliminar archivos
- **Galería de imágenes**: Con vista previa y ordenamiento por arrastrar y soltar
- **Sistema de favoritos**: Marcar archivos e imágenes como favoritos
- **Panel de administración**: Para gestionar usuarios y sus archivos
- **Autenticación completa**: Registro, inicio de sesión y recuperación de contraseña
- **Roles de usuario**: Administrador y usuario regular
- **Exportación de datos**: En formatos Excel, PDF y Word
- **Diseño responsivo**: Adaptable a dispositivos móviles y escritorio

## 🛠️ Requisitos

- PHP 8.1 o superior
- Composer
- Node.js y npm
- MySQL, PostgreSQL o SQLite
- Extensiones PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## 🔄 Actualizaciones Recientes

- **Sistema de permisos mejorado**: Se implementó AuthServiceProvider con Gate para verificación de roles de administrador
- **Interfaz de navegación optimizada**: Enlaces de administración más intuitivos y consistentes
- **Resolución de bugs**: Corrección de errores 404 en rutas de archivos e imágenes
- **Estructura de almacenamiento**: Mejor organización de archivos con enlaces simbólicos correctamente configurados

## 🚀 Opciones de Despliegue

### Despliegue Local

1. Clona este repositorio:
```bash
git clone <url-del-repositorio>
cd u4actint
```

2. Instala dependencias:
```bash
composer install
npm install
```

3. Configura el entorno:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configura la base de datos en el archivo `.env`:
```
DB_CONNECTION=sqlite # o mysql, pgsql
DB_DATABASE=/ruta/absoluta/a/database.sqlite # para SQLite
```

5. Crea el enlace simbólico para el almacenamiento:
```bash
php artisan storage:link
```

6. Ejecuta las migraciones y seeders:
```bash
php artisan migrate --seed
```

7. Inicia los servidores:
```bash
# Terminal 1: backend
php artisan serve

# Terminal 2: frontend
npm run dev
```

8. Accede a la aplicación: [http://localhost:8000](http://localhost:8000)

### Despliegue en Railway (Recomendado)

Railway es una plataforma ideal para proyectos Laravel pues permite desplegar tanto el backend como la base de datos fácilmente.

1. Crea una cuenta en [Railway](https://railway.app/)
2. Desde el dashboard, crea un nuevo proyecto y selecciona "Deploy from GitHub"
3. Conecta tu repositorio de GitHub
4. Railway detectará automáticamente que es un proyecto Laravel
5. Añade un servicio de base de datos MySQL o PostgreSQL
6. Configura las variables de entorno:
   - `APP_URL` = URL de tu aplicación en Railway
   - `DB_CONNECTION` = mysql o pgsql
   - `DB_HOST` = ${{DATABASE_HOST}}
   - `DB_PORT` = ${{DATABASE_PORT}}
   - `DB_DATABASE` = ${{DATABASE_NAME}}
   - `DB_USERNAME` = ${{DATABASE_USERNAME}}
   - `DB_PASSWORD` = ${{DATABASE_PASSWORD}}
7. Railway desplegará automáticamente la aplicación

### Despliegue Frontend en Vercel + Backend en Railway

Para una arquitectura separada, puedes:

1. Desplegar el backend y la base de datos en Railway (siguiendo los pasos anteriores)
2. Configurar el frontend en Vercel:
   - Crea una cuenta en [Vercel](https://vercel.com/)
   - Importa tu repositorio
   - Configura la variable `API_URL` para que apunte a tu backend en Railway
   - Despliega la aplicación

## ⚠️ Consideraciones Importantes

### Sobre la Base de Datos

- Para producción, recomendamos usar MySQL o PostgreSQL
- Para desarrollo local, puedes usar SQLite para mayor simplicidad
- Railway proporciona bases de datos gestionadas que son ideales para proyectos Laravel

### Arquitectura de Almacenamiento de Archivos

La aplicación almacena archivos en:
- Imágenes: `storage/app/public/images/`
- Documentos: `storage/app/public/files/`

Es crucial crear el enlace simbólico con `php artisan storage:link` para que estos archivos sean accesibles públicamente.

## 🔑 Credenciales de Prueba

**Administrador:**
- Email: admin@example.com
- Password: admin123

**Usuario Regular:**
- Email: test@example.com
- Password: password

## 📝 Comandos Útiles

```bash
# Compilar assets para producción
npm run build

# Limpiar caché
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Ejecutar pruebas
php artisan test

# Ver rutas disponibles
php artisan route:list
```

## 🔍 Solución de Problemas

### Error 404 en rutas de archivos e imágenes
1. Verifica que el enlace simbólico esté creado correctamente:
   ```bash
   php artisan storage:link
   ```
2. Asegúrate de que los directorios tengan permisos adecuados:
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```
3. Comprueba que las rutas en la base de datos apunten correctamente a `storage/images/` o `storage/files/`

### Error de conexión a la base de datos
1. Verifica las credenciales en el archivo `.env`
2. Para SQLite, asegúrate de que el archivo exista y tenga permisos correctos
3. Para MySQL/PostgreSQL, confirma que el servicio esté activo

## 🧪 Estructura de la Aplicación

```
app/
├── Http/
│   ├── Controllers/       # Controladores
│   │   └── FileController.php  # Gestión de archivos
│   ├── Middleware/        # Middleware de autenticación y roles
│   └── Models/            # Modelos
│       └── UserFile.php   # Modelo para archivos de usuario
├── ...
resources/
├── views/
│   ├── files/            # Vistas para gestión de archivos
│   │   ├── index.blade.php
│   │   └── images.blade.php
│   └── ...
storage/app/public/
    ├── files/            # Almacenamiento de documentos
    └── images/           # Almacenamiento de imágenes
```

## 📄 Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).

## 🔗 Enlaces

- [Repositorio en GitHub](https://github.com/hiramAcevedo/U4ActIntMVC_V5)
- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Tailwind CSS](https://tailwindcss.com/docs)
