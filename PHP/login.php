<?php

// Veritabanına bağlantı
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatdata";

$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
  die("Bağlantı hatası: " . $conn->connect_error);
}

// Eğer giriş butonuna tıklandıysa
if(isset($_POST['login'])) {

  // Post edilen verileri değişkenlere aktar
  $email = $_POST['email'];
  $password = $_POST['password'];

  // SQL sorgusu
  $sql = "SELECT * FROM users WHERE email='$email'";

  // Sorguyu çalıştır ve sonucu al
  $result = $conn->query($sql);

  // Eğer sonuç varsa
  if ($result->num_rows > 0) {

    // Sonucu dizi olarak al
    $row = $result->fetch_assoc();

    // Parolaları karşılaştır
    if (password_verify($password, $row['password'])) {

      // Session başlat
      session_start();

      // Kullanıcının adını ve kimliğini kaydet
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['username'] = $row['username'];

      // Yönlendir
      header("location: ../HTML/edit_profile.html");
      exit();
    } else {
      echo "E-posta veya şifre yanlış!";
    }
  } else {
    echo "E-posta veya şifre yanlış!";
  }
}

// Veritabanı bağlantısını kapat
$conn->close();

?>
