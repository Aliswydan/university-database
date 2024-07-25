use univdb
go

CREATE PROCEDURE AddCourse
    @course_id CHAR(5),
    @teacher_id CHAR(5),
    @admin_name VARCHAR(50),
    @course_name VARCHAR(50),
    @hours INT,
    @credits INT,
    @semester VARCHAR(50)
AS
BEGIN
    -- Check if the course already exists
    IF NOT EXISTS (SELECT 1 FROM Course WHERE course_id = @course_id)
    BEGIN
        -- Insert the course into the Course table
        INSERT INTO Course (course_id, teacher_id, admin_name, course_name, hours, credits, semester)
        VALUES (@course_id, @teacher_id, @admin_name, @course_name, @hours, @credits, @semester);

        -- Return success message
        SELECT 'Course added successfully.' AS Result;
    END
    ELSE
    BEGIN
        -- Return error message if the course already exists
        SELECT 'Error: Course with ID ' + @course_id + ' already exists.' AS Result;
    END
END;
