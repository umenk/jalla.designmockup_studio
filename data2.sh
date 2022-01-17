find="sini"
replace="classicchevrolet"
sed -i'.backup' "s+${find}+${replace}+g" adadata.sh ; sed -i'.backup' "s+${find}+${replace}+g" shuriken2.sh