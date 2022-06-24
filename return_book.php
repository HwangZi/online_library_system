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

$bookIsbn = $_GET['bookIsbn'];
$userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";


$stmt0 = $conn -> prepare("SELECT * FROM EBOOK WHERE ISBN=$bookIsbn and CNO=$userid");
$stmt0 -> execute();
$row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);

$stmt1 = $conn -> prepare("UPDATE EBOOK SET CNO = '', EXTTIMES = '', DATERENTED = '', DATEDUE = '' WHERE ISBN=$bookIsbn AND CNO=$userid");
$stmt1 -> execute();

$stmt2 = $conn -> prepare("UPDATE PREVIOUSRENTAL SET DATERETURNED=SYSDATE WHERE ISBN=$bookIsbn AND CNO=$userid");
$stmt2 -> execute();

/* 대기자 순번별로 이메일 전송 위한 sql문(실제 이메일 전송은 구현x) 
$stmt3 = $conn -> prepare("SELECT * FROM (SELECT * FROM RESERVE WHERE ISBN=$bookIsbn ORDER BY DATETIME ASC) WHERE ROWNUM = 1");
*/


echo "<script>alert('반납되었습니다.'); location.href='./return_books.php';</script>";

?>
