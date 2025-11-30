<?php
// ====== KẾT NỐI CSDL BẰNG PDO ======
$host = '127.0.0.1';
$dbname = 'cse485_web';        // đổi nếu tên CSDL khác
$username = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// ====== XỬ LÝ THÊM SINH VIÊN ======
if (!empty($_POST['ten_sinh_vien']) && !empty($_POST['email'])) {

    $ten = $_POST['ten_sinh_vien'];
    $email = $_POST['email'];

    $sql = "INSERT INTO sinhvien (ten_sinh_vien, email) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ten, $email]);

    // Load lại trang để tránh lỗi submit lại
    header("Location: chapter4.php");
    exit;
}

// ====== LẤY DANH SÁCH SINH VIÊN ======
$sql_select = "SELECT * FROM sinhvien ORDER BY id DESC";
$stmt_select = $pdo->query($sql_select);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sinh viên</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h2>Thêm sinh viên</h2>
<form method="POST">
    <input type="text" name="ten_sinh_vien" placeholder="Tên sinh viên" required>
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Thêm</button>
</form>

<h2>Danh sách sinh viên</h2>
<table>
<tr>
    <th>ID</th>
    <th>Tên Sinh Viên</th>
    <th>Email</th>
    <th>Ngày Tạo</th>
</tr>

<?php while ($row = $stmt_select->fetch(PDO::FETCH_ASSOC)) : ?>
<tr>
    <td><?= htmlspecialchars($row['id']) ?></td>
    <td><?= htmlspecialchars($row['ten_sinh_vien']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['ngay_tao']) ?></td>
</tr>
<?php endwhile; ?>

</table>

</body>
</html>
