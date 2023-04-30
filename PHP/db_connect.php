<?php

// Veritabanı bağlantısı için gerekli bilgileri buraya girin
$servername = "localhost"; // Sunucu adı
$username = "root"; // Veritabanı kullanıcı adı
$password = ""; // Veritabanı kullanıcı şifresi
$dbname = "chatdata"; // Veritabanı adı

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
}

echo "Veritabanı bağlantısı başarılı";

?>
