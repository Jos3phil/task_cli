
 
 <?php
 /**
 * Task Tracker CLI Script
 * 
 * This script provides a command-line interface for managing tasks.
 * It allows users to add, list, and update task statuses through CLI commands.
 * Tasks are persisted in a JSON file.
 * 
 * Functions:
 * - loadTasks(): Loads tasks from JSON file into memory
 * - saveTasks(): Persists tasks from memory to JSON file 
 * - listTasks(): Displays all tasks with their ID, name and status
 * - runCommand(): Main function that processes CLI arguments and executes corresponding actions
 * - showHelp(): Displays usage instructions and available commands
 * 
 * Usage:
 * php script_cli.php [command] [arguments]
 * 
 * Available Commands:
 * - list: Show all tasks
 * - add "Task name": Add a new task
 * - mark-done ID: Mark a task as completed
 * - mark-in-progress ID: Mark a task as in progress
 * 
 * Dependencies:
 * - Requires task_cli.php
 * - Uses tasks.json for data persistence
 * 
 * @author Your Name
 * @version 1.0
 */
require_once 'task_cli.php';

const TASKS_FILE = 'tasks.json';


function loadTasks(){
    $tasks = [];
    if(file_exists(TASKS_FILE)){
        $jsonData = file_get_contents(TASKS_FILE);
        $tasksData = json_decode($jsonData,true);

        if($tasksData){
            foreach($tasksData as $taskData){
                $task = new task($taskData['name']);
                $task->id = $taskData['id'];
                $task->status = $taskData['status'];
                $tasks[$task->id] = $task;

                // Actualizar el contador estático
                if ($task->id > task::$counter) {
                    task::$counter = $task->id;
                }
            }
        }
    return $tasks;
    }
}
/**
 * Guardar tareas en archivo JSON
 */
function saveTasks($tasks) {
    file_put_contents(TASKS_FILE, json_encode(array_values($tasks), JSON_PRETTY_PRINT));
}
/**
 * Mostrar todas las tareas
 */
function listTasks() {
    echo "Lista de tareas:\n";
    echo "--------------\n";
    $tasks=[];
    $tasks = loadTasks();
    if (empty($tasks)) {
        echo "No hay tareas registradas.\n";
        return;
    }
    
    foreach ($tasks as $task) {
        echo "[{$task->id}] {$task->name} - Status: {$task->status}\n";
    }
}
function listTasksdone($tasks)
{
    echo "List of task done:\n";
    echo "--------------\n";

    if (empty($tasks)) {
        echo "No task done.\n";
        return;
    }
    foreach($tasks as $task){
        if($task->status=='done'){
            echo "[{$task->id}] {$task->name} - Status: {$task->status}\n";
        }
    }
}
function listTasksinprogress($tasks)
{
    
    echo "List of task in progress:\n";
    echo "--------------\n";

    if (empty($tasks)) {
        echo "No task in progress.\n";
        return;
    }
    foreach($tasks as $task){
        if($task->status=='in-progress'){
            echo "[{$task->id}] {$task->name} - Status: {$task->status}\n";
        }
    }
}
/**
 * Ejecutar comandos según los argumentos
 */
function runCommand($argv) {
    $tasks = loadTasks();
    
    // Si no hay argumentos, mostrar ayuda
    if (count($argv) < 2) {
        showHelp();
        return;
    }
    
    $command = $argv[1];
    
    switch ($command) {      
        
            
        case 'list':
            if(isset($argv[2]) && $argv[2]=='done'){
                listTasksdone($tasks);           
            }
            elseif(isset($argv[2]) && $argv[2]=='in-progress'){
                listTasksinprogress($tasks);
            }
            else
            {
                listTasks($tasks);
            }
            break;
                              
       
        case 'add':
            if (isset($argv[2])) {
                $taskName = $argv[2];
                $task = new task($taskName);
                $tasks[$task->id] = $task;
                saveTasks($tasks);
                echo "Task added sucessfully (ID: {$task->id})\n";
            } else {
                echo "Error: Debe proporcionar un nombre para la tarea.\n";
            }
            break;
        case 'update':
            if (isset($argv[2]) && is_numeric($argv[2]) && isset($argv[3])) {
                $taskName = $argv[3];
                $id = (int)$argv[2];
                if(isset($tasks[$id])){
                    $tasks[$id]->name = $taskName;
                    saveTasks($tasks);                    
                }
            }
            break;
        case 'delete':
            if(isset($argv[2]) && is_numeric($argv[2])){
                $id = (int)$argv[2];
                if(isset($tasks[$id])){
                    unset($tasks[$id]);
                    saveTasks($tasks);
                }
            }
        case 'mark-done':
            if (isset($argv[2]) && is_numeric($argv[2])) {
                $id = (int)$argv[2];
                if (isset($tasks[$id])) {
                    $tasks[$id]->markAsDone();
                    saveTasks($tasks);
                    
                } else {
                    echo "Error: Not found task with ID {$id}.\n";
                }
            } else {
                echo "Error: Command invalid.\n";
            }
            break;
            
        case 'mark-in-progress':
            if (isset($argv[2]) && is_numeric($argv[2])) {
                $id = (int)$argv[2];
                if (isset($tasks[$id])) {
                    $tasks[$id]->markAsInProgress();
                    saveTasks($tasks);
                    echo "Tarea {$id} marcada en progreso.\n";
                } else {
                    echo "Error: No se encontró la tarea con ID {$id}.\n";
                }
            } else {
                echo "Error: Debe proporcionar un ID válido.\n";
            }
            break;
            
        default:
            echo "Not found command: {$command}\n";
            showHelp();
    }
}

/**
 * Mostrar ayuda
 */
function showHelp() {
    echo "Uso: php cli.php [comando] [argumentos]\n";
    echo "Comandos disponibles:\n";
    echo "  list                    - Mostrar todas las tareas\n";
    echo "  add \"Nombre de tarea\"   - Añadir nueva tarea\n";
    echo "  mark-done ID            - Marcar tarea como completada\n";
    echo "  mark-in-progress ID     - Marcar tarea en progreso\n";
}

// Ejecutar el script
runCommand($argv);