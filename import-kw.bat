@echo OFF
cls
:start
set /p max= Max Content [Enter to Skip]:
php import-kw.php keywords.txt en us %max%
php generate-sitemap.php
pause