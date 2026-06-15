<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Docente #{{ $reporte->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #17a2b8; padding-bottom: 10px; }
        .content { margin-top: 20px; }
        .label { font-weight: bold; color: #17a2b8; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Docente</h1>
        <p>Sistema de Gestión Académica - Nicaragua</p>
    </div>

    <div class="content">
        <p><span class="label">ID del Reporte:</span> {{ $reporte->id }}</p>
        <p><span class="label">Nombre del Estudiante:</span> {{ $reporte->estudiantes->Nombre }}</p>
        <p><span class="label">Título:</span> {{ $reporte->titulo }}</p>
        <p><span class="label">Categoría:</span> {{ ucfirst($reporte->tipo) }}</p>
        <p><span class="label">Fecha de Creación:</span> {{ $reporte->created_at->format('d/m/Y H:i') }}</p>
        <hr>
        <p><span class="label">Descripción:</span></p>
        <p>{{ $reporte->descripcion }}</p>
    </div>

    <div class="footer">
        <p>Generado automáticamente por el Sistema de Control de Acceso</p>
        <p>Usuario responsable: {{ $reporte->docentes->Nombre }}</p>
    </div>
</body>
</html>