<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","posts"); // 데이터베이스에 연결하기
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        echo "Server error. Please ask admin!";
        die();
    }
    else { // 삭제하기
        if(isset($_POST['id'])) {
            $id=mysqli_real_escape_string($db_conn,$_POST['id']);
            $query="delete from post where id='{$id}'";
            $result=mysqli_query($db_conn,$query); // 쿼리 실행하기
            if($result==false) {// 쿼리 실행 중 오류 발생
                echo "Server error. Please ask admin!";
                die();
            }
            mysqli_close($db_conn);
            header("Location: search.php");
            die();
        }
        else {// 빠진 데이터가 있는 경우
            echo "ID is missing.";
            die();
        }
    }
}
else {
    echo "Wrong approach.";
    die();
}
?>