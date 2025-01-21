<?php
// Kiểm tra người dùng đã đăng nhập chưa
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Đăng xuất
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="assets/images/logo.png">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/f0add9272d.js"></script>
</head>

<body>

    <!-- Thanh điều hướng bên trái -->
    <div class="sidebar">
        <div class="logo">
            <img src="assets/images/logo.png" alt="Logo">
        </div>
        <a href="?page=employee_management" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'employee_management') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-circle-user"></i></div>
                <div class="text">Quản lý nhân viên</div>
            </div>
        </a>

        <a href="?page=crew_management" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'crew_management') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-face-smile"></i></div>
                <div class="text">Quản lý thuyền viên</div>
            </div>
        </a>

        <a href="?page=ship_management" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'ship_management') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-ship"></i></div>
                <div class="text">Quản lý tàu</div>
            </div>
        </a>

        <a href="?page=region_management" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'region_management') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-map-marker-alt"></i></div>
                <div class="text">Quản lý khu vực</div>
            </div>
        </a>

        <a href="?page=overview" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'overview') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-bars"></i></div>
                <div class="text">Tổng quan</div>
            </div>
        </a>

        <a href="?page=support" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'support') ? 'active' : ''; ?>">
            <div class="icon-text">
                <div class="icon"><i class="fa-solid fa-phone"></i></div>
                <div class="text">Hỗ trợ</div>
            </div>
        </a>

        <a href="?logout=true" class="text-danger">
            <div class="icon-text">
                <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
                <div class="text">Đăng xuất</div>
            </div>
        </a>
    </div>

    <!-- Nội dung trang -->
    <div class="content">
        <?php
        // Kiểm tra và include nội dung tương ứng với link đã nhấn
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'employee_management':
                    include('employee_management.php');
                    break;
                case 'crew_management':
                    include('crew_management.php');
                    break;
                case 'overview':
                    include('overview.php');
                    break;
                case 'support':
                    include('support.php');
                    break;
                default:
                    echo "<h2>Trang không tồn tại</h2>";
                    break;
            }
        } else {
            echo "<h2>Chào mừng đến với Dashboard</h2><p>Trang này chứa các thông tin tổng quan và quản lý hệ thống của bạn.</p>";
        }
        ?>
    </div>

    <!-- Scripts của Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
