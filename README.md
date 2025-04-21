# LAMP_server

LAMP server for studying web hacking.

## EC2 인스턴스에 웹앱을 올리는 법

다음 명령어들을 순차적으로 실행한다.

```
sudo apt update
sudo apt upgrade
sudo apt install apache2 php mysql-server
sudo apt install libapache2-mod-php php-mysql
```

실행하고 EC2 인스턴스의 아이피 주소로 접속하면 Apache2 기본 페이지가 나온다. 이후 다음 명령어를들을 순차적으로 실행한다.

```
git clone https://github.com/Rootsquare12/LAMP_server.git
cd LAMP_server
sudo cp * /var/www/html
cd /var/www/html
sudo mkdir uploads
sudo chmod 777 uploads
```

실행하면 웹앱이 정상적으로 업로드 되고, 파일 업로드까지 잘 받을 수 있게 된다.

## mysql 설정 방법

EC2 인스턴스에서 root 권한으로 MySQL에 접속한 후, database.sql 파일의 쿼리들을 순차적으로 실행한다. 기본 서비스에 필요한 데이터베이스 스키마 및 테이블들이 자동으로 만들어진다. 실제 웹 서비스에서는 루트 권한이 아니라 clerk 유저의 권한으로 데이터베이스 테이블에 접속한다.
