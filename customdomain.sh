#!/bin/bash

read -p "Masukkan alamat lengkap (dengan https) custom domain anda: "  customdomain
echo "baseURL = $customdomain!" > customdomain.txt
sed -i -e 's/baseURL = /baseURL = "/g' customdomain.txt
sed -i -e 's/!/"/g' customdomain.txt
(head -n 1 customdomain.txt > config.toml)

read -p "Masukkan alamat (tanpa https) custom domain anda: "  kopi
echo "copyright = Copyright 2021 [$kopi](https://$kopi)!" > kopi.txt
sed -i -e 's/copyright = /copyright = "/g' kopi.txt
sed -i -e 's/!/"/g' kopi.txt
(head -n 1 kopi.txt >> config.toml)

read -p "Masukkan nama site custom domain anda (boleh kapital dan pisah): "  sitename
echo "title = $sitename!" > sitename.txt 
sed -i -e 's/title = /title = "/g' sitename.txt
sed -i -e 's/!/"/g' sitename.txt
(head -n 1 sitename.txt >> config.toml ; cat isiconfig.toml >> config.toml ; sed -i '1s/^/######################## default configuration ####################\'$'\n/' config.toml ; printf '3m84\nw\n' | ex config.toml ; mv ../berkah/config.toml ../berkah/export/deploy/config.toml)