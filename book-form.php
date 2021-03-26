<?php

$id = $_GET["id"] ?? "";
$title = $_GET["title"] ?? "";
$actualGrade = $_GET["grade"] ?? "";
$isRead = $_GET["isRead"] ?? "no";
$message = $_GET["message"] ?? "";


?>

<!DOCTYPE html>
<html lang="en">
<link href="styles.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>book-form</title>
</head>
<body id="book-form-page">
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
                        <form method="post" action="index.php">
                            <table id="inner_table_form">
                                <em id='error-block'> <?= $message ?> </em>
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="title">Pealkiri:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="title" name="title"
                                               value="<?php echo urldecode($title); ?>">
                                        <input type="hidden" name="id" value="<?php echo urldecode($id); ?>"/>
                                    </td>
                                </tr>
                                <!--<tr>
                                    <td class="text_input_label_column">
                                        <label for="author1">Autor 1: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="author1" name="author1">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="author2">Autor 2: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="author2" name="author2">
                                    </td>
                                </tr>-->
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="radio">Hinne: </label>
                                    </td>
                                    <td id="radio">
                                        <?php foreach (range(1, 5) as $grade): ?>
                                            <input type="radio"
                                                   name="grade"
                                                <?= strval($grade) === $actualGrade ? 'checked' : ''; ?>
                                                   value="<?= $grade ?>"/>
                                            <?= $grade ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="isRead">Loetud: </label>
                                    </td>
                                    <td>
                                        <input type="checkbox" id="isRead" name="isRead"
                                               value="yes" <?php if ($isRead == 'yes') echo "checked='checked'"; ?>>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <?php if ($id) echo '<input type="submit" value="Kustuta" id="deleteButton" 
                                            name="deleteButton">'; ?>
                                        <input type="submit" value="Salvesta" id="submitButton" name="submitButton">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </td>
                </tr>
            </table>
            <footer>
                ICD0007 <span class="FirstName">Marko</span> Saue
            </footer>
        </td>
    </tr>
</table>
</body>
</html>