<?php
// Количество запросов и одновременных пользователей
$totalRequests = 100;
$concurrentUsers = 10;

// URL вашего PHP-приложения
$url = 'http://localhost/your_app/';

// Функция для отправки HTTP-запроса
function sendRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Создание параллельных процессов (пользователей)
for ($i = 0; $i < $concurrentUsers; $i++) {
    $pid = pcntl_fork();

    if ($pid == -1) {
        die("Could not fork");
    } elseif ($pid) {
        // Родительский процесс - ничего не делаем
    } else {
        // Дочерний процесс отправляет запросы
        for ($j = 0; $j < $totalRequests / $concurrentUsers; $j++) {
            sendRequest($url);
        }
        exit(); // Выход из дочернего процесса
    }
}

// Родительский процесс ждет завершения всех дочерних процессов
while (pcntl_waitpid(0, $status) != -1) {
    $status = pcntl_wexitstatus($status);
    echo "Child process completed. Exit status: $status" . PHP_EOL;
}

echo "Load testing completed." . PHP_EOL;
