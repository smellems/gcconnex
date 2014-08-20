#!/bin/sh


# give permission to develop_tool_test plugin
chmod -R 777 /develop_tool_test

# finds all the files
echo "list of files:"

# look in the /mod/ directory
for file in /var/www/elgg-prod2/mod/* 
do
#echo ${file}
if [ -d "${file}/languages" ]; then 
#echo "Language folder exists"


#echo ${file}

chmod 777 -R "${file}/languages"
ls -l "${file}/languages"

fi

done

# look in the root directory of elgg
