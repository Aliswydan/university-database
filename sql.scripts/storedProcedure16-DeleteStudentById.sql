use univdb
go


CREATE PROCEDURE DeleteStudentById
    @studentID CHAR(5)
AS
BEGIN
    DELETE FROM Student WHERE student_id = @studentID;
END