USE univdb
GO

CREATE TRIGGER TriggerDeleteStudent
ON Student
INSTEAD OF DELETE
AS
BEGIN
    DELETE FROM StudentCourses WHERE student_id IN (SELECT student_id FROM deleted);
    DELETE FROM MarkRegister WHERE student_id IN (SELECT student_id FROM deleted);
    DELETE FROM Student WHERE student_id IN (SELECT student_id FROM deleted);
END
GO
























