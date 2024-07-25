use univdb
go

CREATE PROCEDURE UpdateMarksForCourse
    @courseID CHAR(5)
AS
BEGIN
    DECLARE @examID CHAR(5);
    DECLARE @studentID CHAR(5);
    DECLARE @currentMark DECIMAL(6,2);

    -- Declare and open the cursor
    DECLARE MarkCursor CURSOR FOR
    SELECT exam_id, student_id, mark
    FROM MarkRegister
    WHERE course_id = @courseID AND mark >= 40 AND mark <= 49;

    OPEN MarkCursor;

    -- Fetch the first row
    FETCH NEXT FROM MarkCursor INTO @examID, @studentID, @currentMark;

    -- Loop through the cursor
    WHILE @@FETCH_STATUS = 0
    BEGIN
        -- Update the mark to 50
        UPDATE MarkRegister
        SET mark = 50
        WHERE exam_id = @examID AND student_id = @studentID;

        -- Fetch the next row
        FETCH NEXT FROM MarkCursor INTO @examID, @studentID, @currentMark;
    END

    -- Close and deallocate the cursor
    CLOSE MarkCursor;
    DEALLOCATE MarkCursor;
END
GO