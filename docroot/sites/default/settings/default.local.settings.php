<?php

/**
 * @file
 * Only do these things locally on lando, even if this file is included.
 */

if (isset($_ENV['LANDO_INFO'])) {
  // Local error reporting.
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  ini_set('xdebug.max_nesting_level', 512);
  ini_set('memory_limit', '512M');
  $config['system.logging']['error_level'] = 'verbose';
  $config['system.performance']['css']['preprocess'] = FALSE;
  $config['system.performance']['js']['preprocess'] = FALSE;

  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/local.services.yml';
  $settings['file_chmod_directory'] = 0755;
  $settings['file_chmod_file'] = 0644;
  $settings['hash_salt'] = 'Xi0pd_Tv7FllD-7VQDF8OMZlyoeMp5oUc2rOIZ55jUvUTOfkGlLUDo2QLzafzNQ1MqdIoGOWWg';
  $settings['skip_permissions_hardening'] = TRUE;
  $settings['trusted_host_patterns'][] = '^localhost.*$';
  $settings['trusted_host_patterns'][] = '^127\.0.*$';
  $settings['trusted_host_patterns'][] = '^.*\.lndo\.site$';

  // Configure private and temporary file paths.
  if (!isset($settings['file_private_path'])) {
    $settings['file_private_path'] = '../private';
  }

  // Set up oembed iframe domain if lando provides info in _ENV.
  $lando_info = json_decode($_ENV['LANDO_INFO']);
  if (isset($lando_info->app->urls[0])) {
    $config['media.settings']['iframe_domain'] = $lando_info->app->urls[0];
  }
}
