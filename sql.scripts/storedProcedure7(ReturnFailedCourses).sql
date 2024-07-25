use univdb
go 

CREATE PROCEDURE GetFailedCourses
    @studentID CHAR(5)
AS
BEGIN
    SELECT c.course_id, c.course_name, c.semester, mr.mark
    FROM Student s
    INNER JOIN MarkRegister mr ON s.student_id = mr.student_id
    INNER JOIN Course c ON mr.course_id = c.course_id
    WHERE s.student_id = @studentID AND mr.mark < 50
    ORDER BY c.semester DESC;
END;

EXEC GetFailedCourses '300'