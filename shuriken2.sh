cd export/deploy && hugo && netlify unlink && netlify link --name sini && var=val printf "public\n" | netlify deploy --prod
