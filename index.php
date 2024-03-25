<?php
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

// Số nhân viên trên mỗi trang
$employeesPerPage = 5;

// Lấy trang hiện tại
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// Tính toán vị trí bắt đầu của các nhân viên trên trang hiện tại
$start = ($page - 1) * $employeesPerPage;

// Lấy danh sách nhân viên từ cơ sở dữ liệu
$sql = "SELECT * FROM NHANVIEN LIMIT $start, $employeesPerPage";
$result = $conn->query($sql);



// Kiểm tra kết quả truy vấn
if ($result === false) {
    die("Error: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <style>
        .employee img {
            width: 100px;

            height: 100px;

            object-fit: cover;

            border-radius: 50%;

        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Danh sách nhân viên</h1>
        <div class="add-employee">
            <a href="add_employee.php" class="btn">Thêm nhân viên</a>
        </div>
        <div class="employees">
            <?php
            // Hiển thị danh sách nhân viên
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $gender = $row['Phai'];
                    // Đường dẫn hình ảnh tùy thuộc vào giới tính
                    if ($gender == 'NU') {
                        $image = "image/woman.jpg";
                    } else {
                        $image = "image/man.jpg";
                    }
                    echo "<div class='employee'>";
                    echo "<img src='$image' alt='$gender'>";
                    echo "<p><strong>Mã nhân viên:</strong> " . $row['Ma_NV'] . "</p>";
                    echo "<p><strong>Tên nhân viên:</strong> " . $row['Ten_NV'] . "</p>";
                    echo "<p><strong>Giới tính:</strong> " . $gender . "</p>";
                    echo "<p><strong>Nơi sinh:</strong> " . $row['Noi_Sinh'] . "</p>";
                    echo "<p><strong>Mã phòng:</strong> " . $row['Ma_Phong'] . "</p>";
                    echo "<p><strong>Lương:</strong> " . $row['Luong'] . "</p>";
                    echo "<a href='edit_employee.php?id_nhansu=" . $row['Ma_NV'] . "' class='btn'>Sửa</a>";
                    echo "<button class='btn'>Xóa</button>";
                    echo "</div>";
                }
            } else {
                echo "Không có nhân viên nào.";
            }
            ?>
        </div>

        <div class="pagination">
            <?php
            // Hiển thị phân trang
            $sql = "SELECT COUNT(*) AS total FROM NHANVIEN";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalEmployees = $row['total'];
            $totalPages = ceil($totalEmployees / $employeesPerPage);
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='index.php?page=$i'>$i</a>";
            }
            ?>
        </div>
    </div>
    <script>
        document.querySelector('.add-employee a').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = this.getAttribute('href');
        });
    </script>
</body>

</html>

<?php
// Đóng kết nối
$conn->close();
?>