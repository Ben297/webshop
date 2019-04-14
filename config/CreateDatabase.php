
Create database webshop;

Create Table User (ID int NOT NULL AUTO_INCREMENT, Email varchar(255), Password varchar(255), Firstname varchar(255),Lastname varchar(255),PRIMARY KEY(ID));

Create Table Cookie (ID int NOT NULL AUTO_INCREMENT, Cookie varchar(255), UserID int,LoggedIn Boolean , ExpirationDate date ,PRIMARY KEY(ID),FOREIGN KEY (UserID) REFERENCES User(ID));

Create Table Basket(ID int NOT NULL AUTO_INCREMENT, ItemID int, Amount int, Cookie varchar(255),BasketDate date,PRIMARY KEY(ID),FOREIGN KEY (ItemID) REFERENCES Item(ID));

Create Table Item(ID int NOT NULL AUTO_INCREMENT, ItemName varchar(255),Description varchar(255), Price double ,Stock int,PRIMARY KEY(ID));

Create Table Orders(ID int NOT NULL AUTO_INCREMENT, UserID int ,PaymentMethodID int , OrderAmount int, Price double , PRIMARY KEY(ID),FOREIGN KEY (UserID) REFERENCES  User(ID));

Create Table Order_Details (ID int NOT NULL AUTO_INCREMENT, OrderID int , ItemID int,PRIMARY KEY(ID));

Create Table Address (ID int NOT NULL AUTO_INCREMENT, Streetname varchar(255),HouseNr varchar(10),ZipCode int , City varchar(255),PRIMARY KEY(ID));

CREATE Table PaymentMethode (ID int NOT NULL AUTO_INCREMENT , PaymentName varchar(255));

