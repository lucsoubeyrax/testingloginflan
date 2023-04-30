<?php
// Veritabanına bağlan
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatdata";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kullanıcının kimliğini al
session_start();
if(isset($_SESSION['user_id'])){
  $user_id = $_SESSION['user_id'];

  // Kullanıcının bilgilerini veritabanından al
  $sql = "SELECT * FROM users WHERE id='$user_id'";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();

  // Veritabanı bağlantısını kapat
  $conn->close();

  // Kullanıcı bilgilerini döndür
  echo json_encode($row);
} else {
  // Kullanıcı girişi yapılmamışsa hata döndür
  echo "Kullanıcı girişi yapılmadı.";
}
?>
