<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0"
		crossorigin="anonymous">
    <style>
        a {
            text-decoration: none;
        }
    </style>
    <title>도서예약</title>
</head>
<body>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="main.php" class="btn btn-success">메인으로</a>
</div>

<div class="container">
    <h2 class="text-center">해당도서 예약목록</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>책번호</th>
                <th>제목</th>
                <th>예약자</th>
				<th>예약일시</th>
            </tr>
        </thead>
        <tbody>
		
		
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


$stmt4 = $conn -> prepare("SELECT R.ISBN ISBN, E.TITLE TITLE, R.CNO CNO, R.DATETIME DATETIME FROM EBOOK E, RESERVE R WHERE E.ISBN = R.ISBN AND R.ISBN = $bookIsbn ORDER BY DATETIME");
$stmt4 -> execute();

while ($row4 = $stmt4 -> fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
				<td>
                    <?= $row4['ISBN'] ?>
                </td>
                <td>
					<?= $row4['TITLE'] ?>
                </td>
                <td>
                    <?= $row4['CNO'] ?>
                </td>
				<td>
                    <?= $row4['DATETIME'] ?>
                </td>
                
            </tr>
			
			
			<a href="./reserve_cancel.php?bookId=<?= $bookIsbn ?>" class="btn btn-warning">나의 예약 취소</a>
			
<?php
$_SESSION['bookIsbn'] = $bookIsbn;
}
?>