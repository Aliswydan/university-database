use univdb
go

CREATE PROCEDURE AddStudent
    @studentID CHAR(5),
    @adminName VARCHAR(50),
    @password VARCHAR(50) = NULL,
    @studentName VARCHAR(50) = NULL,
    @birthdate DATETIME = NULL,
    @address VARCHAR(50) = NULL,
    @phone VARCHAR(50) = NULL,
    @GPA DECIMAL(10,2) = NULL
AS
BEGIN
    INSERT INTO Student (student_id, admin_name, password, student_name, birthdate, address, phone)
    VALUES (@studentID, @adminName, @password, @studentName, @birthdate, @address, @phone);
END;
