#!/bin/bash
PS3='Shuriken3rs, Pilih Job Yang Akan Anda Lalukan, Semoga berhasil: '
mods=("Clear shuriken data, hugo public dan posts lama serta scrape hingga deploy ke netlify" "Scrape dengan mempertahankan data lama hingga deploy ke netlify" "Tanpa Scrape karena saya sudah punya shuriken data" "Custom domain, Scrape Sampai Siap hugo untuk diUpload ke Self Hosting" "Custom domain, Data ada, Export Hugo data & Siap Hugo untuk diUpload ke Self Hosting" "Clear data, Scrape Sampai Siap hugo, custom domain, deploy netlify" "Clear data saja" "Quit")
echo Simple Shuriken 3 Hugo Menu:
echo ====================================
echo
select fav in "${mods[@]}"; do
    case $fav in
        "Clear shuriken data, hugo public dan posts lama serta scrape hingga deploy ke netlify")
            echo "$fav Gaaaass!" && sh merdeka.sh
        # optionally call a function or run some code here
            ;;
        "Scrape dengan mempertahankan data lama hingga deploy ke netlify")
            echo "Semoga $fav lancar ya Shuriken3rs, Gaaaass ." && sh auto3.sh
        # optionally call a function or run some code here
            ;;
        "Tanpa Scrape karena saya sudah punya shuriken data")
            echo "Gaaaass $fav tinggal berdoa agar cepat index dan traffic banyak." && sh data.sh
        # optionally call a function or run some code here
            ;;
        "Custom domain, Scrape Sampai Siap hugo untuk diUpload ke Self Hosting")
            echo "Gaaaass, $fav." && sh shu3hugo.sh
        # optionally call a function or run some code here
            ;;
        "Custom domain, Data ada, Export Hugo data & Siap Hugo untuk diUpload ke Self Hosting")
            echo "$fav sabar ya." && sh data2hugo.sh
        # optionally call a function or run some code here
            ;;
        "Clear data, Scrape Sampai Siap hugo, custom domain, deploy netlify")
            echo "Gaaaass, $fav." && sh custom3.sh  
        # optionally call a function or run some code here
            ;;
        "Clear data saja")
            echo "Gaaaass, $fav." && sh clean.sh  
        # optionally call a function or run some code here
        break
            ;;
    "Quit")
        echo "User requested exit"
        exit
        ;;
        *) echo "invalid option $REPLY";;
    esac
done