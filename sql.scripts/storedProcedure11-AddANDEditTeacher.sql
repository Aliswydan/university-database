
use univdb
go

CREATE PROCEDURE AddTeacher
    @teacherID CHAR(5),
    @adminName VARCHAR(50),
    @password VARCHAR(50),
    @teacherName VARCHAR(50),
    @address VARCHAR(50) = NULL,
    @phone VARCHAR(50) = NULL,
    @speciality VARCHAR(50) = NULL
AS
BEGIN
    INSERT INTO Teacher (teacher_id, admin_name, password, teacher_name, address, phone, speciality)
    VALUES (@teacherID, @adminName, @password, @teacherName, @address, @phone, @speciality);
END;
GO


CREATE PROCEDURE EditTeacher
    @teacherId CHAR(5),
    @admin_name VARCHAR(50),
    @teacher_name VARCHAR(50),
    @password VARCHAR(50),
    @phone VARCHAR(50),
    @address VARCHAR(50),
    @speciality VARCHAR(50)
AS
BEGIN
    UPDATE Teacher
    SET teacher_name = @teacher_name,
        password = @password,
        phone = @phone,
        address = @address,
        speciality = @speciality
    WHERE teacher_id = @teacherId;
END;
GO