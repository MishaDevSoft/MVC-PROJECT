<?php
// Включаем отображение ошибок на время разработки
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Определяем корневую директорию приложения
define('APPROOT', dirname(dirname(__FILE__)) . '/app');

// Проверяем, что файл конфигурации существует
if (!file_exists(APPROOT . '/config/config.php')) {
    die('Błąd: Nie znaleziono pliku konfiguracyjnego');
}

// Загрузка конфигурации
require_once APPROOT . '/config/config.php';

// Автозагрузка классов
spl_autoload_register(function($className) {
    // Массив директорий для поиска классов
    $directories = [
        APPROOT . '/core/',
        APPROOT . '/controllers/',
        APPROOT . '/models/'
    ];
    
    // Проходим по всем директориям
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
    
    // Если класс не найден
    die('Błąd: Nie znaleziono klasy ' . $className);
});

try {
    // Запуск маршрутизатора
    $router = new Router();
} catch (Exception $e) {
    if (DEBUG_MODE) {
        die('Błąd: ' . $e->getMessage());
    } else {
        die('Wystąpił wewnętrzny błąd serwera');
    }
} 