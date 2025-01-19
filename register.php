<?php
// Kết nối cơ sở dữ liệu
include('config.php');

$error_message = ''; // Biến chứa thông báo lỗi
$alert_class = ''; // Biến chứa lớp thông báo

// Kiểm tra nếu form đã được gửi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Xử lý và kiểm tra các trường dữ liệu
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $date_of_birth = mysqli_real_escape_string($conn, $_POST['date_of_birth']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);

    // Kiểm tra nếu email đã tồn tại trong cơ sở dữ liệu
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conn, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // Email đã tồn tại
        $error_message = "Email đã được đăng ký! Vui lòng sử dụng email khác.";
        $alert_class = 'alert-danger'; // Màu đỏ
    } else {
        // Kiểm tra mật khẩu có đủ điều kiện không
        if (strlen($password) < 8) {
            $error_message = "Mật khẩu phải có ít nhất 8 ký tự.";
            $alert_class = 'alert-danger'; // Màu đỏ
        } elseif (!preg_match('/[A-Z]/', $password)) {
            $error_message = "Mật khẩu phải chứa ít nhất một ký tự in hoa.";
            $alert_class = 'alert-danger'; // Màu đỏ
        } elseif (!preg_match('/[\W_]/', $password)) {
            $error_message = "Mật khẩu phải chứa ít nhất một ký tự đặc biệt.";
            $alert_class = 'alert-danger'; // Màu đỏ
        } else {
            // Mã hóa mật khẩu để bảo mật
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Xử lý tải lên ảnh đại diện
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
                $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
                move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture);
            } else {
                $profile_picture = null;  // Trường hợp không tải ảnh lên
            }

            // Thiết lập role mặc định (ví dụ 'nhanvien')
            $role = 'nhanvien';

            // Trạng thái mặc định là 'inactive'
            $status = 'inactive';

            // Câu truy vấn SQL để thêm người dùng vào cơ sở dữ liệu
            $sql = "INSERT INTO users (name, email, password, role, phone_number, address, date_of_birth, profile_picture, gender, status) 
                    VALUES ('$name', '$email', '$hashed_password', '$role', '$phone_number', '$address', '$date_of_birth', '$profile_picture', '$gender', '$status')";

            // Thực thi câu truy vấn và hiển thị thông báo
            if (mysqli_query($conn, $sql)) {
                // Thông báo thành công (màu vàng)
                $error_message = "Đăng ký thành công! Hãy đợi để tài khoản được kích hoạt.";
                $alert_class = 'alert-warning'; // Màu vàng
            } else {
                // Thông báo lỗi
                $error_message = "Lỗi: " . mysqli_error($conn);
                $alert_class = 'alert-danger'; // Màu đỏ
            }
        }
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
  <!-- Hiển thị thông báo nếu có -->
  <?php if (!empty($error_message)): ?>
    <div class="alert <?php echo $alert_class; ?> fade show centered-alert" role="alert">
      <?php echo $error_message; ?>
      <a href="index.php" class="btn btn-danger mt-2">Quay lại trang chủ</a> <!-- Nút quay lại trang chủ -->
    </div>
  <?php endif; ?>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
