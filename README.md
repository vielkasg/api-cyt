# Munitrans API - Backend para Gestión de Transporte Municipal

API RESTful desarrollada con **CodeIgniter 4**, utilizada por la app Munitrans para gestionar permisos de circulación, multas, recaudaciones y rutas del transporte público.

## Funcionalidades expuestas

- Autenticación de usuarios
- Validación de permisos mediante código QR
- Registro y consulta de multas
- Gestión de recaudaciones
- Información de franjas y rutas
- Conexión con base de datos MySQL

---

## Requisitos

- PHP 8.x
- Composer
- MySQL
- Servidor local (XAMPP, Laragon, etc.)

---

## Instalación

1. Clonar el repositorio

-bash
git clone https://github.com/vielkasg/api-cyt.git
cd api-cyt

2. Instalar dependencias
-bash
composer install

3. Ejecutar el servidor
-bash
php spark serve

La API estará disponible en:
http://localhost:8080

