<?php
include('../../config.php');

// PATRON ESTRATEGY

interface Strategy
{
    public function execute();
}

class TareasByTitle implements Strategy
{
    public function execute()
    {
        global $pdo;
        $sentencia = $pdo->prepare("
            SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
            FROM tareas t 
            LEFT JOIN materias m ON t.id_materia = m.id_materia
            LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
            ORDER BY titulo
        ");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }
}

class TareasByDescription implements Strategy
{
    public function execute()
    {
        global $pdo;
        $sentencia = $pdo->prepare("
            SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
            FROM tareas t 
            LEFT JOIN materias m ON t.id_materia = m.id_materia
            LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
            ORDER BY descripcion
        ");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }
}

class TareasByEstado implements Strategy
{
    public function execute()
    {
        global $pdo;
        $sentencia = $pdo->prepare("
            SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
            FROM tareas t 
            LEFT JOIN materias m ON t.id_materia = m.id_materia
            LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
            ORDER BY estado
        ");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }
}

class TareasByMateria implements Strategy
{
    public function execute()
    {
        global $pdo;
        $sentencia = $pdo->prepare("
            SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
            FROM tareas t 
            LEFT JOIN materias m ON t.id_materia = m.id_materia
            LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
            ORDER BY materia
        ");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }
}

class TareasFecha implements Strategy
{
    public function execute()
    {
        global $pdo;
        $sentencia = $pdo->prepare("
            SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
            FROM tareas t 
            LEFT JOIN materias m ON t.id_materia = m.id_materia
            LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
            ORDER BY fecha_entrega
        ");
        $sentencia->execute();
        $tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        return $tareas;
    }
}

class ContextTareas
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy()
    {
        return $this->strategy->execute();
    }
}




$order = $_GET['order'] ?? 'title';
$strategyMap = [
    'title' => TareasByTitle::class,
    'description' => TareasByDescription::class,
    'estado' => TareasByEstado::class,
    'materia' => TareasByMateria::class,
    'fecha_entrega' => TareasFecha::class,
];

$strategyClass = $strategyMap[$order] ?? TareasByTitle::class;
$strategy = new $strategyClass();

$context = new ContextTareas($strategy);
$tareas = $context->executeStrategy();
$tareasMap = array_map(function ($tarea) {
    return [
        'id' => $tarea['id_tarea'],
        'titulo' => $tarea['titulo'],
        'descripcion' => $tarea['descripcion'],
        'estado' => $tarea['estado'],
        'materia' => $tarea['materia'],
        'ruta_archivo' => $tarea['ruta_archivo'],
        'fecha_entrega' => $tarea['fecha_entrega'],
        'hora_entrega' => $tarea['hora_entrega'],
    ];
}, $tareas);

header('Content-Type: application/json');
echo json_encode(['data' => $tareasMap]);
