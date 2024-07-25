USE univdb;
GO

-- Drop the existing stored procedure if it exists
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[EnrollStudentInSemester1]') AND type in (N'P', N'PC'))
    DROP PROCEDURE [dbo].[EnrollStudentInSemester1];
GO

-- Create the modified stored procedure
CREATE PROCEDURE EnrollStudentInSemester1
    @student_id CHAR(5),
    @course_id CHAR(5),
	@semester varchar(50)
AS
BEGIN
    BEGIN TRANSACTION;

    -- Calculate the total credits of the student using the function
    DECLARE @totalCredits INT = dbo.CalculateTotalStudentCredits(@student_id);

    -- Retrieve the credits of the new course
    DECLARE @courseCredits INT = ISNULL((SELECT credits FROM Course WHERE course_id = @course_id), 0);

    -- Check if adding the new course will not exceed 30 credits
    IF (@totalCredits + @courseCredits) <= 30
    BEGIN
        -- Enroll the student in the new course
        INSERT INTO StudentCourses (student_id, course_id)
        VALUES (@student_id, @course_id);     
        COMMIT;
    END
    ELSE
    BEGIN
        ROLLBACK;
    END;
END;


/*
-- Test the stored procedure

DECLARE @studentID1 CHAR(5) = '200';
DECLARE @courseID1 CHAR(5) = 'I2204'; -- Semester 1 course

-- Execute the stored procedure
EXEC EnrollStudentInSemester1 @student_id = @studentID1, @course_id = @courseID1;

DECLARE @studentID CHAR(5) = '200';
DECLARE @courseID CHAR(5) = 'I3306'; -- Course in Semester 2

-- Execute the stored procedure
EXEC EnrollStudentInSemester1 @student_id = @studentID, @course_id = @courseID;
*/