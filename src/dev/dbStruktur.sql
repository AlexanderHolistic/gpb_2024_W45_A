 USE notizy_404;

 CREATE TABLE `user` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

 CREATE TABLE notizen (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL,
    FOREIGN KEY (Username) REFERENCES user(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    Titel VARCHAR(255) NOT NULL,
    Inhalt varchar (500) NOT NULL,
    Date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
 );