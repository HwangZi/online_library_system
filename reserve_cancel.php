<?php
session_start();
$tns = "
	(DESCRIPTION=
		(ADDRESS_LIST=
			(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))
		)
		(CONNECT_DATA=
			(SERVICE_NAME=XE)
		)
	)
";
$url = "oci:dbname=".$tns.";charset=utf8";
$username = 'd';
$password = '1234';

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

$bookIsbn = $_SESSION['bookIsbn'];
$userid = $_SESSION["userid"];

$stmt0 = $conn -> prepare("SELECT CNO FROM RESERVE WHERE ISBN=$bookIsbn and CNO=$userid");
$stmt0 -> execute();
$row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);
if (!isset($row0['CNO'])){
    echo "<script>alert('예약목록에 나의 예약이 없습니다'); location.href='./reserve_page.php';</script>";
	exit;
}

$stmt4 = $conn -> prepare("DELETE FROM RESERVE WHERE ISBN=$bookIsbn and CNO=$userid");
$stmt4 -> execute();

echo "<script>alert('성공적으로 예약삭제되었습니다.'); location.href='./reserve_page.php';</script>";
?>
