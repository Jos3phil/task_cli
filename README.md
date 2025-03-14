# Task Tracker CLI

A simple command-line based task manager that allows you to track your pending, in-progress, and completed tasks.

## Description

Task Tracker CLI is a command-line application developed in PHP that enables you to manage tasks. Tasks are stored in a JSON file and can have different statuses: to do (todo), in progress (in-progress), or completed (done).

## Requirements

- PHP 7.4 or higher
- Command-line access

## Installation

1. Clone or download the project files
2. Make sure `script_cli.php` and `task_cli.php` are in the same directory

## Project Structure

- `script_cli.php`: Main script that contains the logic for handling CLI commands
- `task_cli.php`: Defines the Task class for managing individual tasks
- `tasks.json`: File where tasks are stored (created automatically)

## Usage

### Available Commands

```
php script_cli.php [command] [arguments]
```

| Command | Description |
|---------|-------------|
| `list` | Shows all tasks |
| `list done` | Shows only completed tasks |
| `list in-progress` | Shows only tasks in progress |
| `list todo` | Shows only pending tasks |
| `add "Task name"` | Adds a new task |
| `update ID "New name"` | Updates the name of an existing task |
| `delete ID` | Deletes a task |
| `mark-done ID` | Marks a task as completed |
| `mark-in-progress ID` | Marks a task as in progress |

### Usage Examples

```bash
# Add a new task
php script_cli.php add "Create project presentation"

# List all tasks
php script_cli.php list

# Mark a task as in progress
php script_cli.php mark-in-progress 1

# List only in-progress tasks
php script_cli.php list in-progress

# Mark a task as completed
php script_cli.php mark-done 1

# Delete a task
php script_cli.php delete 2
```

## Data Storage

Tasks are stored in the `tasks.json` file in the same directory. This file is created automatically if it doesn't exist.

## Features

- Complete task management (create, update, delete)
- Task status changes (pending, in progress, completed)
- Different views filtered by status
- Persistent storage in JSON format
- Simple command-line interface

## Author

Jos3phil - Version 1.0

