@echo off

set projloc=E:\AliSweidan_HabibKhalaf
set conn=-S ALI-SWEIDAN -U sa -P 3li@admin -w 300

cls

echo Begining on top of MS Sqlserver DBMS engine...

echo trigger1-GPA
sqlcmd %conn% -i "%projloc%\sql.scripts\trigger1-GPA.sql" -o "%projloc%\univdb\log\univdb-trigger1-GPA.log"

echo trigger2-StudentCoursesInsertToMarkRegister
sqlcmd %conn% -i "%projloc%\sql.scripts\trigger2-StudentCoursesInsertToMarkRegister.sql" -o "%projloc%\univdb\log\trigger2-StudentCoursesInsertToMarkRegister.log"


echo trigger3-StudentCoursesDeleteToMarkRegister
sqlcmd %conn% -i "%projloc%\sql.scripts\trigger3-StudentCoursesDeleteToMarkRegister.sql" -o "%projloc%\univdb\log\trigger3-StudentCoursesDeleteToMarkRegister.log"


echo trigger4-TriggerDeleteStudent
sqlcmd %conn% -i "%projloc%\sql.scripts\trigger4-TriggerDeleteStudent.sql" -o "%projloc%\univdb\log\trigger4-TriggerDeleteStudent.log"

echo End of batch file....
