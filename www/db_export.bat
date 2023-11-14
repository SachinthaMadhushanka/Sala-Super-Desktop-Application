@echo off
set DB_HOST=localhost
set DB_NAME=sala_super_db
set DB_USER=root
set DB_PASSWORD=
set BACKUP_FILE="Backups/file.sql"

"C:\xampp\mysql\bin\mysqldump.exe" -h %DB_HOST% -u %DB_USER% %DB_NAME% > %BACKUP_FILE%
