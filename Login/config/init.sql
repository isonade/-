create database email_db;

grant all on email_db.* to dbuser@localhost identified by '7654321';

use email_db

create table users(
  id int not null auto_increment primary key,
  email varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
   );

desc users;
