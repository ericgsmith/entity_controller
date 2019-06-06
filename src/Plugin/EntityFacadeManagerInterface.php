<?php

namespace Drupal\entity_facade\Plugin;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Manages the instantiation of entity facade plugins.
 */
interface EntityFacadeManagerInterface extends PluginManagerInterface {

  /**
   * Create the plugin instance from the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   Drupal content entity.
   *
   * @return \Drupal\entity_facade\Plugin\EntityFacadeInterface
   *   A fully configured plugin instance.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   *   If the instance cannot be created, such as if the ID is invalid.
   */
  public function createInstanceFromEntity(ContentEntityInterface $entity);
}
