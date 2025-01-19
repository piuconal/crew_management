<?php
// Kết nối cơ sở dữ liệu
include('config.php');

// Lấy dữ liệu từ bảng users
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

// Kiểm tra có dữ liệu không
if (mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = [];
}

// Kiểm tra khi nhấn "Kích hoạt" một người dùng
if (isset($_POST['approve_id'])) {
    $user_id = intval($_POST['approve_id']); // Lọc và bảo vệ tham số ID

    // Cập nhật trạng thái người dùng thành "active"
    $update_sql = "UPDATE users SET status = 'active' WHERE id = $user_id";
    
    if (mysqli_query($conn, $update_sql)) {
        // Sau khi cập nhật, chỉ cần reload lại trang mà không cần redirect
        echo "<script>window.location.href = window.location.href;</script>"; // Tự reload lại trang hiện tại
    } else {
        echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
    }
}

// Kiểm tra khi nhấn "Khóa" một người dùng
if (isset($_POST['lock_id'])) {
    $user_id = intval($_POST['lock_id']); // Lọc và bảo vệ tham số ID

    // Cập nhật trạng thái người dùng thành "inactive"
    $update_sql = "UPDATE users SET status = 'inactive' WHERE id = $user_id";
    
    if (mysqli_query($conn, $update_sql)) {
        // Sau khi cập nhật, chỉ cần reload lại trang mà không cần redirect
        echo "<script>window.location.href = window.location.href;</script>"; // Tự reload lại trang hiện tại
    } else {
        echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="css/employee_management.css">
</head>

<body>
    <div>
        <h2>Quản lý nhân viên</h2>

        <!-- Bảng hiển thị thông tin người dùng với khả năng cuộn ngang -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <!-- <th>Địa chỉ</th> -->
                        <!-- <th>Ngày sinh</th> -->
                        <th>Giới tính</th>
                        <th>Ảnh đại diện</th>
                        <th class="status">Trạng thái</th> <!-- Cột trạng thái -->
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)) : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                                <!-- <td><?php echo htmlspecialchars($user['address']); ?></td> -->
                                <!-- <td><?php echo htmlspecialchars($user['date_of_birth']); ?></td> -->
                                <td><?php echo htmlspecialchars($user['gender']); ?></td>
                                <td>
                                    <?php if ($user['profile_picture']) : ?>
                                        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Avatar" width="80" height="80">
                                    <?php else : ?>
                                        <img src="assets/images/default-avatar.png" alt="Default Avatar" width="80" height="80">
                                    <?php endif; ?>
                                </td>
                                <td class="status">
                                    <?php
                                    // Hiển thị trạng thái và nút "Kích hoạt" nếu trạng thái là inactive
                                    if ($user['status'] == 'inactive') {
                                        ?>
                                        <form action="admin.php?page=employee_management" method="POST" style="display:inline;">
                                            <input type="hidden" name="approve_id" value="<?php echo $user['id']; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm ml-2">Kích hoạt</button>
                                        </form>
                                        <?php
                                    } else {
                                        echo '<span class="badge badge-success">Hoạt động</span>';
                                        ?>
                                        <!-- Hiển thị nút "Khóa" nếu role là "nhanvien" -->
                                        <?php if ($user['role'] == 'nhanvien') : ?>
                                            <form action="admin.php?page=employee_management" method="POST" style="display:inline;">
                                                <input type="hidden" name="lock_id" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm ml-2">Khóa</button>
                                            </form>
                                        <?php endif; ?>
                                        <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($user['role'] !== 'admin') : ?>
                                        <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Chỉnh sửa</a>
                                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa người dùng này không?');">Xóa</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="9" class="text-center">Không có nhân viên nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts của Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
