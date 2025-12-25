@echo off
REM ================================================================
REM TRENCH CITY V2 - DATABASE UPDATE SCRIPT
REM Run this to update your database to Torn-faithful state
REM ================================================================

echo.
echo ========================================
echo TRENCH CITY V2 - DATABASE UPDATE
echo ========================================
echo.

REM Set your MySQL path (update if different)
set MYSQL_PATH=C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe

REM Check if MySQL exists at default path
if not exist "%MYSQL_PATH%" (
    echo ERROR: MySQL not found at %MYSQL_PATH%
    echo.
    echo Please update MYSQL_PATH in this script to point to your mysql.exe
    echo Common locations:
    echo   C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe
    echo   C:\xampp\mysql\bin\mysql.exe
    echo   C:\wamp64\bin\mysql\mysql8.0.x\bin\mysql.exe
    echo.
    pause
    exit /b 1
)

REM Database credentials
set DB_USER=trench
set DB_PASS=Rianna2602!
set DB_HOST=10.7.222.14
set DB_NAME=trench_city

echo Connecting to database: %DB_NAME%@%DB_HOST%
echo User: %DB_USER%
echo.

REM Run the update script
echo [1/1] Applying database updates...
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -h %DB_HOST% %DB_NAME% < UPDATE_DATABASE_TO_CURRENT.sql

if %ERRORLEVEL% NEQ 0 (
    echo.
    echo ERROR: Database update failed!
    echo.
    pause
    exit /b 1
)

echo.
echo ========================================
echo DATABASE UPDATE COMPLETE!
echo ========================================
echo.
echo Your database is now Torn-faithful ready.
echo.
echo Next steps:
echo 1. Add 'require_once __DIR__ . '/player_core.php';' to core/bootstrap.php
echo 2. Update helpers.php nerve regen: 240 -^> 300 seconds (line ~1055)
echo 3. Update combat module to use awardXPFromAttack()
echo 4. Update crime module to use awardCrimeExperience()
echo.
pause
