insert into user(nom,pernom,email,password,telephone,adresse,id_role)
values("chef","mouha","mouha@gmail.com","1111","0626917903","zohour",2);

update user
set id_role=2
where id_user=3;

delete user
where id_user=1 or id_user=2; 

ALTER table menu
add image varchar(255) NOT NULL;

create table menu_palt(
   id_menu int(11),
   id_plat int(11),
   FOREIGN KEY (id_menu) REFERENCES  MENU(id_menu),
   FOREIGN KEY (id_plat) REFERENCES  plate(id_plat)
);

Alter table plate
DROP COLUMN id_menu

Alter table menu_palt
ADD constraint primary key(id_menu,id_plat);

alter table plate
add COLUMN nomPlat varchar(55);


select * from user where id_user in (select id_user from reservation where status='en attente');


SELECT DISTINCT u.* 
FROM user u
INNER JOIN reservation r ON u.id_user = r.id_user
WHERE r.status = 'en attente';

update  reservation
set status="acceptee"
where id_menu=1 and id_user1;

SELECT * 
FROM reservation
WHERE dateReservation >= CURDATE()
ORDER BY dateReservation ASC;


SELECT  u.* , r.* 
FROM user u
INNER JOIN reservation r ON u.id_user = r.id_user
WHERE r.status = 'accepter ' AND r. dateReservation >= CURDATE() ORDER BY dateReservation ASC; 

select *
from reservation
where id_user=35;

SELECT r.* ,m.titre from reservation r INNER JOIN menu m ON r.id_menu=m.id_menu WHERE id_user=35;

delete from reservation where id_menu=1 and id_user=35;
