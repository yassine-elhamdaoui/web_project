CREATE DATABASE hotel;
USE hotel;
create table rooms(
	  id_room int primary key auto_increment,
    room_type varchar(20) check(room_type in ('single','double')),
    max_adults int,
    max_children int
);
-- Inserting 30 rows into the rooms table
INSERT INTO rooms (room_type, max_adults, max_children)
VALUES ('single', 1, 0),
       ('single', 1, 1),
       ('double', 2, 1),
       ('single', 1, 0),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('single', 1, 0),
       ('single', 1, 0),
       ('single', 1, 0),
       ('single', 1, 0),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('single', 1, 0),
       ('single', 1, 0),
       ('single', 1, 0),
       ('single', 1, 0),
       ('double', 2, 1),
       ('double', 2, 1),
       ('double', 2, 1),
       ('single', 1, 2),
       ('double', 2, 1),
       ('single', 1, 1);

create table reserved_rooms (
	  id_room int ,
    room_reserved_date_in date,
    room_reserved_date_out date,
    uqcode int,
    foreign key (id_room) references rooms(id_room)
);
CREATE TABLE reservation (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(255) NOT NULL,
  client_email VARCHAR(255) NOT NULL,
  room_type VARCHAR(10) NOT NULL,
  phone_number int NOT NULL,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  num_of_adults INT NOT NULL,
  num_of_children INT NOT NULL,
  room_id int,
  uqcode int,
  cin varchar(20)
);
CREATE TABLE cancelled_reservations (
  id INT NOT NULL,
  client_name VARCHAR(255) NOT NULL,
  client_email VARCHAR(255) NOT NULL,
  room_type VARCHAR(10) NOT NULL,
  phone_number int NOT NULL,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  num_of_adults INT NOT NULL,
  num_of_children INT NOT NULL,
  room_id int,
  uqcode int,
  cin varchar(20)
);

CREATE TABLE admins (
  id INT(11) primary key auto_increment,
  admin_name VARCHAR(30),
  admin_password VARCHAR(30)
);

INSERT INTO admins(admin_name,admin_password) VALUES('yassine','slim_shady'),
                                                    ('rahma','slim_shady'),
                                                    ('ayoub','slim_shady');
select * from rooms;
select * from reservation;
select * from reserved_rooms;

-- drop table rooms;
-- drop table reserved_rooms;
-- truncate reservation;
-- truncate reserved_rooms;


