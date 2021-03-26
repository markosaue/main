<?php


class Author
{
    public string $id = '';
    public string $firstName;
    public string $lastName;
    public string $grade;

    public function __construct(string $id, string $firstName, string $lastName, string $grade) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->grade = $grade;
    }


    public function __toString() : string {
        return sprintf('Id: %s, First name: %s, Last name: %s, Grade: %s' . PHP_EOL,
            $this->id, $this->firstName, $this->lastName, $this->grade);
    }
}