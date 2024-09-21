<?php
session_start();
require_once 'Book.php'; // Import the Book class

// Initialize book list if it doesn't exist
if (!isset($_SESSION['books'])) {
    $_SESSION['books'] = [];
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];

        // Create a new Book object
        $newBook = new Book($title, $author, $year);

        // Store the new book in the session array
        $_SESSION['books'][] = $newBook;

        $successMessage = "Book successfully added!";
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Management System</title>
</head>
<body>
    <h1>Book Management System</h1>

    <!-- Error and success messages -->
    <?php if (isset($errorMessage)): ?>
        <p style="color:red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    
    <?php if (isset($successMessage)): ?>
        <p style="color:green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" required><br><br>

        <label for="year">Publication Year:</label>
        <input type="number" name="year" id="year" required><br><br>

        <button type="submit">Add Book</button>
    </form>

    <h2>Book List</h2>

    <!-- Display Book List -->
    <?php if (count($_SESSION['books']) > 0): ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
            </tr>
            <?php foreach ($_SESSION['books'] as $book): ?>
                <?php echo $book->displayBook(); ?>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No books have been added yet.</p>
    <?php endif; ?>
</body>
</html>
