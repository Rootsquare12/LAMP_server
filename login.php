<?php
session_start(); // 세션 시작하기
$login_message=""; // 로그인 오류 메시지
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id=$_GET['id']; // 아이디
    $pw=$_GET['pw']; // 비밀번호

    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","login"); // 데이터베이스에 연결하기
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        $login_message="Server error. Please ask admin!";
    }
    else { // 로그인 과정
        $query="select * from user where id='{$id}' and pw='{$pw}'"; // 사용자 입력을 쿼리에 넣는다.
        $result=mysqli_query($db_conn,$query); // 쿼리 실행하기
        
        if($result==false) {// 쿼리 실행 중 오류 발생
            $login_message="Server error. Please ask admin!";
        }
        else {// 쿼리가 실행되었으면 결과 확인하기
            $row=mysqli_fetch_array($result);
            if($row) { // 로그인 성공
                $login_message="Hello {$row['id']}.";
                $_SESSION['user_id'] = $row['id']; // 현재 로그인한 사람의 아이디를 세션에 저장한다.
            }// 로그인한 사용자는 자신의 아이디가 담긴 세션을 얻는다.
            else { // 로그인 실패
                $login_message="Invalid user ID or password."
            }
        }
        mysqli_close($db_conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
  </head>
  <body>
    <h1>Login page</h1>
    <form method="GET" action="login.php">
      <input type="text" name="id" placeholder="ID" /><br />
      <input type="password" name="pw" placeholder="password" /><br />
      <input type="submit" />
    </form>
    <p><?php echo $login_message; ?></p>
  </body>
</html>
