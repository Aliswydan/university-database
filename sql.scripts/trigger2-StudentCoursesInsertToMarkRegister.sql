USE univdb;
GO

-- Create a trigger
CREATE TRIGGER trg_StudentCoursesInsert
ON StudentCourses
AFTER INSERT
AS
BEGIN
    INSERT INTO MarkRegister (student_id, course_id, exam_id, mark)
    SELECT i.student_id, i.course_id, e.exam_id, NULL  
    FROM inserted i
    JOIN Course c ON i.course_id = c.course_id
    JOIN Exam e ON e.course_id = c.course_id;
END;
