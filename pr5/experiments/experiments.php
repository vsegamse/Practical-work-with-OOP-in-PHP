<?php
declare(strict_types=1);

require __DIR__ . '/../Employee.php';
require __DIR__ . '/../Manager.php';
require __DIR__ . '/../Developer.php';

set_error_handler(function (int $no, string $msg): bool {
    throw new ErrorException($msg, 0, $no);
});

class ProbeManager extends Manager
{
    public function readBaseSalary(): float { return $this->baseSalary; }
    public function readPassport(): mixed   { return $this->passport; }
}

class ProbeDeveloper extends Developer
{
    public function callValidate(): void { $this->validatePercent(10); }
}

function run(string $label, callable $fn): void
{
    try {
        $result = $fn();
        echo "[$label]\n   OK: " . var_export($result, true) . "\n";
    } catch (Throwable $e) {
        echo "[$label]\n   " . get_class($e) . ': ' . $e->getMessage() . "\n";
    }
}

$emp = new Employee('Сергей', 60000, '4510 123456');
$mgr = new ProbeManager('Ольга', 90000, '4511 654321', 4);
$dev = new ProbeDeveloper('Иван', 70000, '4512 111222', 'junior');

run('1. Чтение $name снаружи',                   fn() => $emp->name);
run('2. Чтение $baseSalary снаружи',             fn() => $emp->baseSalary);
run('3. Чтение $baseSalary в Manager',           fn() => $mgr->readBaseSalary());
run('4. Чтение $passport в Manager',             fn() => $mgr->readPassport());
run('5. Вызов calculateTax() снаружи',           fn() => $emp->calculateTax(1000));
run('6. Вызов validatePercent() в Developer',    fn() => $dev->callValidate());
