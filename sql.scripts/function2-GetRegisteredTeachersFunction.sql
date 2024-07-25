
use univdb
go

CREATE FUNCTION dbo.GetRegisteredTeachersFunction
    (@adminName VARCHAR(50))
RETURNS TABLE
AS
RETURN
(
    SELECT teacher_id, password, teacher_name, address, phone, speciality
    FROM Teacher
    WHERE admin_name = @adminName
);
