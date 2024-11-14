<?php
session_start();
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"]) || !preg_match("/^[а-яА-ЯёЁa-zA-Z ]+$/u", $POST["name"])) {
        $errors[] = "Имя должно содержать только буквы и не должно быть пустым.";
    } else {
        $_SESSION["name"] = htmlspecialchars($_POST["name"]);
    }

    if (empty($POST["age"]) || !filter_var($POST["age"], FILTER_VALIDATE_INT) || $POST["age"] < 1 || $POST["age"] > 100) {
        $errors[] = "Возраст должен быть числом от 1 до 100.";
    } else {
        $_SESSION["age"] = intval($POST["age"]);
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
            const age =document.getElementById("age").value;
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['name']) && !empty($_POST['age']) && !empty($_POST['country'])) {
            $_SESSION['name'] = htmlspecialchars($_POST['name']);
            $_SESSION['age'] = intval($_POST['age']);
            $_SESSION['country'] = htmlspecialchars($_POST['country']);
            
            
            // Перенаправляем пользователя на ту же страницу, чтобы данные сбросились
            header("Location: index_test.php");
            exit();
        } else {
            echo "<p>Пожалуйста, заполните все поля.</p>";
        }
    }
        if (isset($_SESSION['name']) && isset($_SESSION['age']) && isset($_SESSION['country'])){
            echo "<p>Здравствуйте, " . $_SESSION['name'] . "!</p>";
            echo "<p>Ваш возраст: " . $_SESSION['age'] . " лет.</p>";
            echo "<p>Ваша страна: " . $_SESSION['country'] . "</p>";

            if ($_SESSION['country'] == "Россия") {
                echo "<p>Слава России</p>";
            } else {
                echo "<p>Чурка</p>";
            }


            // Очищаем данные из сессии после их вывода
            unset($_SESSION["name"], $_SESSION["age"], $_SESSION["country"]);
    }
    ?>

    <a href="index_test.php">Вернуться к форме</a>
</body>
</html>