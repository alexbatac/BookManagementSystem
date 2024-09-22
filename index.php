<?php
session_start();

// Check if the reset button was clicked
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    // Clear the session data (i.e., reset the book list)
    session_unset();
    session_destroy();
    
    // Start a new session after destroying the old one
    session_start();

    // Set a message indicating that the book list has been reset
    $_SESSION['resetMessage'] = "The book list has been reset.";
    
    // Redirect to the same page to avoid form resubmission on refresh
    header("Location: index.php");
    exit();
}

// Book class definition (make sure Book.php is properly included or defined here)
class Book {
    private $title;
    private $author;
    private $year;

    public function __construct($title, $author, $year) {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setYear($year);
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title cannot be empty. Please complete the form.");
        }
        $this->title = $title;
    }

    public function setAuthor($author) {
        if (empty($author)) {
            throw new Exception("Author cannot be empty. Please complete the form.");
        }
        $this->author = $author;
    }

    public function setYear($year) {
        if (empty($year)) {
            throw new Exception("Publication year cannot be empty. Please enter a valid year.");
        }
        if (!is_numeric($year)) {
            throw new Exception("Publication year must be a number. Please enter a valid year.");
        }
        if ($year < 1000) {
            throw new Exception("Publication year must not be earlier than 1000. Please enter a valid year.");
        }
        if ($year > (int)date("Y")) {
            throw new Exception("Publication year must not be later than the current year (" . date("Y") . "). Please enter a valid year.");
        }
        $this->year = $year;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }
}

// Handle form submission to add books
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year = trim($_POST['year']);
    
    try {
        
        // Create a new Book object and store it in the session
        $newBook = new Book($title, $author, $year);
        
        // Initialize the book list in the session if not already initialized
        if (!isset($_SESSION['books'])) {
            $_SESSION['books'] = [];
        }
        
        // Add the new book to the session book list
        $_SESSION['books'][] = $newBook;
        $successMessage = "Book successfully added!";
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

// HTML Form and display logic
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

    <!-- Display success or error messages -->
    <?php if (isset($successMessage)) : ?>
        <p style="color: green;"><?php echo $successMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($errorMessage)) : ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['resetMessage'])) : ?>
        <p style="color: blue;"><?php echo $_SESSION['resetMessage']; ?></p>
        <?php unset($_SESSION['resetMessage']); // Clear the message after displaying ?>
    <?php endif; ?>

    <!-- The form for adding books -->
    <form method="POST" action="index.php">
        <!-- Input fields for book title, author, and year -->
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
        
        <label for="author">Author:</label>
        <input type="text" id="author" name="author" value="<?php echo isset($_POST['author']) ? htmlspecialchars($_POST['author']) : ''; ?>">
        
        <label for="year">Publication Year:</label>
        <input type="number" id="year" name="year" value="<?php echo isset($_POST['year']) ? htmlspecialchars($_POST['year']) : ''; ?>"><br></br>
        
        <input type="submit" name="submit" value="Add Book">

        <!-- Reset button to clear the book list -->
        <input type="submit" name="reset" value="Reset Book List">
    </form><br></br>

    <!-- Display the list of books -->
    <?php if (!empty($_SESSION['books'])) : ?>
        <h2>Book List</h2>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Year</th>
            </tr>
            <?php foreach ($_SESSION['books'] as $book) : ?>
                <tr>
                    <td><?php echo $book->getTitle(); ?></td>
                    <td><?php echo $book->getAuthor(); ?></td>
                    <td><?php echo $book->getYear(); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <h1>No books added yet.</h1>
    <?php endif; ?>

</body>
</html>
