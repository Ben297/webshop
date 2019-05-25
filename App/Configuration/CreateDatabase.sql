-- Erase former database
Drop DATABASE webshop;
-- Create new database
Create DATABASE webshop;
Use webshop;

Create Table User
(
    ID           int NOT NULL AUTO_INCREMENT,
    Email        varchar(255),
    Password     varchar(255),
    Firstname    varchar(255),
    Lastname     varchar(255),
    FailedLogins int,
    PRIMARY KEY (ID)
);

Create Table Address
(
    ID         int NOT NULL AUTO_INCREMENT,
    UserID     int,
    Streetname varchar(255),
    HouseNr    varchar(10),
    ZipCode    int,
    City       varchar(255),
    Country    varchar(255),
    PRIMARY KEY (ID),
    FOREIGN KEY (UserID) REFERENCES User (ID)
);

Create Table Cookie
(
    ID             int NOT NULL AUTO_INCREMENT,
    Cookie         varchar(255),
    UserID         int,
    LoggedIn       Boolean,
    ExpirationDate date,
    PRIMARY KEY (ID),
    FOREIGN KEY (UserID) REFERENCES User (ID)
);

Create Table Item
(
    ID          int NOT NULL AUTO_INCREMENT,
    ItemName    varchar(255),
    Description varchar(255),
    Price       double,
    Stock       int,
    ImgPath varchar(255),
    PRIMARY KEY (ID)
);

Create Table Basket
(
    ID         int NOT NULL AUTO_INCREMENT,
    ItemID     int,
    Amount     int,
    Cookie     varchar(255),
    BasketDate date,
    PRIMARY KEY (ID),
    FOREIGN KEY (ItemID) REFERENCES Item (ID)
);

CREATE Table PaymentMethod
(
    ID          int NOT NULL AUTO_INCREMENT,
    PaymentName varchar(255),
    PRIMARY KEY (ID)
);

Create Table Orders
(
    ID              int NOT NULL AUTO_INCREMENT,
    UserID          int,
    PaymentMethodID int,
    Price           double,
    OrderData       date,
    PRIMARY KEY (ID),
    FOREIGN KEY (UserID) REFERENCES User (ID),
    FOREIGN KEY (PaymentMethodID) REFERENCES PaymentMethod (ID)
);

Create Table Order_Details
(
    ID         int NOT NULL AUTO_INCREMENT,
    OrderID    int,
    ItemID     int,
    UserID     int,
    ItemAmount int,
    TotalPrice double,
    PRIMARY KEY (ID),
    FOREIGN KEY (ItemID) REFERENCES Item (ID),
    FOREIGN KEY (UserID) REFERENCES User (ID)
);

-- database seed User
INSERT Into User
VALUES (NULL, 'maxmustermann@test.de', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'Max',
        'Mustermann', 0);

INSERT Into Address
Values (Null, 1, 'Musterstraße', 42, 12345, 'Musterhausen', 'Germany');

-- database seed Dogs
INSERT INTO item (ID, ItemName, Description, Price, Stock, ImgPath)
VALUES (NULL, 'Paul', 'nice and handsome dog', 1000, 77,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Wuff', 'nice and handsome dog', 2000, 12,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Destroyer', 'nice and handsome dog', 1500, 212,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Lessi', 'nice and handsome dog', 1600, 25,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Brian ', 'nice and handsome dog', 800, 17,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Snuffles ', 'nice and handsome dog', 750, 95,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Snowball', 'nice and handsome dog', 870, 63,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Snowball', 'nice and handsome dog', 870, 63,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Snowball', 'nice and handsome dog', 870, 63,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
        (NULL, 'Snowball', 'nice and handsome dog', 870, 63,
         '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Whiskey', 'nice and handsome dog', 999, 88,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg'),
       (NULL, 'Whiskey', 'nice and handsome dog', 999, 88,
        '../../resources/img/300px-Australian_Shepherd_Blue_Merle.jpg');

