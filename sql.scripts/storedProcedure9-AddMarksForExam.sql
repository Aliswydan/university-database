USE univdb;
GO

-- Drop the existing stored procedure
IF EXISTS (SELECT * FROM sys.objects WHERE type = 'P' AND name = 'AddMarksForExam')
    DROP PROCEDURE AddMarksForExam;
GO

-- Recreate the stored procedure with the desired modifications
CREATE PROCEDURE AddMarksForExam
    @course_id char(5),
    @student_id char(5),
    @mark decimal(6, 2)
AS
BEGIN
    UPDATE MarkRegister 
    SET mark = @mark
    WHERE course_id = @course_id AND student_id = @student_id;
END;



/*


-- Execute the modified stored procedure
EXEC AddMarksForExam @course_id = 'I2203', @student_id = '300', @mark = 85.5;
-- Check the MarkRegister table
SELECT * FROM MarkRegister WHERE course_id = 'I2203' AND student_id = '300';


*/