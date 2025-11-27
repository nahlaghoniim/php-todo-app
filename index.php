<?php
/**
 * Simple Todo App
 * Loads todos from a JSON file and displays them.
 */

$todos = [];

if (file_exists('todo.json')) {
    $json = file_get_contents('todo.json');
    $todos = json_decode($json, true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo App</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 16px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .todo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafafa;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
        }

        .todo-name {
            font-size: 16px;
        }

        .completed {
            text-decoration: line-through;
            color: #888;
        }

        .delete-btn {
            background: #dc3545;
        }

        .delete-btn:hover {
            background: #b52a37;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Todo List</h1>

    <form action="newtodo.php" method="post">
        <input type="text" name="todo_name" placeholder="Enter your todo" required>
        <button type="submit">Add</button>
    </form>

    <?php if (!empty($todos)) : ?>
        <?php foreach ($todos as $todoName => $todo): ?>
            <div class="todo-item">

                <form action="change_status.php" method="post" class="status-form" style="display:inline;">
                    <input type="hidden" name="todo_name" value="<?php echo htmlspecialchars($todoName); ?>">
                    <input 
                        type="checkbox" 
                        name="completed"
                        <?php echo $todo['completed'] ? 'checked' : ''; ?>
                    >
                    <span class="todo-name <?php echo $todo['completed'] ? 'completed' : ''; ?>">
                        <?php echo htmlspecialchars($todoName); ?>
                    </span>
                </form>

                <!-- Delete Todo -->
                <form action="delete.php" method="post" style="display:inline;">
                    <input type="hidden" name="todo_name" value="<?php echo htmlspecialchars($todoName); ?>">
                    <button type="submit" class="delete-btn">Delete</button>
                </form>

            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No todos yet. Add one above!</p>
    <?php endif; ?>
</div>

<script>
    const checkboxes = document.querySelectorAll('.status-form input[type=checkbox]');

    checkboxes.forEach(ch => {
        ch.addEventListener('click', function() {
            this.closest('.status-form').submit();
        });
    });
</script>

</body>
</html>

