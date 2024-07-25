USE univdb;
GO

-- Drop the existing stored procedure
IF EXISTS (SELECT * FROM sys.objects WHERE type = 'P' AND name = 'GetCourseForMark')
    DROP PROCEDURE GetCourseForMark;
GO

CREATE PROCEDURE GetCourseForMark
    @courseID CHAR(5),
    @teacherID CHAR(5)
AS
BEGIN
    SELECT
        SC.course_id,
        C.course_name,
		SC.student_id,
        MR.mark,
        C.semester
    FROM
        StudentCourses SC
    INNER JOIN
        MarkRegister MR ON SC.student_id = MR.student_id AND SC.course_id = MR.course_id
    INNER JOIN
        Course C ON SC.course_id = C.course_id AND C.teacher_id = @teacherID
    WHERE
        SC.course_id = @courseID;
END;



-- EXEC GetCourseForMark  @courseID = 'I1110', @teacherID = 'a200';


