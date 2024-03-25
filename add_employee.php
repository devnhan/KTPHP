<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
</head>

<body>
    <h1>Thêm nhân viên</h1>
    <?php
    // Kiểm tra nếu form được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kết nối đến cơ sở dữ liệu
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ql_nhansu";
        $conn = new mysqli($servername, $username, $password, $database);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Lấy dữ liệu từ form
        $maNV = $_POST['maNV'];
        $tenNV = $_POST['tenNV'];
        $phai = $_POST['phai'];
        $noiSinh = $_POST['noiSinh'];
        $maPhong = $_POST['maPhong'];
        $luong = $_POST['luong'];

        // Chuẩn bị câu truy vấn SQL để thêm nhân viên mới
        $sql = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES ('$maNV', '$tenNV', '$phai', '$noiSinh', '$maPhong', '$luong')";

        // Thực thi truy vấn
        if ($conn->query($sql) === TRUE) {
            // Thêm thành công, chuyển hướng đến trang danh sách nhân viên
            header("Location: index.php");
            exit(); // Dừng kịch bản
        } else {
            // Thêm thất bại, hiển thị thông báo lỗi
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="maNV">Mã nhân viên:</label>
        <input type="text" id="maNV" name="maNV">

        <label for="tenNV">Tên nhân viên:</label>
        <input type="text" id="tenNV" name="tenNV">

        <label for="phai">Giới tính:</label>
        <input type="text" id="phai" name="phai">

        <label for="noiSinh">Nơi sinh:</label>
        <input type="text" id="noiSinh" name="noiSinh">

        <label for="maPhong">Mã phòng:</label>
        <input type="text" id="maPhong" name="maPhong">

        <label for="luong">Lương:</label>
        <input type="text" id="luong" name="luong">

        <button type="submit">Thêm nhân viên</button>
    </form>
</body>

</html>