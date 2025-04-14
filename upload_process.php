<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $file_url='';
    if (isset($_FILES['uploaded_file'])) {// 첨부한 파일이 있다면 이를 업로드하기
        $file_name=$_FILES['uploaded_file']['name']; // 파일 이름
        $file_tmp=$_FILES['uploaded_file']['tmp_name']; // 파일 임시 이름
        $file_error=$_FILES['uploaded_file']['error']; // 파일 업로드 오류 확인. 0이면 정상이고 그 외는 오류이다.
        $file_size=$_FILES['uploaded_file']['size']; // 파일 크기

        $upload_directory = '/var/www/html/uploads/'; // 파일이 저장되는 경로
        $file_path = $upload_directory . basename($file_name);
        if($file_error==UPLOAD_ERR_OK) { // 파일이 정상적으로 받아진 경우
            if(move_uploaded_file($file_tmp,$file_path)) {
                $file_url='/uploads/' . basename($file_name); // 파일 경로에서 앞부분은 떼고 저장하기
            }
        }
        else { // 파일 업로드 중 오류 발생
            echo "Error in uploading file.";
            die();
        }
    }
    // 파일 처리가 끝났으면 글을 데이터베이스에 등록하기
    $db_conn=mysqli_connect("127.0.0.1","clerk","clerk_password","posts"); // 데이터베이스에 연결하기
    if($db_conn==false) { // MySQL 연결 중 오류 발생
        echo "Server error. Please ask admin!";
        die();
    }
    else { // 글쓰기
        if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
            $id=mysqli_real_escape_string($db_conn,$_POST['id']);
            $title=mysqli_real_escape_string($db_conn,$_POST['title']);
            $content=mysqli_real_escape_string($db_conn,$_POST['content']);
            if($id==0) { // 새 글 쓰기
                $query="insert into post (title,content) value ({$title},{$content})";
            }
            else { // 기존 글 수정
                $query="update post set title='{$title}',content='{$content}',filename='{$file_name}' where id={$id}";
            }
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
            echo "ID / title / content is missing.";
            die();
        }
    }
}
else {
    echo "Wrong approach.";
    die();
}
?>