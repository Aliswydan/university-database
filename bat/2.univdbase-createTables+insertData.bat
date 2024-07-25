@echo off

set projloc=E:\AliSweidan_HabibKhalaf
set conn=-S ALI-SWEIDAN -U sa -P 3li@admin -w 300
cls

echo Begining on top of MS Sqlserver DBMS engine...

echo Security
sqlcmd %conn% -i "%projloc%\sql.scripts\Security.sql" -o "%projloc%\univdb\log\Security.log"
if %ERRORLEVEL% neq 0 (
    echo Error occurred during script execution.
    exit /b %ERRORLEVEL%
)

echo create tables...
sqlcmd %conn% -i "%projloc%\sql.scripts\2.create-univdb-tables.sql" -o "%projloc%\univdb\log\2.create-univdb-tables.log"
if %ERRORLEVEL% neq 0 (
    echo Error occurred during script execution.
    exit /b %ERRORLEVEL%
)


echo insert data....
sqlcmd %conn% -i "%projloc%\sql.scripts\3.create-univdb-insertdata.sql" -o "%projloc%\univdb\log\3.create-univdb-insertdata.log"
if %ERRORLEVEL% neq 0 (
    echo Error occurred during script execution.
    exit /b %ERRORLEVEL%
)


echo index
sqlcmd %conn% -i "%projloc%\sql.scripts\index.sql" -o "%projloc%\univdb\log\index.log"
if %ERRORLEVEL% neq 0 (
    echo Error occurred during script execution.
    exit /b %ERRORLEVEL%
)



echo End of batch file.
