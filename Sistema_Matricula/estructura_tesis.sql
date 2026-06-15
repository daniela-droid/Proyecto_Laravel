-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: sistema_matricula
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian


--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuarios` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Cargo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_id_usuarios_unique` (`id_usuarios`)
);

--
-- Table structure for table `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Código` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `asignaturas_código_unique` (`Código`)
);

--
-- Table structure for table `aulas`
--

CREATE TABLE `aulas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Capacidad` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `cache_key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`cache_key`)
);

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `cache_key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`cache_key`)
);

--
-- Table structure for table `comarcas`
--

CREATE TABLE `comarcas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Comarca` varchar(255) NOT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `cortes_evaluativos`
--

CREATE TABLE `cortes_evaluativos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_modalidades` bigint(20) unsigned NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ponderacion` int(11) NOT NULL,
  `id_periodo_academicos` bigint(20) unsigned NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cortes_evaluativos_id_modalidades_foreign` (`id_modalidades`),
  KEY `cortes_evaluativos_id_periodo_academicos_foreign` (`id_periodo_academicos`)
);

--
-- Table structure for table `docentes`
--

CREATE TABLE `docentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `FechadeNacimiento` date NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `id_especialidads` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `docentes_id_usuario_unique` (`id_usuario`),
  KEY `docentes_id_especialidads_foreign` (`id_especialidads`),
  CONSTRAINT `docentes_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
);

--
-- Table structure for table `especialidads`
--

CREATE TABLE `especialidads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Especialidad` varchar(255) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Código_Persona` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Sexo` varchar(255) NOT NULL,
  `Fecha_N` date NOT NULL,
  `Celular` int(11) NOT NULL,
  `id_padre` bigint(20) unsigned DEFAULT NULL,
  `id_comarca` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `estudiantes_id_padre_foreign` (`id_padre`),
  KEY `estudiantes_id_comarca_foreign` (`id_comarca`)
);

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
);

--
-- Table structure for table `grados`
--

CREATE TABLE `grados` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Nivel` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Código` varchar(255) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `id_turno` bigint(20) unsigned NOT NULL,
  `id_grado` bigint(20) unsigned NOT NULL,
  `id_periodo_academicos` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `grupos_id_turno_foreign` (`id_turno`),
  KEY `grupos_id_grado_foreign` (`id_grado`),
  KEY `grupos_id_periodo_academicos_foreign` (`id_periodo_academicos`)
);

--
-- Table structure for table `horarios`
--

CREATE TABLE `horarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo` bigint(20) unsigned NOT NULL,
  `id_asignatura` bigint(20) unsigned NOT NULL,
  `id_docente` bigint(20) unsigned NOT NULL,
  `id_aula` bigint(20) unsigned NOT NULL,
  `Dia_semana` enum('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado') NOT NULL,
  `Hora_inicio` time NOT NULL,
  `Hora_fin` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `horarios_id_grupo_foreign` (`id_grupo`),
  KEY `horarios_id_asignatura_foreign` (`id_asignatura`),
  KEY `horarios_id_docente_foreign` (`id_docente`),
  KEY `horarios_id_aula_foreign` (`id_aula`)
);

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
);

--
-- Table structure for table `matriculas`
--

CREATE TABLE `matriculas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_estudiante` bigint(20) unsigned NOT NULL,
  `id_grupo` bigint(20) unsigned NOT NULL,
  `id_periodo_academicos` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `fecha_matricula` date NOT NULL,
  `estado` enum('Activo','Retirado','Suspendido','Expulsado') NOT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matriculas_id_estudiante_foreign` (`id_estudiante`),
  KEY `matriculas_id_grupo_foreign` (`id_grupo`),
  KEY `matricula_id_periodo_academicos_foreign` (`id_periodo_academicos`),
  KEY `matriculas_id_usuario_foreign` (`id_usuario`)
);

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `modalidades`
--

CREATE TABLE `modalidades` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `notas`
--

CREATE TABLE `notas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_matricula` bigint(20) unsigned NOT NULL,
  `id_horario` bigint(20) unsigned NOT NULL,
  `id_corte_evaluativo` bigint(20) unsigned NOT NULL,
  `id_usuario` bigint(20) unsigned NOT NULL,
  `nota_normal` double DEFAULT NULL,
  `nota_especial` double DEFAULT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notas_id_matricula_foreign` (`id_matricula`),
  KEY `notas_id_horario_foreign` (`id_horario`),
  KEY `notas_id_corte_evaluativo_foreign` (`id_corte_evaluativo`),
  KEY `notas_id_usuario_foreign` (`id_usuario`)
);

--
-- Table structure for table `padres`
--

CREATE TABLE `padres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre_o_Tutor` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Cedula` varchar(255) NOT NULL,
  `Telefono` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `periodo_academicos`
--

CREATE TABLE `periodo_academicos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Fecha_inicio` date NOT NULL,
  `Fecha_fin` date NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
);

--
-- Table structure for table `reportes_admins`
--

CREATE TABLE `reportes_admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_admin` bigint(20) unsigned NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria` enum('sistema','infraestructura','personal','otros') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportes_admins_id_admin_foreign` (`id_admin`),
  CONSTRAINT `reportes_admins_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id`)
);

--
-- Table structure for table `reportes_docentes`
--

CREATE TABLE `reportes_docentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_docente` bigint(20) unsigned NOT NULL,
  `id_estudiante` bigint(20) unsigned NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` enum('conducta','rendimiento','asistencia') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reportes_docentes_id_docente_foreign` (`id_docente`),
  KEY `reportes_docentes_id_estudiante_foreign` (`id_estudiante`),
  CONSTRAINT `reportes_docentes_id_docente_foreign` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id`),
  CONSTRAINT `reportes_docentes_id_estudiante_foreign` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id`)
);

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
);

--
-- Table structure for table `turnos`
--

CREATE TABLE `turnos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','docentes') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuarios_email_unique` (`Email`)
);


-- Dump completed on 2026-03-26 14:31:22
