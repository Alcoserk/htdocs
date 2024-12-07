<?php
// Подключаемся к базе данных
include 'includes/db_connect.php';
session_start();

// Проверяем, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = []; // Массив для хранения ошибок

    // Получаем данные из формы и обрабатываем их
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $country = trim($_POST['country']);

    // Валидация данных на сервере
    if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ ]+$/u', $name)) {
        $errors[] = 'Имя должно содержать только буквы.';
    }
    if (!filter_var($age, FILTER_VALIDATE_INT) || $age <= 0) {
        $errors[] = 'Возраст должен быть положительным числом.';
    }
    if (empty($country)) {
        $errors[] = "Поле 'страна' не может быть пустым.";
    }

    // Если ошибок нет, записываем данные в базу
    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT INTO users (name, age, country) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $age, $country);

        if ($stmt->execute()) {
            echo "<p class='text-success'>Данные успешно сохранены!</p>";
        } else {
            echo "<p class='text-danger'>Ошибка: " . $stmt->error . "</p>";
        }
        $stmt->close();

        // Перенаправляем пользователя обратно на страницу
        header("Location: index_test.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <!-- Подключаем Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Центрирование формы */
        .form-container {
            max-width: 600px; /* Ограничиваем ширину формы */
            background: rgba(255, 255, 255, 0.1); /* Прозрачный фон для красоты */
            padding: 60px; /* Отступы внутри формы */
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
    <div class="d-flex justify-content-center align-items-center full-height">
        <div class="form-container">
            <h1 class="text-center mb-4">Регистрация</h1>

            <!-- Вывод ошибок, если есть -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Форма регистрации -->
            <form method="POST" action="index_test.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Ваш возраст:</label>
                    <input type="text" id="age" name="age" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="country" class="form-label">Ваша страна:</label>
                    <input type="text" id="country" name="country" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Отправить</button>
            </form>

            <!-- Кнопка перехода к списку пользователей -->
            <a href="users.php" class="btn btn-secondary w-100 mt-3">Посмотреть пользователей</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
