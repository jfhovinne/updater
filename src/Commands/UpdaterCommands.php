<?php

namespace Drupal\updater\Commands;

use Drush\Commands\DrushCommands;
use Drush\updater\Controller;

/**
 * Drush 9+ commandfile for Updater.
 */
class UpdaterCommands extends DrushCommands {

  /**
   * Updates the website instance by executing available updaters.
   *
   * @param array $options
   *   An associative array of options whose values come from cli, aliases, config, etc.
   * @option path
   *   Directory path where updaters are located, relative to Drupal root if not absolute. Defaults to sites/all/drush/updaters.
   * @option test
   *   Execute updates but do not set them as executed. Defaults to FALSE, is set to TRUE if exists.
   *
   * @command updater:update
   * @aliases update-website,upws
   */
  public function website(array $options = ['path' => null, 'test' => null]) {
    $args = func_get_args();
    unset($args[0]);
    $path = $options['path'] ? $options['path'] : DRUPAL_ROOT . '/sites/all/drush/updaters';
    $testing = $options['test'] ? TRUE : FALSE;
    $result = Controller::executeUpdaters($path, $args, $testing);
    drush_log(dt('All available updaters executed.'), 'success');
    return $result;
  }
}
