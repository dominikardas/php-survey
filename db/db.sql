DROP DATABASE IF EXISTS PHP_Survey;
CREATE DATABASE PHP_Survey;

USE PHP_Survey;

CREATE TABLE Surveys (
    id INT NOT NULL AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL,
    options JSON, -- { [ { "id" : "1", "option" : "Option 1" }, { "id" : "2", "option" : "Option 2" }, ] } 
    PRIMARY KEY (id)
);

CREATE TABLE Votes (
    id INT NOT NULL AUTO_INCREMENT,
    survey_id INT NOT NULL,
    voted_option INT NOT NULL,
    user_ip VARCHAR(255) NOT NULL, -- IP
    PRIMARY KEY (id),
    FOREIGN KEY (survey_id) REFERENCES Surveys(id)
)

-- Demo data

INSERT INTO Surveys VALUES
    (NULL, 'Question One', '[{ "id" : 1, "option" : "Option 1" },{ "id" : 2, "option" : "Option 2" },{ "id" : 3, "option" : "Option 3" }]'),
    (NULL, 'Question Two', '[{ "id" : 1, "option" : "Option 1" },{ "id" : 2, "option" : "Option 2" },{ "id" : 3, "option" : "Option 3" }]'),
    (NULL, 'Question Three', '[{ "id" : 1, "option" : "Option 1" },{ "id" : 2, "option" : "Option 2" },{ "id" : 3, "option" : "Option 3" }]');

INSERT INTO Votes VALUES

    (NULL, 1, 1, '127.0.0.1'),
    (NULL, 1, 1, '127.0.0.1'),
    (NULL, 1, 2, '127.0.0.1'),
    (NULL, 1, 3, '127.0.0.1'),
    (NULL, 1, 3, '127.0.0.1'),
    (NULL, 1, 3, '127.0.0.1'),

    (NULL, 2, 1, '127.0.0.1'),
    (NULL, 2, 2, '127.0.0.1'),
    (NULL, 2, 2, '127.0.0.1'),
    (NULL, 2, 2, '127.0.0.1'),
    (NULL, 2, 2, '127.0.0.1'),
    (NULL, 2, 3, '127.0.0.1'),

    (NULL, 3, 1, '127.0.0.1'),
    (NULL, 3, 1, '127.0.0.1'),
    (NULL, 3, 1, '127.0.0.1'),
    (NULL, 3, 1, '127.0.0.1'),
    (NULL, 3, 1, '127.0.0.1'),
    (NULL, 3, 2, '127.0.0.1');




