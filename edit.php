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
  else { // 서버에서 글 검색하기
    if(isset($_GET['id'])) { // 이미 있는 글을 수정하는 경우
        $id=$_GET['id']; // 수정할 글의 아이디를 검색한다.
        $id=mysqli_real_escape_string($db_conn, $id); // 이스케이프 처리하기
        $query="select * from post where id='{$id}'"; // 사용자 입력을 쿼리에 넣는다.
        $result=mysqli_query($db_conn,$query); // 쿼리 실행하기
        if($result==false) {// 쿼리 실행 중 오류 발생
            echo "Server error. Please ask admin!";
            die();
        }
        else {// 이미 있는 글의 정보 가져오기
            $row=mysqli_fetch_array($result);
            if($row) {
                $title=$row['title'];
                $content=$row['content'];
                $id=$row['id'];
            }
            else { // 존재하지 않는 글 번호 입력시 오류 발생
                echo "Post not found.";
                die();
            }
        }
        mysqli_close($db_conn);
    }
    else {// id 쿼리스트링이 없다면 새 글을 쓴다.
        $title='';
        $content='';
        $id=0; // 0은 새 글을 뜻하는 번호.
    }
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
    <form
      action="upload_process.php"
      method="post"
      enctype="multipart/form-data"
    >
      <input type="text" name="title" placeholder="Input title" value="<?php echo $title; ?>" required />
      <textarea
        name="content"
        placeholder="Input content"
        rows="10"
        cols="200" 
        required
      ><?php echo $content; ?></textarea>
      <input type="file" name="uploaded_file" />
      <input type="hidden" name="id" value="<?php echo $id; ?>"/>
      <input type="submit" value="Upload" />
    </form>
    <div><?php echo $content; ?></div>
  </body>
</html>
