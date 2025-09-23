<?php
try {
    // Параметри підключення до PostgreSQL
    $dsn = "pgsql:host=auto.psql.tools;port=10048;dbname=taurus;";
    $user = "taurus";
    $password = "2csrcc5547";

    // Підключення до PostgreSQL через PDO
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);



/*
    // SQL-запит для створення таблиці
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS my_table (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

    // Виконання запиту
    $pdo->exec($createTableQuery);

    echo "Таблиця 'my_table' успішно створена (або вже існує).";

*/

/*
$name = "John Doe";
    $email = "johndoe@example.com";

    // SQL-запит для вставки даних
    $insertQuery = "
        INSERT INTO my_table (name, email)
        VALUES (:name, :email);
    ";

    // Підготовка запиту
    $stmt = $pdo->prepare($insertQuery);

    // Прив'язка параметрів
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    // Виконання запиту
    $stmt->execute();

    echo "Запис успішно додано в таблицю.";
    */


    // SQL-запит для отримання даних
    $selectQuery = "SELECT * FROM my_table;";

    // Виконання запиту
    $stmt = $pdo->query($selectQuery);

    // Отримання всіх результатів
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Виведення результатів
    if (!empty($results)) {
        foreach ($results as $row) {
            echo "ID: " . $row['id'] . "<br>";
            echo "Name: " . $row['name'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "-----------------------------<br>";
        }
    } else {
        echo "Таблиця порожня.";
    }



} catch (PDOException $e) {
    echo "Помилка підключення або виконання запиту: " . $e->getMessage();
}
?>