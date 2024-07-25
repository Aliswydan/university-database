use univdb
go


CREATE PROCEDURE GetTeacherCourses
    @teacher_id char(5)
AS
BEGIN
    SELECT
        C.course_id,
        C.course_name,
        C.hours,
        C.credits,
        C.semester
    FROM
        Teacher T
    INNER JOIN
        Course C ON T.teacher_id = C.teacher_id
    WHERE
        T.teacher_id = @teacher_id;
END;
