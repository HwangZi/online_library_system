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
$userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";


$stmt0 = $conn -> prepare("SELECT CNO FROM EBOOK WHERE ISBN=$bookIsbn");
$stmt0 -> execute();
$row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC);

if (isset($row0['CNO'])){
	echo "<script>alert('[대출불가]이미 대출중인 도서입니다.');history.back();</script>";
	exit;
}

$stmt1 = $conn -> prepare("SELECT COUNT(CNO) BOOKCOUNT FROM EBOOK WHERE CNO=$userid");
$stmt1 -> execute();
$row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC);
if ($row1['BOOKCOUNT'] >= 3) {
	echo "<script>alert('[대출불가]현재 최대 대출권수입니다. 도서 반납 후 진행해주세요.');history.back();</script>";
	exit;
}

$stmt2 = $conn -> prepare("UPDATE EBOOK SET CNO=$userid, EXTTIMES=0, DATERENTED=SYSDATE, DATEDUE=(SYSDATE+10) WHERE ISBN=$bookIsbn");
$stmt2 -> execute();


echo "<script>alert('성공적으로 대출되었습니다.'); location.href='./booklist.php';</script>";
?>


