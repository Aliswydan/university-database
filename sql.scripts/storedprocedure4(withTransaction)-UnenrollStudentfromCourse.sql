USE univdb;
GO

-- Drop the existing stored procedure if it exists
IF EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[UnenrollStudentFromCourse]') AND type in (N'P', N'PC'))
    DROP PROCEDURE [dbo].[UnenrollStudentFromCourse];
GO

CREATE PROCEDURE UnenrollStudentFromCourse
    @student_id CHAR(5),
    @course_id CHAR(5)
AS
BEGIN
    BEGIN TRANSACTION;

    -- Check if the student is enrolled in the course
    IF EXISTS (SELECT 1 FROM StudentCourses WHERE student_id = @student_id AND course_id = @course_id)
    BEGIN
        -- Check the mark for the student and course
        DECLARE @studentMark INT;

        SELECT @studentMark = mark
        FROM MarkRegister
        WHERE student_id = @student_id AND course_id = @course_id;

        -- Check if the mark is below 50
        IF @studentMark IS NULL OR @studentMark < 50
        BEGIN
            -- Unenroll the student from the course
            DELETE FROM StudentCourses WHERE student_id = @student_id AND course_id = @course_id;
            COMMIT;
            PRINT 'Student successfully unenrolled from the course.';
        END
        ELSE
        BEGIN
            -- Rollback if the student has a mark above or equal to 50
            ROLLBACK;
            PRINT 'The student cannot be unenrolled because the mark is 50 or above.';
        END;
    END
    ELSE
    BEGIN
        -- Rollback if the student is not enrolled in the course
        ROLLBACK;
        PRINT 'The student is not currently enrolled in the specified course.';
    END;
END;

