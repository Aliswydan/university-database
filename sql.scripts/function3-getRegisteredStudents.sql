use univdb
go

CREATE FUNCTION dbo.GetRegisteredStudentsFunction
    (@adminName VARCHAR(50))
RETURNS TABLE
AS
RETURN
(
    SELECT student_id, password, student_name, birthdate, address, phone, GPA
    FROM Student
    WHERE admin_name = @adminName
);
