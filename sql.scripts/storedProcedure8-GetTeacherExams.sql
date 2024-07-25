use univdb
go

CREATE PROCEDURE GetTeacherExams
    @teacher_id char(5)
AS
BEGIN
    SELECT E.exam_id, E.course_id, C.course_name, E.exam_date, E.start_time, E.end_time
    FROM Exam E
    INNER JOIN Course C ON E.course_id = C.course_id
    WHERE C.teacher_id = @teacher_id;
END;


