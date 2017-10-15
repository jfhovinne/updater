<?php

namespace Drush\updater\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Updater test class.
 */
class UpdaterTest extends TestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->drupal_major_version = getenv('DRUPAL_MAJOR_VERSION');
    $this->updaters_path = dirname(__FILE__) . '/updaters/' . $this->drupal_major_version;
  }

  /**
   * Test if the command is available.
   */
  public function testCommandAvailable() {
    $output = shell_exec('drush');
    $this->assertContains('update-website', $output);
  }

  /**
   * Test basic updaters.
   */
  public function testUpdaters1() {
    $output = shell_exec("drush update-website --path=$this->updaters_path" . '/1');
    $this->assertContains('Executing updater', $output);
    if ($this->drupal_major_version < 8) {
      $output = shell_exec('drush vget maintenance_mode');
    }
    else {
      $output = shell_exec('drush sget system.maintenance_mode');
    }
    $this->assertContains('1', $output);
  }

}
