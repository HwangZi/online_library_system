<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>Login</title>
</head>
<body>
	<div id="login_box">
		<h1>로그인</h1>							
			<form action="./login_ok.php" method="post" >
        			<table align="center" border="0" cellspacing="0" width="300">
        			<tr>
            			<td width="150" colspan="1"> 
							<input type="text" name="userid" class="inph" placeholder="enter your student number">
						</td>
						<td rowspan="2" align="center" width="100" > 
							<button type="submit" id="btn" >로그인</button>
						</td>
					</tr>
					<tr>
						<td width="150" colspan="1"> 
						<input type="password" name="userpw" class="inph" placeholder="enter your pw">
						</td>
					</tr>
					
				</table>
					
			</form>
	</div>
</body>
</html>