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


$stmt0 = $conn -> prepare("SELECT EXTTIMES FROM EBOOK WHERE ISBN=$bookIsbn and CNO=$userid");
$stmt0 -> execute();
$row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);
if ($row0['EXTTIMES'] >= 2){
    echo "<script>alert('연장 가능 횟수가 초과되었습니다.'); location.href='./return_books.php';</script>";
	exit;
}

$stmt1 = $conn -> prepare("UPDATE EBOOK SET EXTTIMES=EXTTIMES+1, DATEDUE = DATEDUE+10 WHERE ISBN=$bookIsbn and CNO=$userid");
$stmt1 -> execute();
echo "<script>alert('연장되었습니다.'); location.href='./return_books.php';</script>";


?>
