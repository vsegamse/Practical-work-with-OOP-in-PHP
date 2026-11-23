<?php
declare(strict_types=1);

class Library
{
    /** @var Book[] */
    private array $books = [];

    public function addBook(Book $book): void
    {
        $this->books[] = $book;
    }

    /** @return Book[] */
    public function findByAuthor(string $author): array
    {
        return array_values(array_filter(
            $this->books,
            fn(Book $b): bool => str_contains($b->author, $author)
        ));
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function printAll(): void
    {
        foreach ($this->books as $i => $book) {
            echo ($i + 1) . '. ' . $book->getInfo() . PHP_EOL;
        }
    }

    public function getOldest(): ?Book
    {
        if ($this->books === []) {
            return null;
        }
        $oldest = $this->books[0];
        foreach ($this->books as $book) {
            if ($book->year < $oldest->year) {
                $oldest = $book;
            }
        }
        return $oldest;
    }
}
