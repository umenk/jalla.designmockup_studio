netlify sites:list | grep -o "https:\/\/[A-Za-z0-9\.\/]*" > setcom.txt
sed -i -e 's#https://#replace="#g' setcom.txt
sed -i -e 's/.netlify.app/"/g' setcom.txt
(head -n 1 setcom.txt > auto2.sh ; cat isised.sh >> auto2.sh ; sed -i '1s#^#find="sini"\'$'\n#' auto2.sh)