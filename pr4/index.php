<?php
declare(strict_types=1);

require __DIR__ . '/QueryBuilder.php';

echo "=== Запрос 1: полный набор методов ===" . PHP_EOL;
echo QueryBuilder::table('users')
    ->select('id', 'name', 'email')
    ->where('age', '>=', 18)
    ->where('city', '=', 'Москва')
    ->orderBy('name')
    ->limit(10) . PHP_EOL;

echo PHP_EOL . "=== Запрос 2: без select (по умолчанию *) ===" . PHP_EOL;
echo QueryBuilder::table('products')
    ->where('price', '<', 1000)
    ->orderBy('price', 'DESC') . PHP_EOL;

echo PHP_EOL . "=== Запрос 3: LIKE и limit ===" . PHP_EOL;
echo QueryBuilder::table('books')
    ->select('title')
    ->where('author', 'LIKE', '%Толстой%')
    ->limit(5)->toSql() . PHP_EOL;

echo PHP_EOL . "=== Запрос 4: только таблица ===" . PHP_EOL;
echo QueryBuilder::table('orders') . PHP_EOL;

echo PHP_EOL . "=== Экранирование кавычки в значении ===" . PHP_EOL;
echo QueryBuilder::table('users')->where('name', '=', "O'Brien") . PHP_EOL;

echo PHP_EOL . "=== Дополнительно: __call ===" . PHP_EOL;
echo QueryBuilder::table('users')->whereCity('Москва')->whereAge(25)->whereFirstName('Анна') . PHP_EOL;

echo PHP_EOL . "=== Перехват исключений ===" . PHP_EOL;
$bad = [
    'orderBy(name, UP)'      => fn() => QueryBuilder::table('users')->orderBy('name', 'UP'),
    'limit(0)'               => fn() => QueryBuilder::table('users')->limit(0),
    "where(age, '<>', 5)"    => fn() => QueryBuilder::table('users')->where('age', '<>', 5),
    'неизвестный метод'      => fn() => QueryBuilder::table('users')->foo(),
];
foreach ($bad as $label => $fn) {
    try {
        $fn();
    } catch (InvalidArgumentException | BadMethodCallException $e) {
        echo "[$label] " . get_class($e) . ': ' . $e->getMessage() . PHP_EOL;
    }
}
