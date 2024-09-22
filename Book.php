<?php

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
        if(empty($title)) {
            throw new Exception("Title cannot be empty. Please complete the form.");
        }
        $this->title = $title;
    }

    public function setAuthor($author) {
        if(empty($author)) {
            throw new Exception("Author cannot be empty. Please complete the form.");
        }
        $this->author = $author;
    }

    public function setYear($year) {
        if(!is_numeric($year) || $year < 1000 || $year > intval(date("Y"))) {
            throw new Exception("Invalid publication year. Year must not be earlier than 1000 or later than the current year.");
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

    public function displayBook() {
        return "<tr><td>{$this->getTitle()}</td><td>{$this->getAuthor()}</td><td>{$this->getYear()}</td></tr>";
    }
}
?>
