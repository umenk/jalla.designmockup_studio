netlify sites:list | grep -o "https:\/\/[A-Za-z0-9\.\/]*" > datacom.txt
sed -i -e 's#https://#replace="#g' datacom.txt
sed -i -e 's/.netlify.app/"/g' datacom.txt
(head -n 1 datacom.txt > data2.sh ; cat isisedata.sh >> data2.sh ; sed -i '1s#^#find="sini"\'$'\n#' data2.sh)