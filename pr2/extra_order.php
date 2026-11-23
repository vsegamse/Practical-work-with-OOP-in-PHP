<?php
declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
use Shop\Models\{Customer, Order};
$o = new Order(new Customer('Пётр', 'p@example.com'), 500.0);
echo 'Order создан: ' . $o::class . PHP_EOL;
