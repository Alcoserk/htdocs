<?php
include 'includes/db_connect.php';

// Получаем данные из таблицы users
$sql = "SELECT id, name, age, country FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Центрирование формы */
        .container {
            max-width: 600px; /* Ограничиваем ширину формы */
            background: rgba(255, 255, 255, 0.1); /* Прозрачный фон для красоты */
            padding: 20px; /* Отступы внутри формы */
            border-radius: 10px; /* Скруглённые углы */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Тень для выделения формы */
        }

        /* Для центрирования по всей странице */
        .full-height {
            height: 100vh; /* Высота страницы */
        }
    </style>
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <h1 class="text-center mb-4">Список пользователей</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Возраст</th>
                    <th>Страна</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Выводим строки таблицы
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['country']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Если данных нет, выводим сообщение
                    echo "<tr><td colspan='4' class='text-center'>Данные отсутствуют</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="index_test.php" class="btn btn-secondary mt-3">Вернуться к форме</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
