#!/bin/bash
echo "WARNING: run this in the folder that contains images"

read -p "# IMAGE FILETYPE (type number):
(1) jpg
(2) png
(3) tif
(4) all (WARN: works only on raster images)
: " format

if [[ $format = "1" ]]
	then
	filetype="JPG"
	imagequery="*.[jJ][pP]*[gG]"
elif [ $format = "2" ]
	then
	filetype="PNG"
	imagequery="*.[pP][nN][gG]"
elif [ $format = "3" ]
	then
	filetype="TIFF"
	imagequery="*.[tT][iI][fF]*"
elif [ $format = "4" ]
	then
	filetype="ALL IMGS IN FOLDER"
	imagequery="*"
else
	echo "ERROR, unknown image type"
	exit
fi
echo "Got it, it's - $filetype !"

read -p "# IMAGE WIDTH (type px numbers only): " width 

read -p "# IMAGE DESTINATION FOLDER (type folder name): " output 

mkdir ./"$output"; for f in $imagequery; do ffmpeg -i "$f" -vf scale="$width":-1 "./$output/${f%%}"; done