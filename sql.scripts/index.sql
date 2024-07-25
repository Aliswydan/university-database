
use univdb
go
---
/*==============================================================*/
/* Index: Teaches_FK                                            */
/*==============================================================*/
create index Teaches_FK on Course (
teacher_id ASC
)
go

/*==============================================================*/
/* Index: AdminC_FK                                            */
/*==============================================================*/
create index AdminC_FK on Course (
admin_name ASC
)
go

/*==============================================================*/
/* Index: AdminT_FK                                            */
/*==============================================================*/
create index AdminT_FK on Teacher (
admin_name ASC
)
go


/*==============================================================*/
/* Index: AdminS_FK                                            */
/*==============================================================*/
create index AdminS_FK on Student (
admin_name ASC
)
go

/*==============================================================*/
/* Index: MarkRegister1_FK                                      */
/*==============================================================*/
create index MarkRegister1_FK on MarkRegister (
course_id ASC
)
go

/*==============================================================*/
/* Index: MarkRegister2_FK                                      */
/*==============================================================*/
create index MarkRegister2_FK on MarkRegister (
exam_id ASC
)
go

/*==============================================================*/
/* Index: MarkRegister3_FK                                      */
/*==============================================================*/
create index MarkRegister3_FK on MarkRegister (
student_id ASC
)
go


/*==============================================================*/
/* Index: StudentCourses1_FK                                     */
/*==============================================================*/
create index StudentCourses1_FK on StudentCourses (
course_id ASC
)
go

/*==============================================================*/
/* Index: StudentCourses2_FK                                     */
/*==============================================================*/
create index StudentCourses2_FK on StudentCourses (
student_id ASC
)
go


/*==============================================================*/
/* Index: Exam_FK                                     */
/*==============================================================*/
create index Exam_FK on StudentCourses (
course_id ASC
)
go
