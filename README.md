# Proyecto_Laravel
#Sistema de Gestión Académica
#Proyecto de Tesis - Ingeniería de Sistemas > Desarrollado por: Daniela Paola Vega

#Nicaragua | 2026

 #Descripción
#Este sistema está diseñado para automatizar y optimizar los procesos de matrícula y control académico. Permite la #gestión centralizada de estudiantes, grupos, periodos académicos y usuarios, asegurando la integridad de los datos #mediante una arquitectura de base de datos normalizada.

 #Tecnologías Utilizadas
#Backend: Laravel (PHP)

#Frontend: Blade, Bootstrap, DataTables, FontAwesome

#Base de Datos: MySQL / MariaDB (20 tablas normalizadas)

#Entorno de Desarrollo: Debian 13 (Trixie)

#Herramientas: Git, Apache2, , Composer , AdminLTE

#Características Principales
#Módulo de Matrículas: Registro automatizado vinculando estudiante, grupo y periodo.

#Búsqueda Avanzada: Implementación de Modals con DataTables para selección rápida de registros.

#Seguridad: Gestión de sesiones y filtros de seguridad con Middleware con roles definidos de admin y docente.

#Interfaz Minimalista: Diseño enfocado en la usabilidad y la eficiencia operativa.

#Instalación y Configuración
#Si necesitas clonar este proyecto en otro entorno, sigue estos pasos:

#Clonar el repositorio:

#Bash
#git clone https://github.com/daniela-droid/Proyecto_Laravel.git
#cd tu-repositorio o directorio
#Instalar dependencias:

#Bash
#composer install
#npm install && npm run dev
#tambien bajarte adminLTE
#nmp install adminLTE

#Configurar el entorno:

#Copiar el archivo de ejemplo: cp .env.example .env

#Generar la clave de la aplicación: php artisan key:generate

#Configurar tus credenciales de base de datos en el .env.

#Migraciones y Seeders:

#Bash
#php artisan migrate --seed
#Iniciar servidor:

#Bash
#php artisan serve