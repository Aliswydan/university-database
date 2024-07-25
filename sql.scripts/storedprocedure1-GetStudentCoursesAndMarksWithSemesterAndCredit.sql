USE univdb;
GO


-- Create a stored procedure to retrieve a student's courses and marks with semester and credit information
CREATE PROCEDURE GetStudentCoursesAndMarksWithSemesterAndCredit
    @studentID CHAR(5)
AS
BEGIN
    -- Main query to retrieve student's courses and marks with semester and credit information
    SELECT
        SC.course_id,
        C.course_name,
        C.credits,  
        MR.mark,
        C.semester
    FROM
        StudentCourses SC
    INNER JOIN
        MarkRegister MR ON SC.student_id = MR.student_id AND SC.course_id = MR.course_id
    INNER JOIN
        Course C ON SC.course_id = C.course_id
    WHERE
        SC.student_id = @studentID;
END;



-- EXEC GetStudentCoursesAndMarksWithSemesterAndCredit @studentID = '200';

