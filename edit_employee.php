<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa nhân viên</title>
</head>

<body>
    <h1>Sửa thông tin nhân viên</h1>
    <?php
    // Kiểm tra nếu có tham số id_nhansu trên URL
    if (isset($_GET['Ma_NV'])) {
        // Lấy id_nhansu từ URL
        $id_nhansu = $_GET['Ma_NV'];

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

        // Lấy thông tin nhân viên có id_nhansu tương ứng từ cơ sở dữ liệu
        $sql = "SELECT * FROM NHANVIEN WHERE Ma_NV=$id_nhansu";
        $result = $conn->query($sql);

        // Kiểm tra truy vấn có thành công hay không
        if ($result !== false && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $maNV = $row['Ma_NV'];
            $tenNV = $row['Ten_NV'];
            $phai = $row['Phai'];
            $noiSinh = $row['Noi_Sinh'];
            $maPhong = $row['Ma_Phong'];
            $luong = $row['Luong'];
        } else {
            echo "Không tìm thấy nhân viên có mã nhân viên: $id_nhansu";
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Thiếu tham số ID nhân viên";
    }

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

        // Chuẩn bị câu truy vấn SQL để cập nhật thông tin nhân viên
        $sql = "UPDATE NHANVIEN SET Ma_NV='$maNV', Ten_NV='$tenNV', Phai='$phai', Noi_Sinh='$noiSinh', Ma_Phong='$maPhong', Luong='$luong' WHERE Ma_NV='$id_nhansu'";

        // Thực thi truy vấn
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật thông tin nhân viên thành công";
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="maNV">Mã nhân viên:</label>
        <input type="text" id="maNV" name="maNV" value="<?php echo isset($maNV) ? $maNV : ''; ?>">

        <label for="tenNV">Tên nhân viên:</label>
        <input type="text" id="tenNV" name="tenNV" value="<?php echo isset($tenNV) ? $tenNV : ''; ?>">

        <label for="phai">Giới tính:</label>
        <input type="text" id="phai" name="phai" value="<?php echo isset($phai) ? $phai : ''; ?>">

        <label for="noiSinh">Nơi sinh:</label>
        <input type="text" id="noiSinh" name="noiSinh" value="<?php echo isset($noiSinh) ? $noiSinh : ''; ?>">

        <label for="maPhong">Mã phòng:</label>
        <input type="text" id="maPhong" name="maPhong" value="<?php echo isset($maPhong) ? $maPhong : ''; ?>">

        <label for="luong">Lương:</label>
        <input type="text" id="luong" name="luong" value="<?php echo isset($luong) ? $luong : ''; ?>">

        <button type="submit">Cập nhật thông tin nhân viên</button>
    </form>
</body>

</html>