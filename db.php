CREATE DATABASE library;
USE library;

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    genre VARCHAR(100),
    year_published INT
);

-- Sample books
INSERT INTO books (title, author, genre, year_published) VALUES
('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1960),
('1984', 'George Orwell', 'Dystopian', 1949),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 1925),
('Pride and Prejudice', 'Jane Austen', 'Romance', 1813),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 1937);
