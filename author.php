<?php

include_once __DIR__ . '/Authors.php';
const AUTHOR_FILE = __DIR__ . '/data/author_list.txt';
const ID_FILE = __DIR__ . '/data/id2.txt';

$id = $_POST["id"] ?? "";
$firstName = $_POST["firstName"] ?? "";
$lastName = $_POST["lastName"] ?? "";
$grade = $_POST["grade"] ?? "0";
$deleteButton = $_POST["deleteButton"] ?? "";
$messageBlock = "";

if ($deleteButton) {
    deleteAuthorById($id);
    $messageBlock = '<tr id="message-block">Kustutatud!</tr>';

}  else if (strlen($firstName) >= 1 && strlen($firstName) <= 21 && strlen($lastName) >= 2 && strlen($lastName) <= 22) {
    saveAuthor(new Author($id, $firstName, $lastName, $grade));
    $messageBlock = '<tr id="message-block">Lisatud!</tr>';

} else if (!empty($_POST)){
    $message = urlencode("Eesnimi peab olema 1 kuni 21 märki! Perekonnanimi peab olema 2 kuni 22 märki!");
    $url = "author-form.php?id=$id&firstName=$firstName&lastName=$lastName&grade=$grade&message=$message";
    header("location: " . $url);
}

function saveAuthor(Author $author) {
    if ($author->id) {
        deleteAuthorById($author->id);
    } else {
        $author->id = getNextId();
    }

    file_put_contents(AUTHOR_FILE, getAuthorAsLine($author), FILE_APPEND);

    return $author->id;
}

function deleteAuthorById(string $id) : void {
    $contents = "";
    foreach (getAuthorsFromFile() as $author) {
        if ($author->id === $id) {
            continue;
        }
        $contents .= getAuthorAsLine($author);
    }
    file_put_contents(AUTHOR_FILE, $contents);
}

function getAuthorAsLine(Author $author): string
{
    return urlencode($author->id) . ';'
        . urlencode($author->firstName) . ';'
        . urlencode($author->lastName) . ';'
        . urlencode($author->grade) . PHP_EOL;
}

function authorsForDisplay(): string {
    $forDisplay = "";
    foreach (getAuthorsFromFile() as $author) {
        $firstName = urlencode($author->firstName);
        $lastName = urlencode($author->lastName);
        $grade = $author->grade;
        $url = "author-form.php?id=$author->id&firstName=$firstName&lastName=$lastName&grade=$grade";
        $grade = str_repeat("<span class='gradeOrange'>★</span>", intval($author->grade))
            . str_repeat("<span class='gradeGrey'>★</span>", 5 - intval($author->grade));
        $row = "<tr><td class='list_columns'><a href=$url>$author->firstName</a>
                            </td><td class='list_columns'>$author->lastName</td>
                                    <td class='list_columns'>$grade</td></tr>";
        $forDisplay .= $row . PHP_EOL;
    }
    return $forDisplay;
}

function getAuthorsFromFile() : array {

    $lines = file(AUTHOR_FILE);

    $result = [];
    if (!empty($lines)){
        foreach ($lines as $line) {
            [$id, $firstName, $lastName, $grade] = explode(';', trim($line));

            if ($id && $firstName) {
                $author = new Author($id, urldecode($firstName), urldecode($lastName), urldecode($grade));
                $result[] = $author;
            }
        }
    }

    return $result;
}

function getNextId() : string
{
    $contents = file_get_contents(ID_FILE);
    $id = intval($contents);
    file_put_contents(ID_FILE, $id + 1);
    return strval($id);
}


?>

<!DOCTYPE html>
<html lang="en">
<link href="styles.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>author</title>
</head>
<body id="author-list-page">
<table id="outer_table">
    <tr>
        <td>
            <nav>
                <a href="index.php" id="book-list-link" class="link">Raamatud</a>
                <span>|</span>
                <a href="book-form.php" id="book-form-link" class="link">Lisa raamat</a>
                <span>|</span>
                <a href="author.php" id="author-list-link" class="link">Autorid</a>
                <span>|</span>
                <a href="author-form.php" id="author-form-link" class="link">Lisa autor</a>
            </nav>
            <table id="middle_table">
                <tr>
                    <td>
                        <table id="inner_table_list">
                            <tr>
                                <td class="list_headings">Nimi</td>
                                <td class="list_headings">Perekonnanimi</td>
                                <td class="list_headings">Hinne</td>
                            </tr>
                            <?php if ($messageBlock) echo $messageBlock ?>
                            <?= authorsForDisplay() ?>
                        </table>
                    </td>
                </tr>
            </table>
            <footer>
                ICD0007 Marko Saue
            </footer>
        </td>
    </tr>
</table>
</body>
</html>