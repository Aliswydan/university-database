use univdb
go
sp_addlogin 'zeinab Saghir', 'CS1234', 'univdb', 'us_english'

select name from master..syslogins
go


use univdb
go
sp_addrole 'Univ_Managers'
go

sp_adduser 'zeinab Saghir', 'mark_manag', 'Univ_Managers'
go

grant select, insert, update, delete on Course to Univ_Managers
grant select, insert, update, delete on Student to Univ_Managers
grant select, insert, update, delete on Teacher to Univ_Managers
grant select, insert, update, delete on MarkRegister to Univ_Managers
grant select, insert, update, delete on StudentCourses to Univ_Managers
grant select, insert, update, delete on Exam to Univ_Managers

go

  