use univdb
go

CREATE PROCEDURE AddExam
    @exam_id CHAR(5),
    @course_id CHAR(5),
    @exam_date DATE,
    @start_time TIME,
    @end_time TIME
AS
BEGIN
    -- Check if the exam already exists
    IF NOT EXISTS (SELECT 1 FROM Exam WHERE exam_id = @exam_id)
    BEGIN
        -- Insert the exam into the Exam table
        INSERT INTO Exam (exam_id, course_id, exam_date, start_time, end_time)
        VALUES (@exam_id, @course_id, @exam_date, @start_time, @end_time);

        -- Return success message
        SELECT 'Exam added successfully.' AS Result;
    END
    ELSE
    BEGIN
        -- Return error message if the exam already exists
        SELECT 'Error: Exam with ID ' + @exam_id + ' already exists.' AS Result;
    END
END;


