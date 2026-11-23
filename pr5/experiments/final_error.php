<?php
declare(strict_types=1);

require __DIR__ . '/../Employee.php';

class Developer2 extends Employee
{
    public function getMaskedPassport(): string
    {
        return 'hacked';
    }
}
