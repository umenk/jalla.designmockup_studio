netlify sites:list | grep -o "https:\/\/[A-Za-z0-9\.\/]*" > resetcom.txt
sed -i -e 's#https://#find="#g' resetcom.txt
sed -i -e 's/.netlify.app/"/g' resetcom.txt
(head -n 1 resetcom.txt > autoreset.sh ; cat isireset.sh >> autoreset.sh ; sed -i '1s/^/replace="sini"\'$'\n/' autoreset.sh)