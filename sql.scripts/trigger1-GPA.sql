USE univdb;
GO

-- Drop the existing trigger named UpdateGPA
DROP TRIGGER UpdateGPA;



USE univdb;
GO



CREATE TRIGGER UpdateStudentGPA
ON MarkRegister
AFTER INSERT, UPDATE
AS
BEGIN
    DECLARE @studentID CHAR(5);

    -- Get the student ID from the affected rows (inserted or updated)
    SELECT @studentID = student_id
    FROM inserted;

    -- Update the student's GPA
    UPDATE Student
    SET GPA = (
        SELECT ISNULL(SUM(m.mark * c.credits) / NULLIF(SUM(c.credits), 0), 0)
        FROM MarkRegister m
        INNER JOIN Course c ON m.course_id = c.course_id
        WHERE m.student_id = @studentID
    )
    WHERE student_id = @studentID;
END;