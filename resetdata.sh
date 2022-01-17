netlify sites:list | grep -o "https:\/\/[A-Za-z0-9\.\/]*" > resetdata.txt
sed -i -e 's#https://#find="#g' resetdata.txt
sed -i -e 's/.netlify.app/"/g' resetdata.txt
(head -n 1 resetdata.txt > datareset.sh ; cat isidata.sh >> datareset.sh ; sed -i '1s/^/replace="sini"\'$'\n/' datareset.sh)