#!/bin/bash
set -eo pipefail
# Read the current version and date from the PHP file
current_version=$(grep "define('VERSION_APP'" "version.php" | awk -F "'" '{print $4}' )
current_date=$(   grep "define('VERSION_DATE'" "version.php" | awk -F "'" '{print $4}'| sed 's/\//\\\//g')

calc=$(echo $current_version| tr -d '.')
# Increment the version number
new_version=$((calc + 1))

# Format the new version as x.y
formatted_version=$(awk -v new_version="$new_version" 'BEGIN {printf "%.1f", new_version / 10}')

# Get the current timestamp
new_date=$(date +"%d/%m/%Y %H:%M" | sed 's/\//\\\//g')

# Update the PHP file with the new version and date
sed -i "s/define('VERSION_APP', '$current_version')/define('VERSION_APP', '$formatted_version')/" "version.php"
sed -i "s/define('VERSION_DATE', '$current_date')/define('VERSION_DATE', '$new_date')/" "version.php"


echo "Version incremented to $formatted_version, Date updated to $new_date"


rsync -av --exclude='cardeal.sql' --exclude='compose-dev.yaml' --exclude='composer.json' --exclude='composer.lock' --exclude='config.php' --exclude='Dockerfile' --exclude='.eslintrc.json' --exclude='fichas/' --exclude='.git/' --exclude='.gitignore' --exclude='gruntfile.js' --exclude='.htaccess' --exclude='.idea/' --exclude='LICENSE.md' --exclude='logs/' --exclude='package.json' --exclude='package-lock.json' --exclude='README.md' --exclude='schema/' --exclude='sendToPrd.sh' . root@ns1.virtual2.net:/home/cardeal/domains/quintacardeal.com/papa/
