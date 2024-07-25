USE univdb;
GO

-- Drop the existing stored procedure if it exists
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[EnrollStudentInSemester]') AND type in (N'P', N'PC'))
    DROP PROCEDURE [dbo].[EnrollStudentInSemester];
GO

-- Create the stored procedure for Semester enrollment
CREATE PROCEDURE EnrollStudentInSemester
    @student_id CHAR(5),
    @course_id CHAR(5),
    @semester VARCHAR(50)
AS
BEGIN
    BEGIN TRANSACTION;
    DECLARE @totalCredits INT;
    DECLARE @currentSemester VARCHAR(50) = @semester;
    DECLARE @previousSemester VARCHAR(50);

    -- Extract the numeric part of the current semester
    DECLARE @currentSemesterNumber INT;
    SET @currentSemesterNumber = TRY_CAST(RIGHT(@currentSemester, CHARINDEX('-', REVERSE(@currentSemester)) - 1) AS INT);

    -- Check if the result is not negative
    IF @currentSemesterNumber IS NOT NULL AND @currentSemesterNumber > 1
    BEGIN
        -- Calculate the previous semester
        SET @previousSemester = 'Semester-' + CAST(@currentSemesterNumber - 1 AS VARCHAR(10));
    END
    ELSE
    BEGIN
        PRINT 'Cannot calculate previous semester for the first semester or invalid format.';
        ROLLBACK;
        RETURN;
    END;

    -- Check if the student is enrolled in all previous semester courses
    IF NOT EXISTS (
        SELECT 1
        FROM Course
        WHERE semester = @previousSemester
          AND NOT EXISTS (
              SELECT 1
              FROM StudentCourses SC
              WHERE SC.student_id = @student_id
                AND SC.course_id = Course.course_id
          )
    )
    BEGIN
        -- Calculate the total credits for the student
        SELECT @totalCredits = dbo.CalculateTotalStudentCredits(@student_id);

        -- Retrieve the credits of the new Semester 2 course
        DECLARE @courseCredits INT;
        SELECT @courseCredits = ISNULL(credits, 0)
        FROM Course
        WHERE course_id = @course_id;

        -- Check if adding the new Semester course will not exceed 30 credits
        IF (@totalCredits + @courseCredits) <= 30
        BEGIN
            -- Enroll the student in the new Semester course
            INSERT INTO StudentCourses (student_id, course_id)
            VALUES (@student_id, @course_id);
            COMMIT;
            PRINT 'Student successfully enrolled in the ' + @semester + ' course.';

        END
        ELSE
        BEGIN
            PRINT 'Enrollment exceeds the credit limit of 30 or student not enrolled in all previous Semester courses.';
            ROLLBACK;
        END;
    END
    ELSE
    BEGIN
        PRINT 'Student is not enrolled in all previous Semester courses.';
        ROLLBACK;
    END;
END;



/*

DECLARE @studentID CHAR(5) = '200';
DECLARE @courseID CHAR(5) = 'I3306'; -- Course in Semester 2

-- Execute the stored procedure
EXEC EnrollStudentInSemester @student_id = @studentID, @course_id = @courseID , @semester = 'semester-1' ;


*/