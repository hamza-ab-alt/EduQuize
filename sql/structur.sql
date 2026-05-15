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
INSERT INTO roles (label) VALUES ('Formateur'), ('Apprenant');
INSERT INTO users (name, email, password, role_id) 
VALUES ('Amine Coach', 'amine@codeacademy.ma', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1);
INSERT INTO quizzes (title, description, code_quiz, user_id) 
VALUES ('Quiz PHP Basics', 'Évaluation sur les bases de PHP OOP et PDO', 'PHP2026', 1);
INSERT INTO questions (quiz_id, question) 
VALUES (1, 'Que signifie l''acronyme PDO en PHP ?');
INSERT INTO questions (quiz_id, question) 
VALUES (1, 'Quelle méthode est utilisée pour exécuter une requête préparée ?');
INSERT INTO answers (question_id, answer, is_correct) VALUES 
(4, 'PHP Data Objects', 1),
(4, 'Personal Data Object', 0),
(4, 'PHP Database Orientation', 0),
(4, 'Programmable Data Object', 0);
INSERT INTO answers (question_id, answer, is_correct) VALUES 
(5, 'query()', 0),
(5, 'execute()', 1),
(5, 'run()', 0),
(5, 'fetch()', 0);
