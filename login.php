<?php
    $id=$_GET['id']; // 아이디
    $pw=$_GET['pw']; // 비밀번호

    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","login");
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        echo mysqli_connect_error();
    }
    else {
        $query="select * from user where id='{$id}' and pw='{$pw}'";
        $result=mysqli_query($db_conn,$query);
        
        if($result==false) {
            echo mysqli_error($db_conn);
        }
        else {
            $row=mysqli_fetch_array($result);
            if($row) {
                echo "Hello {$row['id']}";
            }
            else {
                echo "login failed";
            }
        }
        mysqli_close($db_conn)
    }
    
?>