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
$username = 'd202002583';
$password = '1234';

try {
    $conn = new PDO($url, $username, $password);
} catch (PDOException $e) {
    echo("에러 내용: ".$e -> getMessage());
}

$bookIsbn = $_SESSION['bookIsbn'];
$userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";


$stmt0 = $conn -> prepare("SELECT CNO FROM EBOOK WHERE ISBN = $bookIsbn");
$stmt0 -> execute();
$row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);
if (!isset($row0['CNO'])){
    echo "<script>alert('해당 도서는 대출가능합니다. 예약이 아닌 대출을 진행하세요'); location.href='./booklist.php';</script>";
	exit;
}

$stmt2 = $conn -> prepare("SELECT COUNT(CNO) RESERVECOUNT FROM RESERVE WHERE CNO = $userid GROUP BY CNO");
$stmt2 -> execute();
$row2 = $stmt2 -> fetch(PDO::FETCH_ASSOC);
if ($row2['RESERVECOUNT'] >= 3){
    echo "<script>alert('최대 예약 횟수를 초과했습니다.'); location.href='./booklist.php';</script>";
	exit;
}

$stmt3 = $conn -> prepare("INSERT INTO RESERVE VALUES ($bookIsbn, $userid, SYSDATE)");
$stmt3 -> execute();

echo "<script>alert('성공적으로 예약되었습니다.'); location.href='./reserve_page.php';</script>";


$_SESSION['bookIsbn'] = $bookIsbn;
?>