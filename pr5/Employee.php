<?php
declare(strict_types=1);

class Employee
{
    private const TAX_RATE = 0.13;

    public string $name;
    protected float $baseSalary;
    private string $passport;
    private array $salaryHistory = [];

    public function __construct(string $name, float $baseSalary, string $passport)
    {
        $this->name = $name;
        $this->baseSalary = $baseSalary;
        $this->passport = $passport;
    }

    public function getSalary(): float
    {
        return $this->baseSalary;
    }

    public function raiseSalary(float $percent): void
    {
        $this->validatePercent($percent);
        $old = $this->baseSalary;
        $this->baseSalary = round($old * (1 + $percent / 100), 2);
        $this->salaryHistory[] = sprintf(
            '%s: +%s%% (%s -> %s)',
            date('Y-m-d'), $percent, number_format($old, 2, '.', ''), number_format($this->baseSalary, 2, '.', '')
        );
    }

    final public function getMaskedPassport(): string
    {
        return '**** **' . substr($this->passport, -4);
    }

    public function getSalaryHistory(): array
    {
        return $this->salaryHistory;
    }

    public function getNetSalary(): float
    {
        return round($this->getSalary() - $this->calculateTax($this->getSalary()), 2);
    }

    protected function calculateTax(float $amount): float
    {
        return round($amount * self::TAX_RATE, 2);
    }

    private function validatePercent(float $p): void
    {
        if ($p < 1 || $p > 50) {
            throw new InvalidArgumentException("Процент повышения должен быть от 1 до 50, получено: {$p}");
        }
    }
}
