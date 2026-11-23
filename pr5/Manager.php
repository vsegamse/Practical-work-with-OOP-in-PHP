<?php
declare(strict_types=1);

require_once __DIR__ . '/Employee.php';

class Manager extends Employee
{
    private const BONUS_PER_PERSON = 5000;

    public function __construct(
        string $name,
        float $baseSalary,
        string $passport,
        private int $teamSize,
    ) {
        parent::__construct($name, $baseSalary, $passport);
    }

    public function getSalary(): float
    {
        return $this->baseSalary + self::BONUS_PER_PERSON * $this->teamSize;
    }

    public function getTeamBonusTax(): float
    {
        return $this->calculateTax(self::BONUS_PER_PERSON * $this->teamSize);
    }

    public function getTeamSize(): int
    {
        return $this->teamSize;
    }
}
