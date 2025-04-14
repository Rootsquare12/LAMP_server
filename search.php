<?php
$error_message="";
$result=false;
if($_SERVER["REQUEST_METHOD"] == "GET") {
    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","posts"); // 데이터베이스에 연결하기
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        $error_message="Server error. Please ask admin!";
        $result=false; // 검색 결과에는 빈 값을 할당한다.
    }
    else { // 글 검색하기
        if(isset($_GET['title'])) { 
            $text=$_GET['title']; // 제목 검색
            $text=mysqli_real_escape_string($db_conn, $text); // 여기서는 사용자 입력을 이스케이프 처리(문자 본래의 기능을 무시하고 다른 기능을 하게 함) 한다.
            $query="select * from post where title like '%{$text}%'"; // 사용자 입력을 쿼리에 넣는다.
        }
        else {// 쿼리스트링이 없을 경우 모든 글을 검색한다.
            $query="select * from post";
        }
        $result=mysqli_query($db_conn,$query); // 쿼리 실행하기
        if($result==false) {// 쿼리 실행 중 오류 발생
            $error_message="Server error. Please ask admin!";
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
    <h1>Search page</h1>
    <form method="GET" action="search.php">
      <input type="text" name="title" placeholder="Enter title..." /><br />
      <input type="submit" />
    </form>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
        </tr>
      </thead>
      <tbody>
        <?php
            while ($row=mysqli_fetch_array($result)) { // 결과 행을 하나씩 가져온다.
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>"; // 글번호
                echo "<td><a href='view_post.php?id={$row['id']}'>{$row['title']}</a></td>"; // 글제목. 클릭하면 이동한다.
                echo "</tr>";
            }
        ?>
      </tbody>
    </table>
    <p><?php echo $error_message; ?></p>
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
  </body>
</html>
