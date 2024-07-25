use univdb
go

--insert data to Adminstrator
insert into Adminstrator values ('zeinab Saghir','CS1234')
go

--insert data to Teacher
insert into Teacher values ('m200','zeinab Saghir', 'dbouk', 'Mohamed Dbouk', 'Beirut', '76000000', 'CS-DB')
insert into Teacher values ('z200','zeinab Saghir', 'zein', 'Zein Ibrahim', 'Beirut', '71000000', 'CS-C')
insert into Teacher values ('f200','zeinab Saghir', 'faour', 'Ahmad Faour', 'Beirut', '03000000', 'CS-OS')
insert into Teacher values ('a200','zeinab Saghir', 'abed', 'Abed Safadi', 'Beirut', '81000000', 'CS-GUI')

go

--insert data to Course
insert into Course values ('I1110', 'm200','zeinab Saghir', 'DataBase 1', 72, 10 , 'semester-1')
insert into Course values ('I2210', 'm200','zeinab Saghir', 'DataBase 2', 72, 8 , 'semester-2')
insert into Course values ('I3310','m200','zeinab Saghir' , 'DataBase 3', 50, 8 , 'semester-3')
insert into Course values ('I4410','m200','zeinab Saghir' , 'DataBase 4', 50, 8 , 'semester-4')


insert into Course values ('I1104','z200','zeinab Saghir' , 'imperative Programming C', 60, 10 , 'semester-1')
insert into Course values ('I2204','z200','zeinab Saghir' , 'Data Structures', 60, 8 , 'semester-2')

insert into Course values ('I1103','f200','zeinab Saghir' , 'Operating System 1', 75, 10 , 'semester-1')
insert into Course values ('I2203','f200','zeinab Saghir' , 'Operating System 2', 75, 8 , 'semester-2')
insert into Course values ('I3303','f200','zeinab Saghir' , 'Operating System 3', 75, 8 , 'semester-3')
insert into Course values ('I4403','f200','zeinab Saghir' , 'Operating System 4', 75, 8 , 'semester-4')


insert into Course values ('I2205','a200','zeinab Saghir' , 'GUI-1', 50, 6 , 'semester-2')
insert into Course values ('I3305','a200','zeinab Saghir' , 'GUI-2', 50, 6 , 'semester-3')
insert into Course values ('I4405','a200','zeinab Saghir' , 'GUI-3', 50, 6 , 'semester-4')



go


-- insert data to Student
insert into Student values ('200','zeinab Saghir', '1234', 'Ali', '10-12-81', 'Beirut', '03434111', NULL)
insert into Student values ('300','zeinab Saghir', '1234', 'Habib', '7/11/82',  'Viborg', '01232211', NULL)
insert into Student values ('400','zeinab Saghir', '1234', 'Lana', '12/14/81', 'Birut', '07542312', NULL)
go


--insert Exam data
insert into Exam values ('DB1', 'I1110', '02/14/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('DB2', 'I2210', '07/14/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('DB3', 'I3310', '10/19/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('DB4', 'I4410', '11/16/2024', '13:30:00' ,'15:30:00')

insert into Exam values ('IPC','I1104',  '02/15/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('DS', 'I2204',  '07/14/2024', '13:30:00' ,'15:30:00')

insert into Exam values ('OS1', 'I1103',  '02/16/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('OS2', 'I2203',  '07/15/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('OS3', 'I3303',  '10/14/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('OS4', 'I4403',  '11/14/2024', '13:30:00' ,'15:30:00')

insert into Exam values ('GUI-1', 'I2205', '07/17/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('GUI-2', 'I3305', '10/14/2024', '13:30:00' ,'15:30:00')
insert into Exam values ('GUI-3', 'I4405', '11/14/2024', '13:30:00' ,'15:30:00')




go






