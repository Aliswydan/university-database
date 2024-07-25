USE univdb;
GO

-- Create a trigger
CREATE TRIGGER trg_StudentCoursesDelete
ON StudentCourses
AFTER DELETE
AS
BEGIN
    -- Delete records from MarkRegister for each deleted entry in StudentCourses
    DELETE FROM MarkRegister
    WHERE EXISTS (
        SELECT 1
        FROM deleted d
        WHERE MarkRegister.course_id = d.course_id
    );
END;
