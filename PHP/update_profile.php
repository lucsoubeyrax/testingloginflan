<?php
  require_once "db_connection.php";
  
  // Giriş yapmış kullanıcının bilgilerini veritabanından çekme
  $user_id = $_SESSION["user_id"];
  $sql = "SELECT * FROM users WHERE id = $user_id";
  $result = mysqli_query($conn, $sql);
  $user = mysqli_fetch_assoc($result);

  // Formdan gelen verileri değişkenlere atama
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $password = $_POST["password"];

  // Formdan gelen dosya varsa profil resmini güncelleme
  if ($_FILES["profile_photo"]["name"] !== '') {
    $target_dir = "../PROFPHOTO/";
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_file_name = $user_id . "_" . time() . "." . $imageFileType;
    $target_file = $target_dir . $new_file_name;

    // Dosya türü kontrolü
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
      echo "Sadece JPG, JPEG, PNG dosyaları desteklenmektedir.";
      exit();
    }

    // Dosya yükleme
    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
      $sql = "UPDATE users SET profile_photo = '$new_file_name' WHERE id = $user_id";
      mysqli_query($conn, $sql);
    } else {
      echo "Dosya yüklenirken bir hata oluştu.";
      exit();
    }
  }

  // Şifre kontrolü ve güncelleme
  if ($password !== '') {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = '$password_hash' WHERE id = $user_id";
    mysqli_query($conn, $sql);
  }

  // Ad ve soyad güncelleme
  if ($name !== '' || $surname !== '') {
    $sql = "UPDATE users SET name = '$name', surname = '$surname' WHERE id = $user_id";
    mysqli_query($conn, $sql);
  }

  // Kullanıcıyı profil sayfasına yönlendirme
  header("Location: profile.php");
?>
