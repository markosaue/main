<?php

include_once __DIR__ . '/Book.php';
const BOOK_FILE = __DIR__ . '/data/book_list.txt';
const ID_FILE = __DIR__ . '/data/id.txt';

$id = $_POST["id"] ?? "";
$title = $_POST["title"] ?? "";
$grade = $_POST["grade"] ?? "0";
$isRead = $_POST["isRead"] ?? "no";
//$id = urldecode($id);
$deleteButton = $_POST["deleteButton"] ?? "";
$messageBlock = "";

if ($deleteButton) {
   deleteBookById($id);
   $messageBlock = '<tr id="message-block">Kustutatud!</tr>';

}  else if (strlen($title) >= 3 && strlen($title) <= 23) {
    saveBook(new Book($id, $title, $grade, $isRead));
    $messageBlock = '<tr id="message-block">Lisatud!</tr>';

} else if (!empty($_POST)){
    $message = urlencode("Pealkiri peab olema 3 kuni 23 märki!");
    $url = "book-form.php?id=$id&title=$title&grade=$grade&isRead=$isRead&message=$message";
    header("location: " . $url);
}

function saveBook(Book $book) {
    if ($book->id) {
        deleteBookById($book->id);
    } else {
        $book->id = getNextId();
    }

    file_put_contents(BOOK_FILE, getThisBookAsLine($book), FILE_APPEND);

    return $book->id;
}

function deleteBookById(string $id) : void {
    $contents = "";
    foreach (getAllBooksFromFile() as $book) {
        if ($book->id === $id) {
            continue;
        }
        $contents .= getThisBookAsLine($book);
    }
    file_put_contents(BOOK_FILE, $contents);
}

function getThisBookAsLine(Book $book): string
{
    return urlencode($book->id) . ';'
        . urlencode($book->title) . ';'
        . urlencode($book->grade) . ';'
        . urlencode($book->isRead) . PHP_EOL;
}

function booksForDisplay(): string {
    $forDisplay = "";
    foreach (getAllBooksFromFile() as $book) {
        $title = urlencode($book->title);
        $grade = $book->grade;
        $isRead = $book->isRead;
        $url = "book-form.php?id=$book->id&title=$title&grade=$grade&isRead=$isRead";
        $grade = str_repeat("<span class='gradeOrange'>★</span>", intval($book->grade))
            . str_repeat("<span class='gradeGrey'>★</span>", 5 - intval($book->grade));
        $row = "<tr><td class='list_columns'><a href=$url>$book->title</a></td>
        <td class='list_columns'></td><td>$grade</td></tr>";
        $forDisplay .= $row . PHP_EOL;
    }
    return $forDisplay;
}

function getAllBooksFromFile() : array {

    $lines = file(BOOK_FILE);

    $result = [];
    if (!empty($lines)){
        foreach ($lines as $line) {
            [$id, $title, $grade, $isRead] = explode(';', trim($line));

            if ($id && $title) {
                $book = new Book($id, urldecode($title), urldecode($grade), urldecode($isRead));
                $result[] = $book;
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
    <title>book-list</title>
</head>
<body id='book-list-page'>
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
                                <td class="list_headings">Pealkiri</td>
                                <td class="list_headings">Autorid</td>
                                <td class="list_headings">Hinne</td>
                            </tr>
                            <?php if ($messageBlock) echo $messageBlock ?>
                            <?= booksForDisplay() ?>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <footer>
                ICD0007 Marko Saue
            </footer>
        </td>
    </tr>
</table>
</body>
</html>