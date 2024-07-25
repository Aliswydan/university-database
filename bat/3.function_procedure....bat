@echo off

set projloc=E:\AliSweidan_HabibKhalaf
set conn=-S ALI-SWEIDAN -U sa -P 3li@admin -w 300

cls

echo Begining on top of MS Sqlserver DBMS engine...

echo Cursor1-UpdateMarksForCourse
sqlcmd %conn% -i "%projloc%\sql.scripts\Cursor1-UpdateMarksForCourse.sql" -o "%projloc%\univdb\log\univdb-Cursor1-UpdateMarksForCourse.log"


echo function1-CalculateTotalStudentCredits
sqlcmd %conn% -i "%projloc%\sql.scripts\function1-CalculateTotalStudentCredits.sql" -o "%projloc%\univdb\log\univdb-function1-CalculateTotalStudentCredits.log"


echo function2-GetRegisteredTeachersFunction
sqlcmd %conn% -i "%projloc%\sql.scripts\function2-GetRegisteredTeachersFunction.sql" -o "%projloc%\univdb\log\univdb-function2-GetRegisteredTeachersFunction.log"



echo function3-getRegisteredStudents
sqlcmd %conn% -i "%projloc%\sql.scripts\function3-getRegisteredStudents.sql" -o "%projloc%\univdb\log\univdb-function3-getRegisteredStudents.log"






echo storedprocedure1-GetStudentCoursesAndMarksWithSemesterAndCredit
sqlcmd %conn% -i "%projloc%\sql.scripts\storedprocedure1-GetStudentCoursesAndMarksWithSemesterAndCredit.sql" -o "%projloc%\univdb\log\storedprocedure1-GetStudentCoursesAndMarksWithSemesterAndCredit.log"




echo storedprocedure2(withTransaction)-EnrollStudentInSemester1
sqlcmd %conn% -i "%projloc%\sql.scripts\storedprocedure2(withTransaction)-EnrollStudentInSemester1.sql" -o "%projloc%\univdb\log\storedprocedure2(withTransaction)-EnrollStudentInSemester1.log"


echo storedprocedure3(withTransaction)-EnrollStudentInSemester
sqlcmd %conn% -i "%projloc%\sql.scripts\storedprocedure3(withTransaction)-EnrollStudentInSemester.sql" -o "%projloc%\univdb\log\storedprocedure3(withTransaction)-EnrollStudentInSemester.log"



echo storedprocedure4(withTransaction)-UnenrollStudentfromCourse
sqlcmd %conn% -i "%projloc%\sql.scripts\storedprocedure4(withTransaction)-UnenrollStudentfromCourse.sql" -o "%projloc%\univdb\log\storedprocedure4(withTransaction)-UnenrollStudentfromCourse.log"



echo storedprocedure5-GetTeacherCourses
sqlcmd %conn% -i "%projloc%\sql.scripts\storedprocedure5-GetTeacherCourses.sql" -o "%projloc%\univdb\log\storedprocedure5-GetTeacherCourses.log"



echo storedProcedure6(ReturnPassedCourses)
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure6(ReturnPassedCourses).sql" -o "%projloc%\univdb\log\storedProcedure6(ReturnPassedCourses).log"


echo storedProcedure7(ReturnFailedCourses)
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure7(ReturnFailedCourses).sql" -o "%projloc%\univdb\log\storedProcedure7(ReturnFailedCourses).log"



echo storedProcedure8-GetTeacherExams
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure8-GetTeacherExams.sql" -o "%projloc%\univdb\log\storedProcedure8-GetTeacherExams.log"


echo storedProcedure9-AddMarksForExam
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure9-AddMarksForExam.sql" -o "%projloc%\univdb\log\storedProcedure9-AddMarksForExam.log"

echo storedProcedure10-GetCourseForMark
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure10-GetCourseForMark.sql" -o "%projloc%\univdb\log\storedProcedure10-GetCourseForMark.log"


echo storedProcedure11-AddANDEditTeacher
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure11-AddANDEditTeacher.sql" -o "%projloc%\univdb\log\storedProcedure11-AddANDEditTeacher.log"

echo storedProcedure12-AddStudent
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure12-AddStudent.sql" -o "%projloc%\univdb\log\storedProcedure12-AddStudent.log"

echo storedProcedure13-AddCourse
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure13-AddCourse.sql" -o "%projloc%\univdb\log\storedProcedure13-AddCourse.log"

echo storedProcedure14-AddExam
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure14-AddExam.sql" -o "%projloc%\univdb\log\storedProcedure14-AddExam.log"

echo storedProcedure15-ViewCoursesAndExams
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure15-ViewCoursesAndExams.sql" -o "%projloc%\univdb\log\storedProcedure15-ViewCoursesAndExams.log"


echo storedProcedure16-DeleteStudentById
sqlcmd %conn% -i "%projloc%\sql.scripts\storedProcedure16-DeleteStudentById.sql" -o "%projloc%\univdb\log\storedProcedure16-DeleteStudentById.log"






echo End of batch file....
