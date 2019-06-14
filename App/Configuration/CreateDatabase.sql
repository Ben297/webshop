CREATE DATABASE IF NOT EXISTS webshop;
use webshop;

/*clean Database before new seed*/
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS User,Orders,OrderStatus,Address,Item,Basket,Cookie,Session,Order_Details,PaymentMethod;

Create Table User
(
    ID           int NOT NULL AUTO_INCREMENT,
    Email        varchar(255),
    Password     varchar(255),
    Firstname    varchar(255),
    Lastname     varchar(255),
    FailedLogins int,
    DeleteFlag   int NULL,
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



Create Table Session
(
    ID        int NOT NULL AUTO_INCREMENT,
    SessionID varchar(255),
    UserID    int,
    LoggedIn  Boolean,
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
    ImgPath     varchar(255),
    PRIMARY KEY (ID)
);

Create Table Cookie
(
    ID         int NOT NULL AUTO_INCREMENT,
    CookieID   varchar(255),
    ItemAmount int,
    ItemID     int,
    PRIMARY KEY (ID),
    FOREIGN KEY (ItemID) REFERENCES Item (ID)
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
CREATE TABLE OrderStatus
(
    ID     int NOT NULL AUTO_INCREMENT,
    Status varchar(255),
    PRIMARY KEY (ID)
);

Create Table Orders
(
    ID              int NOT NULL AUTO_INCREMENT,
    UserID          int,
    AddressID       int,
    PaymentMethodID int,
    TotalPrice      double,
    OrderDate       date,
    OrderStatus     int,
    PRIMARY KEY (ID),
    FOREIGN KEY (UserID) REFERENCES User (ID) ON DELETE CASCADE,
    FOREIGN KEY (AddressID) REFERENCES Address (ID),
    FOREIGN KEY (PaymentMethodID) REFERENCES PaymentMethod (ID),
    FOREIGN KEY (OrderStatus) REFERENCES OrderStatus (ID)

);


Create Table Order_Details
(
    ID         int NOT NULL AUTO_INCREMENT,
    OrderID    int,
    ItemID     int,
    ItemAmount int,
    TotalPrice double,
    PRIMARY KEY (ID),
    FOREIGN KEY (ItemID) REFERENCES Item (ID),
    FOREIGN KEY (OrderID) REFERENCES Orders (ID)
);

-- database seed User
INSERT Into User
VALUES (NULL, 'test@test.de', '$2y$10$RaxBKownRHaZgUnbh5qeX.aq28krVPu/1s6OKq.SfzYFMOs7wd1t2', 'Tester1',
        'Testermann', 0,0);

INSERT Into Address
Values (Null, 1, 'Musterstraße', 42, 12345, 'Musterhausen', 'Germany');

INSERT INTO Orders
VALUES (NULL, 1, 0, 2, 500, CURRENT_TIMESTAMP, 2);

-- database seed Dogs
INSERT INTO Item (ID, ItemName, Description, Price, Stock, ImgPath)
VALUES (NULL, 'Paul',
        'Border Collie, is a working and herding dog breed especially for sheep. It was specifically bred for intelligence and obedience',
        999.99, 2, '/img/dog1.jpg'),
       (NULL, 'Wuff',
        'Leonberger can weigh up to a 170 pounds and stand at 31 inches. You''ll have a watchdog and friend for life. Just make sure you have a few brushes around, because these guys need some constant grooming',
        1999.99, 12, '/img/Leonberger.jpg'),
       (NULL, 'Destroyer',
        'German Shepherd, is a breed of medium to large-sized working dog that originated in Germany', 1499.99, 50,
        '/img/GermanShepherd.jpg'),
       (NULL, 'Lessi',
        'Beauceron,  were originally working dogs who were used to herd sheep. Best for experienced owners', 429.99, 25,
        '/img/Beauceron.jpg'),
       (NULL, 'Brian ',
        'Belgian Sheepdog, is made for hard work, which means they train incredibly easily and rarely tire! While they are always dedicated to the task at hand, these dogs still crave love and attention on moments when they''re "off the clock"',
        386.99, 7, '/img/BelgianSheepdog.jpg'),
       (NULL, 'Snuffles ',
        'Labrador, Originally bred as a retriever for hunting and fishing, now the Labrador is often chosen by families for its characteristic loving, gentle temperament',
        749.99, 95, '/img/Labrador.jpg'),
       (NULL, 'Snowball',
        'Hovawart, will need proper attention and care as pups to create a special bond with their families, but the love and devotion they have with their owners for life is worth the effort for years to come',
        249.99, 63, '/img/Hovawart.jpg'),
       (NULL, 'Whiskey',
        'Great Dane, can grow up to 32 inches tall! But despite their size, these dependable, friendly canines are just gentle giants at heart',
        999.99, 88, '/img/GreatDane.jpg');

-- payment methods
INSERT INTO PaymentMethod
VALUES (Null, 'Paypal'),
       (NULL, 'Prepayment'),
       (Null, 'Creditcard');

INSERT INTO OrderStatus
VALUES (Null, 'open'),
       (NULL, 'Processing'),
       (Null, 'Complete');