# BookManagementSystem
Lab 2 for my PhP class, the Book Management System.

The Book Management System is a simple web-based application developed using PHP, Object-Oriented Programming (OOP) principles, and basic form handling. The system allows users to input and manage a list of books. Users can perform the following actions:

Add New Books:

Users can enter a book's title, author, and publication year via an HTML form.
The input is validated using setter methods within the Book class, which ensures that the title and author are not empty and that the year is valid (a number between 1000 and the current year).
Upon successful validation, the book is stored in the session, and a success message is displayed.

Display Book List:

Once a book is added, it is displayed in a dynamic table listing all the books that have been entered during the current session.
Each book entry shows the title, author, and year.
If no books are added yet, a message informs the user that the list is empty.

Reset Book List (not required, but added to simplify testing):

A "Reset Book List" button is provided that allows users to clear the list of books. Clicking this button clears the session data, effectively removing all the added books.
The system ensures that after resetting, the page reloads without re-submitting the form.

Error Handling:

The system includes error handling using PHP's try-catch mechanism. If any required input (title, author, or year) is invalid or missing, the form submission is halted, and the user is shown a relevant error message.
This system is a practical example of integrating HTML forms with PHP sessions, OOP, and validation to manage data persistently within a user session.



