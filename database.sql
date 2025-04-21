create database login;
use login;
create table user(id varchar(20), pw varchar(50));
insert into user(id,pw) values('admin','admin');

create database posts;
use posts;
create table post(id INT AUTO_INCREMENT PRIMARY KEY, title varchar(40),content varchar(140),filename varchar(100),filepath varchar(100));

create user 'clerk'@'localhost' identified by 'clerk_password';
grant all privileges on login.* to 'clerk'@'localhost';
grant all privileges on posts.* to 'clerk'@'localhost';
