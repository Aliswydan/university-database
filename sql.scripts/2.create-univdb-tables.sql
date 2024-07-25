use univdb
go

if exists (select 1
            from  sysobjects
           where  id = object_id('ADMINSTRATOR')
            and   type = 'U')
   drop table Adminstrator
go


if exists (select 1
            from  sysobjects
           where  id = object_id('TEACHER')
            and   type = 'U')
   drop table Teacher
go

if exists (select 1
            from  sysobjects
           where  id = object_id('COURSE')
            and   type = 'U')
   drop table COURSE
go


if exists (select 1
            from  sysobjects
           where  id = object_id('STUDENT')
            and   type = 'U')
   drop table STUDENT
go

if exists (select 1
            from  sysobjects
           where  id = object_id('EXAM')
            and   type = 'U')
   drop table EXAM
go



if exists (select 1
            from  sysobjects
           where  id = object_id('MARKREGISTER')
            and   type = 'U')
   drop table MARKREGISTER
go


if exists (select 1
            from  sysobjects
           where  id = object_id('STUDENTCOURSES')
            and   type = 'U')
   drop table STUDENTCOURSES
go



/*==============================================================*/
/* Table: ADMINSTRATOR                                          */
/*==============================================================*/
create table Adminstrator (
   admin_name          varchar(50)          not null,
   password            varchar(50)          not null,
   primary key (admin_name)
)
go


/*==============================================================*/
/* Table: TEACHER                                               */
/*==============================================================*/
create table Teacher (
   teacher_id           char(5)              not null,
   admin_name           varchar(50)          not null,
   password             varchar(50)          not null,
   teacher_name         varchar(50)          not null,
   address              varchar(50)          null,
   phone                varchar(50)          null,
   speciality           varchar(50)          null,
   primary key (teacher_id),
   foreign key (admin_name) references Adminstrator (admin_name)      

)
go


/*==============================================================*/
/* Table: COURSE                                                */
/*==============================================================*/
create table Course (
   course_id            char(5)              not null,
   teacher_id           char(5)              not null,
   admin_name           varchar(50)          not null,
   course_name          varchar(50)          null,
   hours                int                  null,
   credits              int                  null,
   semester             varchar(50)          null,
   primary key (course_id),
   foreign key (teacher_id) references Teacher (teacher_id),
   foreign key (admin_name) references Adminstrator (admin_name)

)
go

/*==============================================================*/
/* Table: EXAM                                                  */
/*==============================================================*/
create table Exam (
   exam_id              char(5)              not null,
   course_id            char(5)              not null,
   exam_date            date             null,
   start_time           time             null,
   end_time             time             null,
   primary key (exam_id),
   foreign key (course_id) references Course (course_id)
)
go

/*==============================================================*/
/* Table: STUDENT                                               */
/*==============================================================*/
create table Student (
   student_id           char(5)              not null,
   admin_name           varchar(50)          not null,
   password             varchar(50)          null,
   student_name         varchar(50)          null,
   birthdate            datetime             null,
   address              varchar(50)          null,
   phone                varchar(50)          null,
   GPA                  decimal(10,2)        null,
   primary key (student_id),
   foreign key (admin_name) references Adminstrator (admin_name)
)
go

/*==============================================================*/
/* Table: MARKREGISTER                                          */
/*==============================================================*/
create table MarkRegister (
   exam_id              char(5)              not null,
   student_id           char(5)              not null,
   course_id            char(5)              not null,
   mark                 decimal(6,2)         null,
   foreign key (exam_id) references Exam (exam_id),
   foreign key (student_id) references Student (student_id),
   foreign key (course_id) references Course (course_id)
)
go

/*==============================================================*/
/* Table: STUDENTCOURSES                                        */
/*==============================================================*/
create table StudentCourses (
   course_id            char(5)              not null,
   student_id           char(5)              not null,
   foreign key (student_id) references Student (student_id),
   foreign key (course_id) references Course (course_id)
)
go
