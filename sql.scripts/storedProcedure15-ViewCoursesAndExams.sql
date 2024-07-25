
use univdb
go



CREATE FUNCTION ViewCoursesAndExams
(
    @admin_name VARCHAR(50)
)
RETURNS TABLE
AS
RETURN
(
    SELECT
        C.course_id,
        C.course_name,
        C.teacher_id,
        T.teacher_name, 
        C.hours,
        C.credits,
        C.semester,
        E.exam_id,
        E.exam_date,
        E.start_time,
        E.end_time
    FROM
        Course AS C
    LEFT JOIN
        Exam AS E ON C.course_id = E.course_id
    LEFT JOIN
        Teacher AS T ON C.teacher_id = T.teacher_id  -- Join with Teacher table
    WHERE
        C.admin_name = @admin_name
);
