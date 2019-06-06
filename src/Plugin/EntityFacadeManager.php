<?php

namespace Drupal\entity_facade\Plugin;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\entity_facade\Exception\EntityFacadeDefinitionException;
use Drupal\entity_facade\Annotation\EntityFacade;
use Drupal\entity_facade\Factory\EntityFacadeFactory;

/**
 * Provides the entity facade plugin manager.
 */
class EntityFacadeManager extends DefaultPluginManager implements EntityFacadeManagerInterface {

  /**
   * Constructs a new EntityFacadeManager object.
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
    parent::__construct('Plugin/EntityFacade', $namespaces, $module_handler, EntityFacadeInterface::class, EntityFacade::class);
    $this->factory = new EntityFacadeFactory($this, $this->pluginInterface);
    $this->alterInfo('entity_facade_entity_facade_info');
    $this->setCacheBackend($cache_backend, 'entity_facade_entity_facade_plugins');
  }

  /**
   * {@inheritDoc}
   */
  public function createInstanceFromEntity(ContentEntityInterface $entity) {
    $definition = $this->getPluginForEntityBundle($entity->getEntityTypeId(), $entity->bundle());
    return $this->createInstance($definition['id'], [], $entity);
  }

  /**
   * Creates a pre-configured instance of a plugin.
   *
   * @param string $plugin_id
   *   The ID of the plugin being instantiated.
   * @param array $configuration
   *   An array of configuration relevant to the plugin instance.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   Drupal content entity.
   *
   * @return \Drupal\entity_facade\Plugin\EntityFacadeInterface
   *   A fully configured plugin instance.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   *   If the instance cannot be created, such as if the ID is invalid.
   */
  public function createInstance($plugin_id, array $configuration = [], $entity = NULL) {
    return $this->getFactory()->createInstance($plugin_id, $configuration, $entity);
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
   * @throws \Drupal\entity_facade\Exception\EntityFacadeDefinitionException
   *   When the no applicable definitions are found.
   */
  protected function getPluginForEntityBundle($entityType, $entityBundle) {
    $entityTypeDefinitions = $this->getAllDefinitionsByType($entityType);
    $entityBundleDefinitions = $this->filterDefinitionsByBundle($entityBundle, $entityTypeDefinitions);
    // If nothing found by type, look for a fallback bundle.
    $applicableDefinitions = $entityBundleDefinitions ?: $this->filterDefinitionsByEmptyBundle($entityTypeDefinitions);

    if (count($applicableDefinitions) === 0) {
      throw new EntityFacadeDefinitionException('No plugin definitions found for entity type: ' . $entityType . ' bundle: ' . $entityBundle);
    }

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
