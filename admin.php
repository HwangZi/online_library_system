<?php
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

?>

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
  <title>Library</title>
</head>
<body>

<div class="container">
    <h2 class="text-center">관리자계정(대출기록조회)</h2>
	<p>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>도서번호</th>
				<th>도서명</th>
                <th>대출일</th>
                <th>반납일</th>
				<th>대출자</th>
            </tr>
        </thead>
        <tbody>
<?php
$searchWord = '';
$stmt = $conn -> prepare("SELECT E.TITLE TITLE, P.ISBN ISBN, P.DATERENTED DATERENTED, P.DATERETURNED DATERETURNED, P.CNO CNO FROM PREVIOUSRENTAL P, EBOOK E WHERE P.ISBN = E.ISBN");
$stmt -> execute();

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
                <td>
                    <?= $row['ISBN'] ?>
                </td>
				<td>
                    <?= $row['TITLE'] ?>
                </td>
                <td>
                    <?= $row['DATERENTED'] ?>
                </td>
                <td>
                    <?= $row['DATERETURNED'] ?>
                </td>
				<td>
					<?= $row['CNO'] ?>
				</td>
            </tr>
			
			
<?php
}
?>

        </tbody>
    </table>
	</p>
	<p>
	<div class="d-grid gap-2 d-md-flex justify-content-md-end">
		<a href="main.php" class="btn btn-success">목록</a>
	</div>
</p>
</body>
</html>




