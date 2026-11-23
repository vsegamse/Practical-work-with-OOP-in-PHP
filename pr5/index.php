<?php
declare(strict_types=1);

require __DIR__ . '/Employee.php';
require __DIR__ . '/Manager.php';
require __DIR__ . '/Developer.php';

$employees = [
    new Employee('Сергей Орлов', 60000, '4510 123456'),
    new Manager('Ольга Смирнова', 90000, '4511 654321', 4),
    new Developer('Иван Петров', 70000, '4512 111222', 'junior'),
    new Developer('Мария Лебедева', 70000, '4513 333444', 'middle'),
    new Developer('Андрей Волков', 70000, '4514 555666', 'senior'),
];

function pad(string $s, int $w): string
{
    return $s . str_repeat(' ', max(0, $w - count(preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY))));
}

echo pad('Имя', 18) . pad('Тип', 11) . pad('Зарплата', 12) . 'После налога (13%)' . PHP_EOL;
echo str_repeat('-', 60) . PHP_EOL;
foreach ($employees as $e) {
    echo pad($e->name, 18)
        . pad($e::class, 11)
        . pad(number_format($e->getSalary(), 2, '.', ''), 12)
        . number_format($e->getNetSalary(), 2, '.', '') . PHP_EOL;
}

echo PHP_EOL . 'Паспорт (маска): ' . $employees[0]->getMaskedPassport() . PHP_EOL;
echo 'Налог с надбавки менеджера: ' . $employees[1]->getTeamBonusTax() . PHP_EOL;

echo PHP_EOL . '=== Повышение оклада ===' . PHP_EOL;
$dev = $employees[2];
$dev->raiseSalary(10);
$dev->raiseSalary(5.5);
foreach ($dev->getSalaryHistory() as $line) {
    echo $line . PHP_EOL;
}
echo 'Новая зарплата: ' . number_format($dev->getSalary(), 2, '.', '') . PHP_EOL;

foreach ([0.5, 70] as $bad) {
    try {
        $dev->raiseSalary($bad);
    } catch (InvalidArgumentException $e) {
        echo 'Ошибка: ' . $e->getMessage() . PHP_EOL;
    }
}

// Прямой доступ к закрытым данным — ошибки (закомментировано, см. experiments/experiments.php):
// echo $dev->baseSalary;                 // Error: Cannot access protected property
// echo $dev->passport;                   // Error: Cannot access private property
// $dev->calculateTax(100);               // Error: Call to protected method
