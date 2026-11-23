<?php
declare(strict_types=1);

class Student
{
    public const MIN_COURSE = 1;
    public const MAX_COURSE = 4;

    public static int $totalStudents = 0;
    public static string $university = 'Технический колледж';

    public ?string $email = null;
    public array $grades = [];
    public bool $isActive = true;

    private array $history = [];

    public function __construct(
        public readonly int $id,
        public string $lastName,
        public string $firstName,
        public int $course,
    ) {
        if ($course < self::MIN_COURSE || $course > self::MAX_COURSE) {
            throw new InvalidArgumentException(
                "Курс должен быть от " . self::MIN_COURSE . " до " . self::MAX_COURSE . ", получено: $course"
            );
        }
        self::$totalStudents++;
    }

    public function getFullName(): string
    {
        return "{$this->lastName} {$this->firstName}";
    }

    public function getAverage(): float
    {
        return $this->grades === [] ? 0.0 : array_sum($this->grades) / count($this->grades);
    }

    public function getHistory(): array
    {
        return $this->history;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->history[] = $name;
        echo "Предупреждение: свойство «{$name}» не существует и не будет создано" . PHP_EOL;
    }
}
