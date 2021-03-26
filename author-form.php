<?php

$id = $_GET["id"] ?? "";
$firstName = $_GET["firstName"] ?? "";
$lastName = $_GET["lastName"] ?? "";
$actualGrade = $_GET["grade"] ?? "";
$message = $_GET["message"] ?? "";

error_log($id)

?>
<!DOCTYPE html>
<html lang="en">
<link href="styles.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>author-form</title>
</head>
<body id="author-form-page">
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
                        <form method="post" action="author.php">
                            <table id="inner_table_form">
                                <em id="error-block"> <?= $message ?></em>
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="firstName">Eesnimi: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="firstName" name="firstName"
                                               value="<?php echo urldecode($firstName); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="lastName">Perekonnanimi: </label>
                                    </td>
                                    <td>
                                        <input type="text" id="lastName" name="lastName"
                                               value="<?php echo urldecode($lastName); ?>">
                                        <input type="hidden" name="id" value="<?php echo urldecode($id); ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text_input_label_column">
                                        <label for="radio">Hinne: </label>
                                    </td>
                                    <td id="radio">
                                        <?php foreach (range(1, 5) as $grade): ?>
                                            <input type="radio"
                                                   name="grade"
                                                <?= strval($grade) === strval($actualGrade) ? 'checked' : ''; ?>
                                                   value="<?= $grade ?>"/>
                                            <?= $grade ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <?php if ($id) echo '<input type="submit" value="Kustuta" id="deleteButton" 
                                            name="deleteButton">'; ?>
                                        <input type="submit" value="Salvesta" name="submitButton">
                                    </td>
                                </tr>
                            </table>
                        </form>
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