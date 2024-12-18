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