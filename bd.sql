insert into user(nom,pernom,email,password,telephone,adresse,id_role)
values("chef","mouha","mouha@gmail.com","1111","0626917903","zohour",1);
update user
set id_role=2
where id_user=3;

delete user
where id_user=1 or id_user=2; 