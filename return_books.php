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
    <title>도서반납(대출정보조회)</title>
</head>
<body>
	
<p>		
<div class="container">
    <h2 class="text-center">나의 대출정보조회</h2>
	<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="main.php" class="btn btn-success">메인으로</a>
	</div>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>책번호</th>
                <th>제목</th>
                <th>대출일</th>
		<th>반납기한일</th>
		<th>연장횟수</th>
		<th>연장</th>
		<th>반납</th>
            </tr>
        </thead>
<tbody>	
</p>		

	
<?php
$userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";

$stmt = $conn -> prepare("SELECT * FROM EBOOK WHERE CNO = $userid");
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
                	<?= $row['DATEDUE'] ?>
                </td>
		<td>
                	<?= $row['EXTTIMES'] ?>
                </td>
		<td>
                	<a href="extend_book.php?bookIsbn=<?= $row['ISBN'] ?>">연장</a>
                </td>
		<td>
                	<a href="return_book.php?bookIsbn=<?= $row['ISBN'] ?>">반납</a>
                </td>
		
            </tr>
<?php
}
?>
        </tbody>
    </table>
	
</body>
