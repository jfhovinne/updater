#!/bin/sh

ROOTDIR=`pwd`

if [ -d "$ROOTDIR/web" ]; then
  chmod -R 755 $ROOTDIR/web
  rm -rf $ROOTDIR/web
fi

vendor/bin/drush qd -y --core=drupal-$DRUPAL_MAJOR_VERSION --root=$ROOTDIR/web --no-server
mkdir -p web/sites/all/drush/updater
ln -s $ROOTDIR/updater.drush.inc web/sites/all/drush/updater/updater.drush.inc
ln -s $ROOTDIR/phpunit.xml.dist web/sites/all/drush/updater/phpunit.xml.dist
ln -s $ROOTDIR/src web/sites/all/drush/updater/src
ln -s $ROOTDIR/tests web/sites/all/drush/updater/tests
ln -s $ROOTDIR/vendor web/sites/all/drush/updater/vendor
