<?php


class Book
{
    public string $id = '';
    public string $title;
    public string $grade;
    public string $isRead;

    public function __construct(string $id, string $title, string $grade, string $read) {
        $this->id = $id;
        $this->title = $title;
        $this->grade = $grade;
        $this->isRead = $read;
    }

    public function __toString() : string {
        return sprintf('Id: %s, Title: %s, Text: %s, is read: %s' . PHP_EOL,
            $this->id, $this->title, $this->grade, $this->isRead);
    }

}