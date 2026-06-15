Enum "horarios_Dia_semana_enum" {
  "Lunes"
  "Martes"
  "Miercoles"
  "Jueves"
  "Viernes"
  "Sabado"
}

Enum "matriculas_estado_enum" {
  "Activo"
  "Retirado"
  "Suspendido"
  "Expulsado"
}

Enum "reportes_admins_categoria_enum" {
  "sistema"
  "infraestructura"
  "personal"
  "otros"
}

Enum "reportes_docentes_tipo_enum" {
  "conducta"
  "rendimiento"
  "asistencia"
}

Enum "usuarios_rol_enum" {
  "admin"
  "docentes"
}

Table "admins" {
  "id" bigint(20) [pk, not null, increment]
  "id_usuarios" bigint(20) [not null]
  "Nombre" varchar(255) [not null]
  "Apellido" varchar(255) [not null]
  "Cargo" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_usuarios [unique, name: "admins_id_usuarios_unique"]
  }
}

Table "asignaturas" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre" varchar(255) [not null]
  "Descripcion" varchar(255)
  "Código" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    Código [unique, name: "asignaturas_código_unique"]
  }
}

Table "aulas" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre" varchar(255) [not null]
  "Capacidad" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp
}

Table "cache" {
  "cache_key" varchar(255) [pk, not null]
  "value" mediumtext [not null]
  "expiration" int(11) [not null]
}

Table "cache_locks" {
  "cache_key" varchar(255) [pk, not null]
  "owner" varchar(255) [not null]
  "expiration" int(11) [not null]
}

Table "comarcas" {
  "id" bigint(20) [pk, not null, increment]
  "Comarca" varchar(255) [not null]
  "Direccion" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp
}

Table "cortes_evaluativos" {
  "id" bigint(20) [pk, not null, increment]
  "id_modalidades" bigint(20) [not null]
  "nombre" varchar(255) [not null]
  "ponderacion" int(11) [not null]
  "id_periodo_academicos" bigint(20) [not null]
  "fecha_inicio" date [not null]
  "fecha_fin" date [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_modalidades [name: "cortes_evaluativos_id_modalidades_foreign"]
    id_periodo_academicos [name: "cortes_evaluativos_id_periodo_academicos_foreign"]
  }
}

Table "docentes" {
  "id" bigint(20) [pk, not null, increment]
  "id_usuario" bigint(20) [not null]
  "Nombre" varchar(255) [not null]
  "Apellido" varchar(255) [not null]
  "FechadeNacimiento" date [not null]
  "Email" varchar(255) [not null]
  "Telefono" int(11) [not null]
  "id_especialidads" bigint(20) [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_usuario [unique, name: "docentes_id_usuario_unique"]
    id_especialidads [name: "docentes_id_especialidads_foreign"]
  }
}

Table "especialidads" {
  "id" bigint(20) [pk, not null, increment]
  "Especialidad" varchar(255) [not null]
  "Descripcion" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp
}

Table "estudiantes" {
  "id" bigint(20) [pk, not null, increment]
  "Código_Persona" int(11) [not null]
  "Nombre" varchar(255) [not null]
  "Apellido" varchar(255) [not null]
  "Sexo" varchar(255) [not null]
  "Fecha_N" date [not null]
  "Celular" int(11) [not null]
  "id_padre" bigint(20)
  "id_comarca" bigint(20) [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_padre [name: "estudiantes_id_padre_foreign"]
    id_comarca [name: "estudiantes_id_comarca_foreign"]
  }
}

Table "failed_jobs" {
  "id" bigint(20) [pk, not null, increment]
  "uuid" varchar(255) [not null]
  "connection" text [not null]
  "queue" text [not null]
  "payload" longtext [not null]
  "exception" longtext [not null]
  "failed_at" timestamp [not null, default: `current_timestamp()`]

  Indexes {
    uuid [unique, name: "failed_jobs_uuid_unique"]
  }
}

Table "grados" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre" varchar(255) [not null]
  "Nivel" int(11) [not null]
  "created_at" timestamp
  "updated_at" timestamp
}

Table "grupos" {
  "id" bigint(20) [pk, not null, increment]
  "Código" varchar(255) [not null]
  "Nombre" varchar(255) [not null]
  "Descripcion" varchar(255) [not null]
  "id_turno" bigint(20) [not null]
  "id_grado" bigint(20) [not null]
  "id_periodo_academicos" bigint(20) [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_turno [name: "grupos_id_turno_foreign"]
    id_grado [name: "grupos_id_grado_foreign"]
    id_periodo_academicos [name: "grupos_id_periodo_academicos_foreign"]
  }
}

Table "horarios" {
  "id" bigint(20) [pk, not null, increment]
  "id_grupo" bigint(20) [not null]
  "id_asignatura" bigint(20) [not null]
  "id_docente" bigint(20) [not null]
  "id_aula" bigint(20) [not null]
  "Dia_semana" horarios_Dia_semana_enum [not null]
  "Hora_inicio" time [not null]
  "Hora_fin" time [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_grupo [name: "horarios_id_grupo_foreign"]
    id_asignatura [name: "horarios_id_asignatura_foreign"]
    id_docente [name: "horarios_id_docente_foreign"]
    id_aula [name: "horarios_id_aula_foreign"]
  }
}

Table "job_batches" {
  "id" varchar(255) [pk, not null]
  "name" varchar(255) [not null]
  "total_jobs" int(11) [not null]
  "pending_jobs" int(11) [not null]
  "failed_jobs" int(11) [not null]
  "failed_job_ids" longtext [not null]
  "options" mediumtext
  "cancelled_at" int(11)
  "created_at" int(11) [not null]
  "finished_at" int(11)
}

Table "jobs" {
  "id" bigint(20) [pk, not null, increment]
  "queue" varchar(255) [not null]
  "payload" longtext [not null]
  "attempts" tinyint(3) [not null]
  "reserved_at" int(10)
  "available_at" int(10) [not null]
  "created_at" int(10) [not null]

  Indexes {
    queue [name: "jobs_queue_index"]
  }
}

Table "matriculas" {
  "id" bigint(20) [pk, not null, increment]
  "id_estudiante" bigint(20) [not null]
  "id_grupo" bigint(20) [not null]
  "id_periodo_academicos" bigint(20) [not null]
  "id_usuario" bigint(20) [not null]
  "fecha_matricula" date [not null]
  "estado" matriculas_estado_enum [not null]
  "observaciones" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_estudiante [name: "matriculas_id_estudiante_foreign"]
    id_grupo [name: "matriculas_id_grupo_foreign"]
    id_periodo_academicos [name: "matricula_id_periodo_academicos_foreign"]
    id_usuario [name: "matriculas_id_usuario_foreign"]
  }
}

Table "migrations" {
  "id" int(10) [pk, not null, increment]
  "migration" varchar(255) [not null]
  "batch" int(11) [not null]
}

Table "modalidades" {
  "id" bigint(20) [pk, not null, increment]
  "nombre" varchar(255) [not null]
  "codigo" varchar(255) [not null]
  "descripcion" varchar(255) [not null]
  "created_at" timestamp
  "updated_at" timestamp
}

Table "notas" {
  "id" bigint(20) [pk, not null, increment]
  "id_matricula" bigint(20) [not null]
  "id_horario" bigint(20) [not null]
  "id_corte_evaluativo" bigint(20) [not null]
  "id_usuario" bigint(20) [not null]
  "nota_normal" double
  "nota_especial" double
  "observacion" varchar(255)
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_matricula [name: "notas_id_matricula_foreign"]
    id_horario [name: "notas_id_horario_foreign"]
    id_corte_evaluativo [name: "notas_id_corte_evaluativo_foreign"]
    id_usuario [name: "notas_id_usuario_foreign"]
  }
}

Table "padres" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre_o_Tutor" varchar(255) [not null]
  "Apellido" varchar(255) [not null]
  "Email" varchar(255) [not null]
  "Cedula" varchar(255) [not null]
  "Telefono" varchar(255) [not null]
  "created_at" timestamp
  "updated_at" timestamp
}

Table "periodo_academicos" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre" varchar(255) [not null]
  "Fecha_inicio" date [not null]
  "Fecha_fin" date [not null]
  "Activo" tinyint(1) [not null, default: 0]
  "created_at" timestamp
  "updated_at" timestamp
}

Table "personal_access_tokens" {
  "id" bigint(20) [pk, not null, increment]
  "tokenable_type" varchar(255) [not null]
  "tokenable_id" bigint(20) [not null]
  "name" text [not null]
  "token" varchar(64) [not null]
  "abilities" text
  "last_used_at" timestamp
  "expires_at" timestamp
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    token [unique, name: "personal_access_tokens_token_unique"]
    (tokenable_type, tokenable_id) [name: "personal_access_tokens_tokenable_type_tokenable_id_index"]
    expires_at [name: "personal_access_tokens_expires_at_index"]
  }
}

Table "reportes_admins" {
  "id" bigint(20) [pk, not null, increment]
  "id_admin" bigint(20) [not null]
  "titulo" varchar(255) [not null]
  "descripcion" text [not null]
  "categoria" reportes_admins_categoria_enum [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_admin [name: "reportes_admins_id_admin_foreign"]
  }
}

Table "reportes_docentes" {
  "id" bigint(20) [pk, not null, increment]
  "id_docente" bigint(20) [not null]
  "id_estudiante" bigint(20) [not null]
  "titulo" varchar(255) [not null]
  "descripcion" text [not null]
  "tipo" reportes_docentes_tipo_enum [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    id_docente [name: "reportes_docentes_id_docente_foreign"]
    id_estudiante [name: "reportes_docentes_id_estudiante_foreign"]
  }
}

Table "sessions" {
  "id" varchar(255) [pk, not null]
  "user_id" bigint(20)
  "ip_address" varchar(45)
  "user_agent" text
  "payload" longtext [not null]
  "last_activity" int(11) [not null]

  Indexes {
    user_id [name: "sessions_user_id_index"]
    last_activity [name: "sessions_last_activity_index"]
  }
}

Table "turnos" {
  "id" bigint(20) [pk, not null, increment]
  "Nombre" varchar(255) [not null]
  "Descripcion" varchar(255) [not null]
  "created_at" timestamp
  "updated_at" timestamp
}

Table "usuarios" {
  "id" bigint(20) [pk, not null, increment]
  "Email" varchar(255) [not null]
  "password" varchar(255) [not null]
  "rol" usuarios_rol_enum [not null]
  "created_at" timestamp
  "updated_at" timestamp

  Indexes {
    Email [unique, name: "usuarios_email_unique"]
  }
}

Ref "docentes_id_usuario_foreign": "usuarios"."id" < "docentes"."id_usuario"

Ref "reportes_admins_id_admin_foreign": "admins"."id" < "reportes_admins"."id_admin"

Ref "reportes_docentes_id_docente_foreign": "docentes"."id" < "reportes_docentes"."id_docente"

Ref "reportes_docentes_id_estudiante_foreign": "estudiantes"."id" < "reportes_docentes"."id_estudiante"

Ref "estudiantes_id_padre_foreign": "padres"."id" < "estudiantes"."id_padre"

Ref "estudiantes_id_comarca_foreign": "comarcas"."id" < "estudiantes"."id_comarca"

Ref "docentes_id_especialidads_foreign": "especialidads"."id" < "docentes"."id_especialidads"

Ref "grupos_id_turno_foreign": "turnos"."id" < "grupos"."id_turno"

Ref "grupos_id_grado_foreign": "grados"."id" < "grupos"."id_grado"

Ref "grupos_id_periodo_academicos_foreign": "periodo_academicos"."id" < "grupos"."id_periodo_academicos"

Ref "horarios_id_grupo_foreign": "grupos"."id" < "horarios"."id_grupo"

Ref "horarios_id_asignatura_foreign": "asignaturas"."id" < "horarios"."id_asignatura"

Ref "horarios_id_docente_foreign": "docentes"."id" < "horarios"."id_docente"

Ref "horarios_id_aula_foreign": "aulas"."id" < "horarios"."id_aula"

Ref "matriculas_id_estudiante_foreign": "estudiantes"."id" < "matriculas"."id_estudiante"

Ref "matriculas_id_grupo_foreign": "grupos"."id" < "matriculas"."id_grupo"