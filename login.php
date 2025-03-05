<?php
// Kết nối cơ sở dữ liệu
include('config.php');

$error_message = ''; // Biến chứa thông báo lỗi

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy username và mật khẩu người dùng
    $username = mysqli_real_escape_string($conn, $_POST['username']); // Thay email bằng username
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Câu truy vấn SQL để lấy thông tin người dùng dựa trên username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    // Kiểm tra xem người dùng có tồn tại không
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công, lưu thông tin vào session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username']; // Thay user['name'] bằng user['username']
            $_SESSION['user_email'] = null; // Không có email trong DB, để null hoặc bỏ

            // Chuyển hướng đến trang dashboard (vì không có role trong DB)
            header("Location: admin.php");
            exit();
        } else {
            // Mật khẩu không chính xác
            $error_message = "Sai mật khẩu!";
        }
    } else {
        // Không tìm thấy người dùng
        $error_message = "Tài khoản không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crew Management</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="assets/images/logo.png">
  <link rel="stylesheet" href="css/login.css">

  <style>
    body {
      background: url('assets/background/background.jpg') no-repeat center center fixed;
      background-size: cover;
    }
  </style>
</head>

<body>
  <!-- Hiển thị thông báo lỗi nếu có -->
  <?php if (!empty($error_message)): ?>
    <div class="alert alert-danger fade show centered-alert" role="alert">
      <?php echo $error_message; ?>
      <a href="index.php" class="btn btn-danger mt-2">Quay lại trang chủ</a> <!-- Nút quay lại trang chủ -->
    </div>
  <?php endif; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>