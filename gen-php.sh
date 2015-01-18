#!/bin/sh

set -e
set -x

rm -rf php-out
TEMP=`mktemp -d /tmp/rsvph2tp.XXXXXX`
echo $TEMP
for file in `find . -name '*.php' -not -path '*vendor*' -not -name 'idx.php'`
do
	outdir="$TEMP/`dirname $file`/"
	mkdir -p $outdir
	cp $file $outdir
done

h2tp $TEMP php-out --no-collections
chmod 755 php-out
find php-out -name '*.php' -exec sed -i '' '/HACKLIB_ROOT/ d' '{}' ';'

cp lib/idx.php php-out/lib/idx.php
cp -r vendor php-out/
ln -s ../templates php-out

rm -rf $TEMP
