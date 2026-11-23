<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Shop\Helpers\PriceFormatter;
use Shop\Models\Customer;
use Shop\Models\Product;
use Shop\Services\Cart;

echo "--- старт скрипта, ни один класс ещё не загружен ---" . PHP_EOL;

$customer = new Customer('Анна Иванова', 'anna@example.com');
$cart = new Cart($customer);

$cart->add(new Product('Клавиатура', 1250.00), 1);
$cart->add(new Product('Мышь', 890.50), 2);
$cart->add(new Product('Коврик', 300.00), 3);

echo 'Покупатель: ' . $cart->getCustomer()->name . PHP_EOL;
echo 'Итого: ' . PriceFormatter::format($cart->getTotal()) . PHP_EOL;

try {
    new Shop\Models\Order($customer, 1.0);
} catch (Error $e) {
    echo 'Ошибка: ' . $e->getMessage() . PHP_EOL;
}
