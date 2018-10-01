#!/bin/bash
#
# $1 = env
# $2 = {{release}}
# $3 = {{project}}

# Symlink to persistent storage
dirs=(
    "storage"
    "public/uploads"
);

for i in "${dirs[@]}" ; do
    rm -rf ${2}/${i};
    mkdir -p ${3}/storage/${i};
    ln -sf ${3}/storage/${i} ${2}/${i};
    sudo chmod -R 0777 ${3}/storage/${i};
done;

files=(
    ".env"
    "config/license.key"
);

for i in "${files[@]}" ; do
    rm -rf ${2}/${i};
    ln -sf ${3}/storage/${i} ${2}/${i};
done;

# Update asset versioning
timestamp=$(date +%s);
cp ${2}/public/assets/css/style.min.css ${2}/public/assets/css/style.min.${timestamp}.css;
cp ${2}/public/assets/js/script.min.js $2/public/assets/js/script.min.${timestamp}.js;
sed -i -e "s/'staticAssetCacheTime' => ''/'staticAssetCacheTime' => $timestamp/g" ${2}/config/general.php;

# Fix a cache issue that prevents Envoyer from deleting old releases
for f in ${3}/releases/*; do
    if [ -d "${f}/storage" ]; then
        sudo chmod -R 0777 ${f}/storage;
    fi
    if [ -d "${f}/public/cache" ]; then
        sudo chmod -R 0777 ${f}/public/cache;
    fi
    if [ -d "${f}/public/cpresources" ]; then
        sudo chmod -R 0777 ${f}/public/cpresources;
    fi
done;
