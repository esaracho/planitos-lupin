for f in *.jpg
    do 
    bname=`basename -s .jpg $f`
    magick $f -resize 800x800\> ../mini/$bname-mini.jpg
done
