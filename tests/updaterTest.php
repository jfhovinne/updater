<?php

namespace Drush\updater\Unit;

use PHPUnit\Framework\TestCase;
use Drush\updater\Controller;
use Symfony\Component\Process\Process;

/**
 * Updater test class.
 */
class UpdaterTest extends TestCase {

  /**
   * Process of last executed command.
   *
   * @var Process
   */
  private $process;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    $this->drupal_major_version = getenv('DRUPAL_MAJOR_VERSION');
    $this->updaters_path = dirname(__FILE__) . '/updaters/' . $this->drupal_major_version . '/';
  }

  /**
   * Test if the command is available.
   */
  public function testCommandAvailable() {
    $command = "drush";
    $this->process = new Process($command);
    $this->process->run();
    $this->assertContains('update-website', $this->process->getOutput());
  }

  /**
   * Test updater 01.
   */
  public function testUpdater01() {
    $updater = $this->updaters_path . 'updater-01-maintenance.php';
    $this->assertTrue(Controller::isValidUpdater($updater));
    $this->assertEquals($this->execute($updater, TRUE), 0);
    $log = $this->process->getErrorOutput();
    $this->assertContains('maintenance_mode 1', $log);
  }

  /**
   * Test updater 02.
   */
  public function testUpdater02() {
    $updater = $this->updaters_path . 'updater-02-maintenance.php';
    $this->assertTrue(Controller::isValidUpdater($updater));
    $this->assertEquals($this->execute($updater, TRUE), 0);
    $log = $this->process->getErrorOutput();
    $this->assertContains('maintenance_mode 0', $log);
  }

  /**
   * Test all updaters.
   */
  public function testUpdaters() {
    $this->assertEquals($this->execute($this->updaters_path, TRUE), 0);
    $log = $this->process->getErrorOutput();
    $this->assertContains('maintenance_mode 1', $log);
    $this->assertContains('maintenance_mode 0', $log);
  }

  /**
   * Execute drush update-website command.
   */
  private function execute($path, $testing = FALSE) {
    $command = "drush update-website -v --path=$path";
    if ($testing) {
      $command .= " --test";
    }
    $this->process = new Process($command);
    return $this->process->run();
  }

}
