<?php
session_start();
$tns = "
    (DESCRIPTION=
        (ADDRESS_LIST=	(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521)))
        (CONNECT_DATA=	(SERVICE_NAME=XE))
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

$userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";
$bookIsbn = $_GET['bookIsbn'];


$stmt1 = $conn -> prepare("SELECT COUNT(CNO) BOOKCOUNT FROM EBOOK WHERE CNO=$userid");
$stmt1 -> execute();

if ($row1 = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	$bookcount = $row1['BOOKCOUNT'];
}


$stmt0 = $conn -> prepare("SELECT * FROM EBOOK WHERE ISBN=$bookIsbn");
$stmt0 -> execute();


if ($row0 = $stmt0 -> fetch(PDO::FETCH_ASSOC)) {
    $title = $row0['TITLE'];
    $publisher = $row0['PUBLISHER'];
	
	$daterented = $row0['DATERENTED'];
	
	
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <title>도서상세정보</title>
</head>
<body>
<div class="container">
    <h2 class="display-6">도서상세정보</h2>
    <table class="table table-bordered text-center">
        <tbody>
            <tr>
                <td>제목</td>
                <td><?= $title ?></td>
            </tr>
            <tr>
                <td>출판사</td>
                <td><?= $publisher ?></td>
            </tr>
            <tr>
                <td>책번호</td>
                <td><?= $bookIsbn ?></td>
            </tr>
			<tr>
                <td>나의 대출 도서수(최대 3권)</td>
				
                <td><?= $bookcount ?></td>
            </tr>
        </tbody>
    </table>
<?php

$_SESSION['bookIsbn'] = $bookIsbn;
}
?>




	<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="booklist.php" class="btn btn-success">목록</a>
        <a href="./lend_book.php?bookId=<?= $bookIsbn ?>" class="btn btn-warning">대출</a>
		<a href="./reserve_book.php?bookId=<?= $bookIsbn ?>" class="btn btn-warning">예약</a>
		<a href="./reserve_page.php?bookId=<?= $bookIsbn ?>" class="btn btn-warning">예약목록</a>
    </div>
</div>

</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</html>


