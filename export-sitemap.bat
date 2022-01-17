@echo OFF
cls
:start
set domain=
set seo=
echo '
echo '
echo NOTE : 
echo - Domain wajib menggunakan http atau https ex: http://domainku.com
echo - SEO path adalah path tambahan antara url domain dan path artikel. Tulis 'no' tanpa tanda petik jika struktur domain/artikel.html
echo '
echo '
set /p domain= _Domain : 
set /p seo= _Seo path (tulis 'no' jika tidak ada): 

php export-sitemap.php %domain% %seo%
pause