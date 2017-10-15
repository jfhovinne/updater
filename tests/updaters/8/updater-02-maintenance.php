<?php

/**
 * @file
 * Basic updater.
 */

/**
 * Basic updater which puts the website back online.
 */
function updater_02_maintenance_update() {
  drush_invoke_process('@self', 'sset', array('system.maintenance_mode', 0));
}
