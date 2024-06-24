
-- Creating the admin table
CREATE TABLE admin (
  AdminID int(11) NOT NULL AUTO_INCREMENT,
  Username varchar(50) NOT NULL,
  Password varchar(255) NOT NULL,
  PRIMARY KEY (AdminID),
  UNIQUE KEY Username (Username)
);

-- Inserting data into the admin table
INSERT INTO admin (Username, Password) VALUES
('admin@test.com', 'admin');

-- Creating the clients table
CREATE TABLE clients (
  ClientID int(11) NOT NULL AUTO_INCREMENT,
  FirstName varchar(255) NOT NULL,
  LastName varchar(255) NOT NULL,
  Email varchar(255) NOT NULL,
  Password varchar(255) NOT NULL,
  Address varchar(255),
  PhoneNumber varchar(20),
  PRIMARY KEY (ClientID),
  UNIQUE KEY Email (Email)
);

-- Inserting data into the clients table
INSERT INTO clients (FirstName, LastName, Email, Password, Address, PhoneNumber) VALUES
('John', 'Doe', 'john.doe@gamil.com', 'hash1', '123 Main St', '1234567890'),
('Jane', 'Smith', 'jane.smith@gmail.com', 'hash2', '456 Elm St', '2345678901'),
('Alice', 'Johnson', 'alice.johnson@gmail.com', 'hash3', '789 Oak St', '3456789012'),
('Bob', 'Brown', 'bob.brown@gmail.com', 'hash4', '101 Pine St', '4567890123'),
('Carol', 'Davis', 'carol.davis@gmail.com', 'hash5', '202 Maple St', '5678901234'),
('David', 'Wilson', 'david.wilson@gmail.com', 'hash6', '303 Birch St', '6789012345'),
('Eva', 'Moore', 'eva.moore@gmail.com', 'hash7', '404 Cedar St', '7890123456'),
('Frank', 'Taylor', 'frank.taylor@gmail.com', 'hash8', '505 Ash St', '8901234567'),
('Grace', 'Anderson', 'grace.anderson@gmail.com', 'hash9', '606 Cherry St', '9012345678'),
('Henry', 'Thomas', 'henry.thomas@gmail.com', 'hash10', '707 Walnut St', '0123456789'),
('Ivy', 'Martin', 'ivy.martin@gmail.com', 'hash11', '808 Beech St', '1234567800'),
('Jack', 'Jackson', 'jack.jackson@gmail.com', 'hash12', '909 Hickory St', '2345678900'),
('Karen', 'White', 'karen.white@gmail.com', 'hash13', '1010 Fir St', '3456789001'),
('Leo', 'Harris', 'leo.harris@gmail.com', 'hash14', '1111 Spruce St', '4567890012'),
('Mia', 'Lewis', 'mia.lewis@gmail.com', 'hash15', '1212 Poplar St', '5678900123'),
('Noah', 'Walker', 'noah.walker@gmail.com', 'hash16', '1313 Hemlock St', '6789011234'),
('Olivia', 'Hall', 'olivia.hall@gmail.com', 'hash17', '1414 Dogwood St', '7890122345'),
('Paul', 'Young', 'paul.young@gmail.com', 'hash18', '1515 Willow St', '8901233456'),
('Quinn', 'King', 'quinn.king@gmail.com', 'hash19', '1616 Alder St', '9012344567'),
('Rose', 'Scott', 'rose.scott@gmail.com', 'hash20', '1717 Redwood St', '0123455678');

-- Creating the orders table
CREATE TABLE orders (
  OrderID int(11) NOT NULL AUTO_INCREMENT,
  ClientID int(11),
  OrderDate timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  TotalAmount decimal(10,2),
  OrderStatus varchar(20),
  PRIMARY KEY (OrderID),
  KEY ClientID (ClientID),
  CONSTRAINT orders_ibfk_1 FOREIGN KEY (ClientID) REFERENCES clients (ClientID)
);

-- Inserting data into the orders table
INSERT INTO orders (ClientID, OrderDate, TotalAmount, OrderStatus) VALUES
(1, '2024-01-01 10:00:00', 10000.50, 'Completed'),
(2, '2024-01-02 11:00:00', 20000.75, 'Pending'),
(3, '2024-01-03 12:00:00', 15000.25, 'Shipped'),
(4, '2024-01-04 13:00:00', 17500.00, 'Cancelled'),
(5, '2024-01-05 14:00:00', 8000.99, 'Completed'),
(6, '2024-01-06 15:00:00', 12000.49, 'Pending'),
(7, '2024-01-07 16:00:00', 30000.00, 'Shipped'),
(8, '2024-01-08 17:00:00', 22000.99, 'Cancelled'),
(9, '2024-01-09 18:00:00', 9900.99, 'Completed'),
(10, '2024-01-10 19:00:00', 45000.75, 'Pending'),
(11, '2024-01-11 20:00:00', 32000.89, 'Shipped'),
(12, '2024-01-12 21:00:00', 21000.55, 'Cancelled'),
(13, '2024-01-13 22:00:00', 18000.45, 'Completed'),
(14, '2024-01-14 23:00:00', 50000.00, 'Pending'),
(15, '2024-01-15 09:00:00', 40000.00, 'Shipped'),
(16, '2024-01-16 08:00:00', 25000.00, 'Cancelled'),
(17, '2024-01-17 07:00:00', 19000.75, 'Completed'),
(18, '2024-01-18 06:00:00', 27000.50, 'Pending'),
(19, '2024-01-19 05:00:00', 36000.00, 'Shipped'),
(20, '2024-01-20 04:00:00', 13000.25, 'Cancelled');

-- Creating the product table

CREATE TABLE product (
  ProductID int(11) NOT NULL AUTO_INCREMENT,
  ProductName varchar(255) NOT NULL,
  Description text,
  Category text,
  SupplierID varchar(100),
  OldPrice decimal(10,2) NOT NULL,
  SpecialPrice decimal(10,2),
  QuantityInStock int(11),
  DateAdded date,
  LastUpdated timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  Discount decimal(5,2),
  ImageURL varchar(255),
  Rating decimal(3,2),
  Status varchar(20),
  Brand varchar(40),
  PRIMARY KEY (ProductID)
);

-- Inserting data into the product table
INSERT INTO product (ProductName, Description, Category, SupplierID, OldPrice, SpecialPrice, QuantityInStock, DateAdded, Discount, ImageURL, Rating, Status, Brand) VALUES
('Intel Core i9-11900K', '8 Cores, 16 Threads, 3.5 GHz, 5.3 GHz Turbo', 'CPU', 'Supplier 1', 149500.00, 141000.00, 50, '2023-01-01', 5.45, 'cpu1.jpg', 4.8, 'Available', 'Intel'),
('AMD Ryzen 9 5900X', '12 Cores, 24 Threads, 3.7 GHz, 4.8 GHz Turbo', 'CPU', 'Supplier 2', 157800.00, 149500.00, 30, '2023-01-02', 5.17, 'cpu2.jpg', 4.7, 'Available', 'AMD'),
('NVIDIA RTX 3090', '24GB GDDR6X, PCIe 4.0', 'GPU', 'Supplier 3', 544000.00, 489600.00, 20, '2023-01-03', 10.00, 'gpu1.jpg', 4.9, 'Available', 'NVIDIA'),
('AMD Radeon RX 6900 XT', '16GB GDDR6, PCIe 4.0', 'GPU', 'Supplier 4', 408000.00, 381000.00, 25, '2023-01-04', 6.67, 'gpu2.jpg', 4.6, 'Available', 'AMD'),
('Corsair Vengeance LPX 16GB', 'DDR4, 3200MHz', 'RAM', 'Supplier 5', 21760.00, 19040.00, 100, '2023-01-05', 12.50, 'ram1.jpg', 4.5, 'Available', 'Corsair'),
('G.SKILL Trident Z RGB 32GB', 'DDR4, 3600MHz', 'RAM', 'Supplier 6', 43520.00, 38100.00, 60, '2023-01-06', 12.50, 'ram2.jpg', 4.8, 'Available', 'G.SKILL'),
('ASUS ROG Strix Z590-E', 'ATX, LGA 1200', 'Mother Board', 'Supplier 7', 81600.00, 73440.00, 40, '2023-01-07', 10.00, 'mb1.jpg', 4.7, 'Available', 'ASUS'),
('MSI MPG B550 Gaming Edge WiFi', 'ATX, AM4', 'Mother Board', 'Supplier 8', 48960.00, 43520.00, 50, '2023-01-08', 11.11, 'mb2.jpg', 4.6, 'Available', 'MSI'),
('NZXT H510', 'Mid Tower, Tempered Glass', 'PC case', 'Supplier 9', 19040.00, 16320.00, 80, '2023-01-09', 14.29, 'case1.jpg', 4.4, 'Available', 'NZXT'),
('Corsair 4000D Airflow', 'Mid Tower, High Airflow', 'PC case', 'Supplier 10', 21760.00, 19040.00, 60, '2023-01-10', 12.50, 'case2.jpg', 4.6, 'Available', 'Corsair'),
('Samsung 970 EVO Plus 1TB', 'NVMe M.2 SSD', 'Memory', 'Supplier 11', 48960.00, 43520.00, 100, '2023-01-11', 11.11, 'ssd1.jpg', 4.8, 'Available', 'Samsung'),
('WD Blue 1TB', 'SATA III HDD', 'Memory', 'Supplier 12', 13600.00, 12240.00, 150, '2023-01-12', 10.00, 'hdd1.jpg', 4.3, 'Available', 'Western Digital'),
('Logitech G502', 'High Performance Gaming Mouse', 'Mouse', 'Supplier 13', 13600.00, 12240.00, 70, '2023-01-13', 10.00, 'mouse1.jpg', 4.7, 'Available', 'Logitech'),
('Razer DeathAdder V2', 'Ergonomic Gaming Mouse', 'Mouse', 'Supplier 14', 19040.00, 16320.00, 50, '2023-01-14', 14.29, 'mouse2.jpg', 4.6, 'Available', 'Razer'),
('Corsair K95 RGB Platinum', 'Mechanical Gaming Keyboard', 'Keyboard', 'Supplier 15', 54400.00, 48960.00, 40, '2023-01-15', 10.00, 'keyboard1.jpg', 4.8, 'Available', 'Corsair'),
('SteelSeries Apex Pro', 'Mechanical Gaming Keyboard', 'Keyboard', 'Supplier 16', 59840.00, 54400.00, 30, '2023-01-16', 9.09, 'keyboard2.jpg', 4.9, 'Available', 'SteelSeries'),
('HyperX Cloud II', '7.1 Surround Sound', 'Headset', 'Supplier 17', 27200.00, 24480.00, 50, '2023-01-17', 10.00, 'headset1.jpg', 4.7, 'Available', 'HyperX'),
('Razer BlackShark V2', 'Esports Gaming Headset', 'Headset', 'Supplier 18', 32640.00, 29920.00, 40, '2023-01-18', 8.33, 'headset2.jpg', 4.6, 'Available', 'Razer'),
('SteelSeries QcK', 'Large Gaming Mousepad', 'Mousepad', 'Supplier 19', 5440.00, 4896.00, 70, '2023-01-19', 10.00, 'mousepad1.jpg', 4.5, 'Available', 'SteelSeries'),
('Corsair MM300', 'Anti-Fray Cloth Gaming Mousepad', 'Mousepad', 'Supplier 20', 6800.00, 5984.00, 60, '2023-01-20', 12.00, 'mousepad2.jpg', 4.4, 'Available', 'Corsair'),
('ASUS TUF Gaming VG27AQ', '27" WQHD, 165Hz, IPS', 'Monitors', 'Supplier 21', 108800.00, 95200.00, 30, '2023-01-21', 12.50, 'monitor1.jpg', 4.7, 'Available', 'ASUS');

CREATE TABLE orderdetail (
  OrderDetailID int(11) NOT NULL AUTO_INCREMENT,
  OrderID int(11),
  ProductID int(11),
  Quantity int(11),
  Subtotal decimal(10,2),
  PRIMARY KEY (OrderDetailID),
  KEY OrderID (OrderID),
  KEY ProductID (ProductID),
  CONSTRAINT orderdetail_ibfk_1 FOREIGN KEY (OrderID) REFERENCES orders (OrderID),
  CONSTRAINT orderdetail_ibfk_2 FOREIGN KEY (ProductID) REFERENCES product (ProductID)
);
INSERT INTO orderdetail (OrderID, ProductID, Quantity, Subtotal) VALUES
(1, 1, 2, 1040.00),
(2, 2, 1, 550.00),
(3, 3, 1, 1800.00),
(4, 4, 1, 1400.00),
(5, 5, 2, 140.00),
(6, 6, 2, 280.00),
(7, 7, 1, 270.00),
(8, 8, 1, 160.00),
(9, 9, 2, 120.00),
(10, 10, 2, 140.00),
(11, 11, 1, 160.00),
(12, 12, 1, 45.00),
(13, 13, 2, 90.00),
(14, 14, 1, 60.00),
(15, 15, 1, 180.00),
(16, 16, 1, 200.00),
(17, 17, 1, 90.00),
(18, 18, 1, 110.00),
(19, 19, 2, 36.00),
(20, 20, 2, 44.00);


CREATE TABLE brand_logos (
  LogoID int(11) NOT NULL AUTO_INCREMENT,
  BrandName varchar(40) NOT NULL,
  LogoURL varchar(255) NOT NULL,
  PRIMARY KEY (LogoID),
  UNIQUE KEY BrandName (BrandName)
);

INSERT INTO brand_logos (BrandName, LogoURL) VALUES
('Intel', 'intel.svg'),
('AMD', 'amd_logo.png'),
('JBL', 'jbl.svg'),
('LENOVO', 'lenovo.svg'),
('LOGITECH', 'logitech.svg'),
('MSI', 'msi.png'),
('NVIDIA', 'nvidia.svg'),
('CORSAIR', 'corsair.png'),
('ASUS', 'asus.png'),
('SAMSUNG', 'samsung.svg');