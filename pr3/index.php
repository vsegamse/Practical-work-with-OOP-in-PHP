<?php
declare(strict_types=1);

require __DIR__ . '/Student.php';

$students = [
    new Student(1001, 'Иванов', 'Пётр', 1),
    new Student(1002, 'Петрова', 'Анна', 2),
    new Student(1003, 'Сидоров', 'Олег', 3),
    new Student(1004, 'Козлова', 'Мария', 4),
];
$students[0]->grades = [5, 4, 5, 4];
$students[0]->email = 'ivanov@example.com';
$students[1]->grades = [5, 5, 5];
$students[1]->email = 'petrova@example.com';
$students[2]->grades = [3, 4, 4, 3, 5];
$students[2]->email = 'sidorov@example.com';
$students[3]->grades = [4, 4, 5];

function pad(string $s, int $width): string
{
    $len = count(preg_split('//u', $s, -1, PREG_SPLIT_NO_EMPTY));
    return $s . str_repeat(' ', max(0, $width - $len));
}

echo "Учебное заведение: " . Student::$university . PHP_EOL;
echo pad('Билет', 7) . pad('ФИО', 18) . pad('Курс', 6) . pad('Почта', 22) . 'Ср. балл' . PHP_EOL;
echo str_repeat('-', 62) . PHP_EOL;
foreach ($students as $s) {
    echo pad((string) $s->id, 7)
        . pad($s->getFullName(), 18)
        . pad((string) $s->course, 6)
        . pad($s->email ?? 'не указана', 22)
        . number_format($s->getAverage(), 2) . PHP_EOL;
}
echo PHP_EOL . 'Всего студентов: ' . Student::$totalStudents . PHP_EOL;

echo PHP_EOL . "=== ЭКСПЕРИМЕНТЫ ===" . PHP_EOL;
$s = $students[0];

echo PHP_EOL . "1) Изменение readonly \$id:" . PHP_EOL;
try { $s->id = 5; } catch (Error $e) { echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL; }

echo PHP_EOL . "2) Строка в \$course при strict_types=1:" . PHP_EOL;
try { $s->course = 'два'; } catch (TypeError $e) { echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL; }
try { $s->course = '2'; } catch (TypeError $e) { echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL; }

echo PHP_EOL . "3) Студент с курсом 7:" . PHP_EOL;
try { new Student(1005, 'Тестов', 'Тест', 7); } catch (InvalidArgumentException $e) { echo get_class($e) . ': ' . $e->getMessage() . PHP_EOL; }
echo 'Student::$totalStudents после неудачной попытки: ' . Student::$totalStudents . PHP_EOL;

echo PHP_EOL . "4) Изменение Student::\$university:" . PHP_EOL;
Student::$university = 'Политехнический колледж';
echo 'Через класс: ' . Student::$university . PHP_EOL;
echo 'Через объект $students[0]: ' . $students[0]::$university . PHP_EOL;
echo 'Через объект $students[3]: ' . $students[3]::$university . PHP_EOL;

echo PHP_EOL . "5) var_dump и get_object_vars (вне класса):" . PHP_EOL;
var_dump($students[3]);
print_r(get_object_vars($students[3]));

echo PHP_EOL . "Дополнительно: __set и \$history" . PHP_EOL;
$s->phone = '+7 900 000-00-00';
$s->address = 'Москва';
echo 'История: ' . implode(', ', $s->getHistory()) . PHP_EOL;
