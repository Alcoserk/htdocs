<?php
include 'includes/db_connect.php';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [] ;
    $name = trim($_POST['name']);
    $age = intval($_POST['age']);
    $country = trim($_POST['country']);


    if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ ]+$/u', $name)) {
        $errors[] = 'Имя должно содержать только буквы.';
    }
    if (!filter_var($age, FILTER_VALIDATE_INT) || $age <= 0){
        $errors[] = 'Возраст должен быть положительным числом.';
    }
    if (empty($country)){
        $errors[] = "Поле 'страна' не может быть пустым.";
    }

    if (empty($errors)){

        $stmt = $conn->prepare("INSERT INTO users (name, age, country) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $age, $country);

        if ($stmt->execute()) {
            echo"<p>Данные успешно сохранены!</p>";
    }else{
        echo "<p>Ошибка: " . $stmt->error . "</p>";
    }

    $stmt->close();
    header("Location: index_test.php");
    exit();
} else{
    echo "<ul style='color:red;'>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Обработка формы</title>
    <script>
        function validateForm(){
            const name = document.getElementById("name").value;
            const age = document.getElementById("age").value;
            const country = document.getElementById("country").value;
            const namePattern = /^[а-яА-ЯёЁa-zA-Z ]+$/u;
            const errors = [];

            if (!namePattern.test(name)) {
                errors.push("Имя должно содержать только буквы.");
            }
            if (!/^\d+$/.test(age) || age < 1 || age > 100) {
                errors.push("Возраст должен быть числом от 1 до 100.");
            }
            if (!namePattern.test(country)) {
                errors.push("Страна должна содержать только буквы.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }

            return true;

        }
    </script>
</head>
<body>
    <h1>Данные пользователя</h1>

    <?php
        if (!empty($errors)){
            echo "<ul style= 'color: red;'>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
    ?>

    <!-- Форма для ввода данных -->
    <form method="POST" action="index_test.php">
        <label for="name">Ваше имя: </label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="age">Ваш возраст: </label>
        <input type="text" id="age" name="age" required><br><br>

        <label for="country">Ваша страна: </label>
        <input type="text" id="country" name="country" required><br><br>

        <button type="submit">Отправить</button>
    </form>

    <?php
    
        if (isset($_SESSION['name']) && isset($_SESSION['age']) && isset($_SESSION['country'])){
            echo "<p>Здравствуйте, " . $_SESSION['name'] . "!</p>";
            echo "<p>Ваш возраст: " . $_SESSION['age'] . " лет.</p>";
            echo "<p>Ваша страна: " . $_SESSION['country'] . "</p>";

            if ($_SESSION['country'] == "Россия") {
                echo "<p>Слава России</p>";
            } else {
                echo "<p>Добро пожаловать!</p>";
            }


            // Очищаем данные из сессии после их вывода
            unset($_SESSION["name"], $_SESSION["age"], $_SESSION["country"]);
    }
    ?>

    <a href="index_test.php">Вернуться к форме</a>
</body>
</html>