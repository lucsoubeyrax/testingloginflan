<?php
// veritabanı bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chatdata";

// bağlantı oluşturma
$conn = new mysqli($servername, $username, $password, $dbname);

// bağlantı kontrolü
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// formdan gelen verileri alma ve değişkenlere atama
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// şifrenin en az 9 karakter olmasını kontrol etme
if (strlen($password) < 9) {
    echo "Şifre en az 9 karakter olmalıdır.";
    exit();
}

// şifreyi hashleme
$password = password_hash($password, PASSWORD_DEFAULT);

// profil resmi yükleme işlemleri
$target_dir = "../PROFPHOTO/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["register"])) {
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "Profil resmi başarıyla yüklendi.";
        } else {
            echo "Profil resmi yükleme hatası.";
        }
    } else {
        echo "Dosya seçilen bir resim değil.";
    }
}

// veritabanına kayıt ekleme
$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Kayıt başarıyla oluşturuldu.";
} else {
    echo "Kayıt oluşturma hatası: " . $sql . "<br>" . $conn->error;
}

// bağlantıyı kapatma
$conn->close();
?>
