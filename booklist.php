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
$searchWord_title = $_GET['searchWord_title'] ?? '';
$searchWord_publisher = $_GET['searchWord_publisher'] ?? '';
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
    <title>도서목록</title>
</head>
<body>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="main.php" class="btn btn-success">메인으로</a>
</div>

<div class="container">
    <h2 class="text-center">도서목록</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>책번호</th>
                <th>제목</th>
                <th>출판사</th>
            </tr>
        </thead>
        <tbody>
		
<?php
$stmt = $conn -> prepare("SELECT ISBN, TITLE, PUBLISHER FROM EBOOK ORDER BY ISBN");
$stmt -> execute();

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
				<td>
                    <?= $row['ISBN'] ?>
                </td>
                <td>
					<a href="bookview.php?bookIsbn=<?= $row['ISBN'] ?>"><?= $row['TITLE'] ?></a>
                </td>
                <td>
                    <?= $row['PUBLISHER'] ?>
                </td>
                
            </tr>
<?php
}
?>
        </tbody>
    </table>
		
<p>		
<div class="container">
    <h2 class="text-center">도서명 검색결과</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>책번호</th>
                <th>제목</th>
                <th>출판사</th>
            </tr>
        </thead>
        <tbody>	
</p>		

	
<?php
if($searchWord_title != null){
$stmt = $conn -> prepare("SELECT ISBN, TITLE, PUBLISHER FROM EBOOK WHERE LOWER(TITLE) LIKE '%' || :searchWord_title || '%' ORDER BY ISBN");
$stmt -> execute(array($searchWord_title));

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
				<td>
                    <?= $row['ISBN'] ?>
                </td>
                <td>
					<a href="bookview.php?bookIsbn=<?= $row['ISBN'] ?>"><?= $row['TITLE'] ?></a>
                </td>
                <td>
                    <?= $row['PUBLISHER'] ?>
                </td>
                
            </tr>
<?php
}
?>
        </tbody>
    </table>
<?php
}
?>


<p>
<div class="container">
    <h2 class="text-center">출판사명 검색결과</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>책번호</th>
                <th>제목</th>
                <th>출판사</th>
            </tr>
        </thead>
        <tbody>
</p>

<?php
if($searchWord_publisher != null){
	
$stmt = $conn -> prepare("SELECT ISBN, TITLE, PUBLISHER FROM EBOOK WHERE LOWER(PUBLISHER) LIKE '%' || :searchWord_publisher || '%' ORDER BY ISBN");
$stmt -> execute(array($searchWord_publisher));

while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
?>
            <tr>
				<td>
                    <?= $row['ISBN'] ?>
                </td>
                <td>
					<a href="bookview.php?bookIsbn=<?= $row['ISBN'] ?>"><?= $row['TITLE'] ?></a>
                </td>
                <td>
                    <?= $row['PUBLISHER'] ?>
                </td>
                
            </tr>
<?php
}
?>
        </tbody>
    </table>
<?php
}
?>
	
	
<div>
<h4>도서명으로 검색</h4>
<form class="row">
        <div class="col-10">
            <label for="searchWord_title" class="visually-hidden">Search Word</label>
            <input type="text" class="form-control" id="searchWord_title" name="searchWord_title" placeholder="검색어 입력" value="<?= $searchWord_title ?>">
        </div>
        <div class="col-auto text-end">
            <button type="submit" class="btn btn-primary mb-3">검색</button>
        </div>
</form>
</div>

<div>
<h4>출판사로 검색</h4>
<form class="row">
        <div class="col-10">
            <label for="searchWord_publisher" class="visually-hidden">Search Word</label>
            <input type="text" class="form-control" id="searchWord_publisher" name="searchWord_publisher" placeholder="검색어 입력" value="<?= $searchWord_publisher ?>">
        </div>
        <div class="col-auto text-end">
            <button type="submit" class="btn btn-primary mb-3">검색</button>
        </div>
</form>
</div>

</div>


</body>
</html>