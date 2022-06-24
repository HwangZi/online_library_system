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
$username = 'd';
$password = '1234';
$searchWord = $_GET['searchWord'] ?? '';
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
  <meta name="viewport" content="width=device-width">
  <title>Library</title>
</head>

<body>
  <header><h1>Library System</h1></header>
		
	<?php
    session_start();
    $userid = isset($_SESSION["userid"])? $_SESSION["userid"]:"";
	?>
		
		
	<?php if(!$userid){/* 로그인 전  */ ?>
    <p>
        <a href="./login.php" class="bar">로그인</a>
    </p>
	
    <?php } else{ /* 로그인 후 */ ?>
    <p>"<?php echo $userid; ?>"님, 안녕하세요.</p>
    <p>
        <?php if($userid == "000"){ ?>
        <a href="./admin.php" class="bar">관리자권한(대출기록 조회)</a>
        <?php }; ?>
        <a href="./logout.php" class="bar">로그아웃</a>
    </p>
	<?php }; ?>	
	


  
  <section>
    <nav>
      <ul>
		<p>
        <li><a href="booklist.php">도서검색(예약 및 대출 포함)</a></li>
		</p>
		<p>
        <li><a href="return_books.php">도서반납(대출정보조회) 및 연장</a></li>
		</p>
      </ul>
    </nav>
  </section>
  
</body>
</html>
