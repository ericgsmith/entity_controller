<?php

namespace Drupal\entity_controller\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\entity_controller\Exception\EntityControllerException;
use Drupal\entity_controller\Annotation\EntityController;

/**
 * Provides the Entity controller plugin manager.
 */
class EntityControllerManager extends DefaultPluginManager {

  /**
   * Constructs a new EntityControllerManager object.
   * Constructs a new EntityControllerManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/EntityController', $namespaces, $module_handler, EntityControllerInterface::class, EntityController::class);
    $this->alterInfo('entity_controller_entity_controller_info');
    $this->setCacheBackend($cache_backend, 'entity_controller_entity_controller_plugins');
  }

  /**
   * Gets applicable plugin definitions by entity type and bundle.
   *
   * @param string $entityType
   *   Entity type id.
   * @param string $entityBundle
   *   Entity bundle id.
   *
   * @return array
   *   Plugin definition for this entity type and bundle.
   *
   * @throws \Drupal\entity_controller\Exception\EntityControllerException
   *   When the count of applicable plugins in not 1.
   */
  public function getPluginForEntityBundle($entityType, $entityBundle) {
    $entityTypeDefinitions = $this->getAllDefinitionsByType($entityType);
    $entityBundleDefinitions = $this->filterDefinitionsByBundle($entityBundle, $entityTypeDefinitions);
    // If nothing found by type, look for a fallback bundle.
    $applicableDefinitions = $entityBundleDefinitions ?: $this->filterDefinitionsByEmptyBundle($entityTypeDefinitions);

    if (count($applicableDefinitions) === 0) {
      throw new EntityControllerException('No plugin definitions found for entity type: ' . $entityType . ' bundle: ' . $entityBundle);
    }

    // @todo - Do we need to care if multiple are found? Just return the first.
    return reset($applicableDefinitions);
  }

  /**
   * @param string $entityType
   *   Entity type id.
   *
   * @return array
   *   Plugin definition for this entity type and bundle.
   */
  protected function getAllDefinitionsByType($entityType) {
    return array_filter($this->getDefinitions(), function ($definition) use ($entityType) {
      return $definition['entityType'] === $entityType;
    });
  }

  /**
   * Filters a list of plugin definitions for a given entity bundle.
   *
   * @param string $entityBundle
   *   Entity bundle id.
   * @param array $definitions
   *   Plugin definitions to filter.
   *
   * @return array
   *   Filtered plugin definitions.
   */
  protected function filterDefinitionsByBundle($entityBundle, array $definitions) {
    return array_filter($definitions, function ($definition) use ($entityBundle) {
      return in_array($entityBundle, $definition['entityBundles'], TRUE);
    });
  }

  /**
   * Filters a list of plugin definitions for an empty entity bundle.
   *
   * @param array $definitions
   *   Plugin definitions to filter.
   *
   * @return array
   *   Filtered plugin definitions.
   */
  protected function filterDefinitionsByEmptyBundle(array $definitions) {
    return array_filter($definitions, function ($definition) {
      return empty($definition['entityBundles']);
    });
  }
}
