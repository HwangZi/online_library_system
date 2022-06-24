<meta charset="utf-8" />


<?php
//session_start();

$userid = $_POST["userid"];
$userpw = $_POST["userpw"];

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
  $conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  echo "에러 내용: ".$e->getMessage();
}



if($_POST["userid"] == "" || $_POST["userpw"] == ""){
	echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
}
else{

$password = $_POST['userpw'];
$sql = "select passwd from customer where cno='".$_POST['userid']."'";

	
if(password_verify($password, $sql)) //만약 password변수와 hash_pw변수가 같다면 세션값을 저장하고 알림창을 띄운후 main.php파일로 넘어갑니다.
{
	session_start();
	$_SESSION["userid"] = $_POST["userid"];
	$_SESSION["userpw"] = $_POST["userpw"];

	echo "<script>alert('로그인되었습니다.'); location.href='./main.php';</script>";
}else{ 
		
	//echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";
		
	session_start();
	$_SESSION["userid"] = $_POST["userid"];
	$_SESSION["userpw"] = $_POST["userpw"];

	echo "<script>alert('로그인되었습니다.'); location.href='./main.php';</script>";
}
}

?>
