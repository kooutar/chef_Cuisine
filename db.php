<?php
$servername = "localhost";  
$username = "root";         
$password = "";
$database="databasechef";
$conn=mysqli_connect($servername,$username,$password,$database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $createTableUser="
  CREATE TABLE IF NOT EXISTS USER(
        id_user int(11) AUTO_INCREMENT PRIMARY KEY,
        nom varchar(100) NOT NULL,
        pernom varchar(100) NOT NULL,
        email varchar(150) UNIQUE,
        password varchar(20) NOT NULL,
        telephone varchar(150) NOT NULL,
        adresse text NOT NULL,
        role ENUM('user','admin') DEFAULT 'user'
  );
  ";
  $createTableMenu="
    CREATE TABLE IF NOT EXISTS MENU(
    id_menu int(11) AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description TEXT
    );
  ";

  $createTablePlat="
  CREATE TABLE IF NOT EXISTS plate(
  id_plat int(11) AUTO_INCREMENT PRIMARY KEY,
  categorie varchar(50) NOT NULL,
  description TEXT,
  id_menu int(11)  NOT NULL,
  FOREIGN KEY (id_menu) REFERENCES  MENU(id_menu)
  );
  ";
  $createTableReservation="
  CREATE TABLE IF NOT EXISTS reservation(
  id_menu int(11) NOT NULL,
  id_user int(11) NOT NULL,
  dateReservation date NOT NULL,
  timereservation time NOT NULL,
  nbrPersonne int(11) NOT NULL,
  FOREIGN KEY (id_user) REFERENCES USER(id_user) ON DELETE CASCADE,
  FOREIGN KEY (id_menu) REFERENCES MENU(id_menu) ON DELETE CASCADE,
   PRIMARY KEY (id_menu, id_user)
  );
  ";
  $addpriceToplat="ALTER TABLE plate ADD prix DECIMAL(10,2) NOT NULL;";
  // $addpathImageToplat="ALTER TABLE plate ADD pathImage varchar(50) NOT NULL;";
  $addstatusToresevation="ALTER TABLE reservation ADD status ENUM('en attente','accepter','refuser') DEFAULT 'en attente'";
  // mysqli_query($conn,$addpriceToplat);
  // // mysqli_query($conn,$addpathImageToplat);
  // mysqli_query($conn,$addstatusToresevation);
  mysqli_query($conn,$createTableUser);
  mysqli_query($conn,$createTableMenu);
  mysqli_query($conn,$createTablePlat);
  mysqli_query($conn,$createTableReservation);
?>