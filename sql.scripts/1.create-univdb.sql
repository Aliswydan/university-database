
USE master;
GO

CREATE DATABASE univdb
ON 
( NAME = 'univdb',
  FILENAME = 'E:\AliSweidan_HabibKhalaf\univdb\univdb.mdf')
LOG ON
( NAME = 'univdb_log',
  FILENAME = 'E:\AliSweidan_HabibKhalaf\univdb\univdb.ldf');
