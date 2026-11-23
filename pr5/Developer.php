<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Developer extends Employee
{
    public function __construct(
        string $name,
        float $baseSalary,
        string $passport,
        private string $level,
    ) {
        if (!in_array($level, ['junior', 'middle', 'senior'], true)) {
            throw new InvalidArgumentException("Неизвестный уровень: {$level}");
        }
        parent::__construct($name, $baseSalary, $passport);
    }

    public function getSalary(): float
    {
        $coefficient = match ($this->level) {
            'junior' => 1.0,
            'middle' => 1.5,
            'senior' => 2.0,
        };
        return $this->baseSalary * $coefficient;
    }

    public function getLevel(): string
    {
        return $this->level;
    }
}
