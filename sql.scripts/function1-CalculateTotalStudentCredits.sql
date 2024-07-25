USE univdb;
GO


DROP FUNCTION [dbo].[CalculateTotalStudentCredits];
GO

-- Create a scalar-valued function
CREATE FUNCTION CalculateTotalStudentCredits
(
    @student_id CHAR(5)
)
RETURNS INT
AS
BEGIN
    DECLARE @totalCredits INT;

    -- Calculate the total credits for the given student, including only courses with marks below 50 or NULL
    SELECT @totalCredits = COALESCE(SUM(C.credits), 0)
    FROM Course C
    WHERE C.course_id IN (SELECT course_id FROM StudentCourses WHERE student_id = @student_id)
        AND (NOT EXISTS (SELECT 1 FROM MarkRegister MR WHERE MR.course_id = C.course_id AND MR.student_id = @student_id) OR
             COALESCE((SELECT MAX(MR.mark) FROM MarkRegister MR WHERE MR.course_id = C.course_id AND MR.student_id = @student_id), 0) < 50);

    RETURN @totalCredits;
END;




/*

DECLARE @student_id CHAR(5) = '200';
DECLARE @result INT;
SET @result = dbo.CalculateTotalStudentCredits(@student_id);
SELECT @result AS TotalCredits;

*/