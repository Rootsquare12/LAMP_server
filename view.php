<?php
session_start(); // 세션 시작하기
if (!isset($_SESSION['user_id'])) {
    // 로그인한 사용자가 아니면 로그인 창으로 이동한다.
    header("Location: login.php");
    die(); // 이 스크립트 이후의 것은 무시하고 즉시 종료하기
}
if($_SERVER["REQUEST_METHOD"] == "GET") {
    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","posts"); // 데이터베이스에 연결하기
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        echo "Server error. Please ask admin!";
        die();
    }
    else { // 글 검색하기
        if(isset($_GET['id'])) { 
            $id=$_GET['id']; // 읽을 글의 아이디를 검색한다.
            $id=mysqli_real_escape_string($db_conn, $id); // 이스케이프 처리하기
            $query="select * from post where id='{$id}'"; // 사용자 입력을 쿼리에 넣는다.
        }
        else {// id 쿼리스트링이 없다면 오류 발생
            echo "ID query not given.";
            die();
        }
        $result=mysqli_query($db_conn,$query); // 쿼리 실행하기
        if($result==false) {// 쿼리 실행 중 오류 발생
            echo "Server error. Please ask admin!";
            die();
        }
        $row=mysqli_fetch_array($result);
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
    <h1><?php echo $row['title']; ?></h1>
    <p><?php echo $row['content']; ?></p>
    <h3>Attached files</h3>
    <?php 
    if($row['filename']) {
        $filename=$row['filename'];
        $relative_path='/uploads/'.$filename;
        echo "<a href='".$relative_path."' download='".$filename."'>".$filename."</a>";
    }
    else {
        echo "none";
    }
    ?>
    <form action="edit.php" method="GET">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
        <button type="submit">Edit</button>
    </form>
    <?php // 관리자 한정 글을 지울 수 있다.
    if($_SESSION['user_id']=='admin') {
        echo "<form action='delete_process.php' method='POST'>";
        echo "  <button type='submit'>Delete</button>";
        echo "</form>";
    }
    ?>
  </body>
</html>
