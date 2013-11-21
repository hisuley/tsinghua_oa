
#User Table#

CREATE TABLE  user (id int primary key auto_increment, username varchar(255) not null, password char(255) not null, role char(20) not null, email varchar(255) not null, create_time int not null);

#Project Table#

CREATE TABLE project (id int primary key auto_increment, name varchar(255) not null, cat tinyint(2) not null, sn varchar(100) not null, user_id int not null, sign_date int not null, location char(255) not null, total_price decimal(10,2) not null, real_contract_price decimal(10,2), payment_times tinyint(2), first_pay decimal(10,2), second_pay decimal(10,2), third_pay decimal(10,2), fourth_pay decimal(10,2), fifth_pay decimal(10,2), sixth_pay decimal(10,2), seventh_pay decimal(10,2), create_time int);

#Project User Table#
CREATE TABLE  project_user (id int primary key auto_increment, user_id int not null, project_id int not null, role char(20), create_time int not null);

#Manhour Table#
CREATE TABLE manhour (id int primary key auto_increment, user_id int not null, type char(10) not null, start_time int, end_time int, reviewer_id int, status tinyint(2), notes char(255), create_time int);

#Asset Table#
CREATE TABLE asset (id int primary key auto_increment, user_id int not null, name varchar(255) not null, amount smallint(5) not null, sn char(30) not null, price decimal(10,2), create_time int);

#Asset Borrow#
CREATE TABLE asset_borrow (id int primary key auto_increment, user_id int not null, start_time int, end_time int, status char(10), create_time int);

#Reimbursement#
CREATE TABLE reimbursement (id int primary key auto_increment, user_id int not null, username char(255) , item varchar(255), name varchar(255) not null, price decimal(10,2), type varchar(255) not null, content text not null, create_time int);

CREATE TABLE reimbursement_item (id int primary key auto_increment, reimbursement_id int not null, name varchar(255) not null, total_price decimal(10,2), single_price decimal(10,2), amount smallint(5), notes char(255) not null, create_time int);

#Notify#
CREATE TABLE notify (id int primary key auto_increment, user_id int not null, title varchar(255), content text, route text, from_user int, is_read tinyint(1) not null, create_time int);

#Exercise#
CREATE TABLE exercise (id int primary key auto_increment, user_id int not null, start_time int, end_time int, content char(255), reviewer_id int, status char(20), create_time int);

#Leave#
CREATE TABLE leaves (id int primary key AUTO_INCREMENT, user_id int not null, type char(20), start_time int, end_time int, notes char(255), create_time int);


