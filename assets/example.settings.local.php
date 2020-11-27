<?php

// @codingStandardsIgnoreFile

use Drupal\Core\Installer\InstallerKernel;

/**
 * @file
 * Local development override configuration feature.
 *
 * Original location of this file is `assets/example.settings.local.php`.
 * It's copied to `web/sites/default/example.settings.local.php` during the
 * scaffolding.
 */

const ENABLE_DEVELOPMENT_MODE = FALSE;
const ENABLE_LOCAL_REDIS = TRUE;

/**
 * Assertions.
 *
 * The Drupal project primarily uses runtime assertions to enforce the
 * expectations of the API by failing when incorrect calls are made by code
 * under development.
 *
 * @see http://php.net/assert
 * @see https://www.drupal.org/node/2492225
 *
 * If you are using PHP 7.0 it is strongly recommended that you set
 * zend.assertions=1 in the PHP.ini file (It cannot be changed from .htaccess
 * or runtime) on development machines and to 0 in production.
 *
 * @see https://wiki.php.net/rfc/expectations
 */
assert_options(ASSERT_ACTIVE, TRUE);
\Drupal\Component\Assertion\Handle::register();


$host = getenv('DRUPAL_DB_HOST');
$port = getenv('DRUPAL_DB_PORT');

// If DDEV_PHP_VERSION is not set but IS_DDEV_PROJECT *is*, it means we're running (drush) on the host,
// so use the host-side bind port on docker IP
if (empty(getenv('DDEV_PHP_VERSION') && getenv('IS_DDEV_PROJECT') == 'true')) {
  $host = '127.0.0.1';
  $port = 32773;
}

$databases['default']['default'] = [
  'database' => getenv('DRUPAL_DB_DATABASE'),
  'username' => getenv('DRUPAL_DB_USERNAME'),
  'password' => getenv('DRUPAL_DB_PASSWORD'),
  'host' => $host,
  'port' => $port,
  'driver' => 'mysql',
  'prefix' => getenv('DRUPAL_DB_PREFIX'),
  'collation' => getenv('DRUPAL_DB_COLLATION'),
];

$settings['hash_salt'] = getenv('DRUPAL_SALT');

// This will prevent Drupal from setting read-only permissions on sites/default.
$settings['skip_permissions_hardening'] = TRUE;

// This will ensure the site can only be accessed through the intended host
// names. Additional host patterns can be added for custom configurations.
$settings['trusted_host_patterns'] = ['.*'];

// Don't use Symfony's APCLoader. ddev includes APCu; Composer's APCu loader has
// better performance.
$settings['class_loader_auto_detect'] = FALSE;

$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = 'sites/default/files/private';

if (ENABLE_DEVELOPMENT_MODE) {
  /**
   * Enable local development services.
   */
  $settings['container_yamls'][] = DRUPAL_ROOT . '/sites/default/services.local.yml';

  /**
   * Show all error messages, with backtrace information.
   *
   * In case the error level could not be fetched from the database, as for
   * example the database connection failed, we rely only on this value.
   */
  $config['system.logging']['error_level'] = 'verbose';

  /**
   * Disable CSS and JS aggregation.
   */
  $config['system.performance']['css']['preprocess'] = FALSE;
  $config['system.performance']['js']['preprocess'] = FALSE;

  /**
   * Disable the render cache.
   *
   * Note: you should test with the render cache enabled, to ensure the correct
   * cacheability metadata is present. However, in the early stages of
   * development, you may want to disable it.
   *
   * This setting disables the render cache by using the Null cache back-end
   * defined by the development.services.yml file above.
   *
   * Only use this setting once the site has been installed.
   */
  // $settings['cache']['bins']['render'] = 'cache.backend.null';

  /**
   * Disable caching for migrations.
   *
   * Uncomment the code below to only store migrations in memory and not in the
   * database. This makes it easier to develop custom migrations.
   */
  // $settings['cache']['bins']['discovery_migration'] = 'cache.backend.memory';

  /**
   * Disable Internal Page Cache.
   *
   * Note: you should test with Internal Page Cache enabled, to ensure the correct
   * cacheability metadata is present. However, in the early stages of
   * development, you may want to disable it.
   *
   * This setting disables the page cache by using the Null cache back-end
   * defined by the development.services.yml file above.
   *
   * Only use this setting once the site has been installed.
   */
  // $settings['cache']['bins']['page'] = 'cache.backend.null';

  /**
   * Disable Dynamic Page Cache.
   *
   * Note: you should test with Dynamic Page Cache enabled, to ensure the correct
   * cacheability metadata is present (and hence the expected behavior). However,
   * in the early stages of development, you may want to disable it.
   */
  // $settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';

  /**
   * Allow test modules and themes to be installed.
   *
   * Drupal ignores test modules and themes by default for performance reasons.
   * During development it can be useful to install test extensions for debugging
   * purposes.
   */
  $settings['extension_discovery_scan_tests'] = TRUE;

  /**
   * Enable access to rebuild.php.
   *
   * This setting can be enabled to allow Drupal's php and database cached
   * storage to be cleared via the rebuild.php page. Access to this page can also
   * be gained by generating a query string from rebuild_token_calculator.sh and
   * using these parameters in a request to rebuild.php.
   */
  $settings['rebuild_access'] = TRUE;

  /**
   * Skip file system permissions hardening.
   *
   * The system module will periodically check the permissions of your site's
   * site directory to ensure that it is not writable by the website user. For
   * sites that are managed with a version control system, this can cause problems
   * when files in that directory such as settings.php are updated, because the
   * user pulling in the changes won't have permissions to modify files in the
   * directory.
   */
  $settings['skip_permissions_hardening'] = TRUE;

  /**
   * Exclude modules from configuration synchronization.
   *
   * On config export sync, no config or dependent config of any excluded module
   * is exported. On config import sync, any config of any installed excluded
   * module is ignored. In the exported configuration, it will be as if the
   * excluded module had never been installed. When syncing configuration, if an
   * excluded module is already installed, it will not be uninstalled by the
   * configuration synchronization, and dependent configuration will remain
   * intact. This affects only configuration synchronization; single import and
   * export of configuration are not affected.
   *
   * Drupal does not validate or sanity check the list of excluded modules. For
   * instance, it is your own responsibility to never exclude required modules,
   * because it would mean that the exported configuration can not be imported
   * anymore.
   *
   * This is an advanced feature and using it means opting out of some of the
   * guarantees the configuration synchronization provides. It is not recommended
   * to use this feature with modules that affect Drupal in a major way such as
   * the language or field module.
   */
  # $settings['config_exclude_modules'] = ['devel', 'stage_file_proxy'];

  /**
   * Configuration Split.
   *
   * Enable development only profile for local environments.
   */
  $config['config_split.config_split.development']['status'] = TRUE;
}

if (ENABLE_LOCAL_REDIS && !InstallerKernel::installationAttempted() && extension_loaded('redis') && class_exists('Drupal\redis\ClientFactory')) {
  // Set Redis as the default backend for any cache bin not otherwise specified.
  $settings['cache']['default'] = 'cache.backend.redis';
  $settings['redis.connection']['host'] = 'redis';
  $settings['redis.connection']['port'] = 6379;

  // Apply changes to the container configuration to better leverage Redis.
  // This includes using Redis for the lock and flood control systems, as well
  // as the cache tag checksum. Alternatively, copy the contents of that file
  // to your project-specific services.yml file, modify as appropriate, and
  // remove this line.
  $settings['container_yamls'][] = 'modules/contrib/redis/example.services.yml';

  // Allow the services to work before the Redis module itself is enabled.
  $settings['container_yamls'][] = 'modules/contrib/redis/redis.services.yml';

  // Manually add the classloader path, this is required for the container cache bin definition below
  // and allows to use it without the redis module being enabled.
  $class_loader->addPsr4('Drupal\\redis\\', 'modules/contrib/redis/src');

  // Use redis for container cache.
  // The container cache is used to load the container definition itself, and
  // thus any configuration stored in the container itself is not available
  // yet. These lines force the container cache to use Redis rather than the
  // default SQL cache.
  $settings['bootstrap_container_definition'] = [
    'parameters' => [],
    'services' => [
      'redis.factory' => [
        'class' => 'Drupal\redis\ClientFactory',
      ],
      'cache.backend.redis' => [
        'class' => 'Drupal\redis\Cache\CacheBackendFactory',
        'arguments' => ['@redis.factory', '@cache_tags_provider.container', '@serialization.phpserialize'],
      ],
      'cache.container' => [
        'class' => '\Drupal\redis\Cache\PhpRedis',
        'factory' => ['@cache.backend.redis', 'get'],
        'arguments' => ['container'],
      ],
      'cache_tags_provider.container' => [
        'class' => 'Drupal\redis\Cache\RedisCacheTagsChecksum',
        'arguments' => ['@redis.factory'],
      ],
      'serialization.phpserialize' => [
        'class' => 'Drupal\Component\Serialization\PhpSerialize',
      ],
    ],
  ];
}
