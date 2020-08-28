DROP DATABASE IF EXISTS PHP_Survey;
CREATE DATABASE PHP_Survey;

USE PHP_Survey;

CREATE TABLE Surveys (
    id INT NOT NULL AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL,
    options JSON,
    PRIMARY KEY (id)
);

CREATE TABLE Votes (
    id INT NOT NULL AUTO_INCREMENT,
    survey_id INT NOT NULL,
    voted_option INT NOT NULL,
    user_ip VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (survey_id) REFERENCES Surveys(id)
);