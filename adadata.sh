php generate-sitemap.php && php export-sitemap.php && php export-hugo.php && cd export/deploy && hugo && netlify unlink && netlify link --name sini && var=val printf "public\n" | netlify deploy --prod