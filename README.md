# Hiram U4ActInt - Gestor de Archivos

Una aplicación web para gestionar archivos e imágenes con roles de usuario y administrador, desarrollada con Laravel y Tailwind CSS.

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

4. Configura la base de datos en el archivo `.env`

5. Ejecuta las migraciones y seeders:
```bash
php artisan migrate --seed
```

6. Inicia los servidores:
```bash
# Terminal 1: backend
php artisan serve

# Terminal 2: frontend
npm run dev
```

7. Accede a la aplicación: [http://localhost:8000](http://localhost:8000)

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

### Arquitectura de Despliegue

Existen varias opciones, cada una con sus ventajas:

1. **Monolítica (Recomendada para principiantes)**
   - Todo junto en Railway
   - Simple de configurar y mantener

2. **Separada (Para mejor rendimiento)**
   - Frontend en Vercel
   - Backend API en Railway
   - Base de datos en Railway o servicio especializado

## 🔑 Credenciales de Prueba

**Administrador:**
- Email: admin@example.com
- Password: password

**Usuario Regular:**
- Email: user@example.com
- Password: password

## 📝 Comandos Útiles

```bash
# Compilar assets para producción
npm run build

# Limpiar caché
php artisan optimize:clear

# Ejecutar pruebas
php artisan test
```

## 📄 Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).
