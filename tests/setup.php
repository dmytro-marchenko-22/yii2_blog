#!/usr/bin/env php
<?php
/**
 * Скрипт для инициализации и запуска тестов
 */

$basePath = __DIR__;
chdir($basePath);

echo "=== Инициализация Yii2 Blog тестирования ===\n\n";

// Проверка composer зависимостей
if (!file_exists($basePath . '/vendor/autoload.php')) {
    echo "Ошибка: composer зависимости не установлены.\n";
    echo "Запустите: composer install\n";
    exit(1);
}

require_once $basePath . '/vendor/autoload.php';

// Инициализация Yii
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

$config = require $basePath . '/config/test.php';
$app = new yii\web\Application($config);

echo "1. Миграция базы данных тестирования...\n";
echo "   Запустите: php yii migrate --interactive=0\n\n";

echo "2. Запуск всех тестов:\n";
echo "   php vendor/bin/codecept run\n\n";

echo "3. Запуск только unit-тестов:\n";
echo "   php vendor/bin/codecept run unit\n\n";

echo "4. Запуск только функциональных тестов:\n";
echo "   php vendor/bin/codecept run functional\n\n";

echo "Больше информации в файле TESTING.md\n";
