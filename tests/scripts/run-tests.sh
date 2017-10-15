#!/bin/sh

ROOTDIR=`pwd`

cd $ROOTDIR/web/sites/all/drush/updater
vendor/bin/drush cc drush
vendor/bin/phpunit tests -d DRUPAL_MAJOR_VERSION=$DRUPAL_MAJOR_VERSION
