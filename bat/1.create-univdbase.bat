@echo off

set projloc=E:\AliSweidan_HabibKhalaf
set conn=-S ALI-SWEIDAN -U sa -P 3li@admin -w 300

cls

echo Begining on top of MS Sqlserver DBMS engine...

sqlcmd %conn% -i "%projloc%\sql.scripts\1.create-univdb.sql" -o "%projloc%\univdb\log\1.create-univdb.log"

echo database created...
echo End of batch file.
