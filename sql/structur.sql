CREATE DATABASE quiz;
use quiz;
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    label VARCHAR(50) NOT NULL
);
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
CREATE TABLE quizzes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    code_quiz VARCHAR(50) NOT NULL UNIQUE,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
CREATE TABLE questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT,
    question TEXT NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);
CREATE TABLE answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    question_id INT,
    answer TEXT NOT NULL,
    is_correct BOOLEAN NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);
CREATE TABLE results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    quiz_id INT,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);
-- 1. Insert l-Role (ila makanch 3ndek)
INSERT INTO roles (label) VALUES ('Formateur'), ('Apprenant');

-- 2. Insert User (Formateur li gha ikoun moul l-quiz)
-- Password '123456' (haché b password_hash f PHP)
INSERT INTO users (name, email, password, role_id) 
VALUES ('Amine Coach', 'amine@codeacademy.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);

-- 3. Insert Quiz (Axe 2 & 3)
-- Ghadi nkhdm b code_quiz 'PHP2026' bach t-tester bih f homepageS.php
INSERT INTO quizzes (title, description, code_quiz, user_id) 
VALUES ('Quiz PHP Basics', 'Évaluation sur les bases de PHP OOP et PDO', 'PHP2026', 1);

-- 4. Insert Questions (Axe 3)
-- Question 1
INSERT INTO questions (quiz_id, question) 
VALUES (1, 'Que signifie l''acronyme PDO en PHP ?');

-- Question 2
INSERT INTO questions (quiz_id, question) 
VALUES (1, 'Quelle méthode est utilisée pour exécuter une requête préparée ?');

-- 5. Insert Answers (Options pour Question 1)
INSERT INTO answers (question_id, answer, is_correct) VALUES 
(1, 'PHP Data Objects', 1),
(1, 'Personal Data Object', 0),
(1, 'PHP Database Orientation', 0),
(1, 'Programmable Data Object', 0);

-- 6. Insert Answers (Options pour Question 2)
INSERT INTO answers (question_id, answer, is_correct) VALUES 
(2, 'query()', 0),
(2, 'execute()', 1),
(2, 'run()', 0),
(2, 'fetch()', 0);