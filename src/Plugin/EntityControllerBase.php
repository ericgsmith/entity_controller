<?php

namespace Drupal\entity_controller\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\entity_controller\Exception\EntityControllerException;

/**
 * Base class for Entity controllers.
 */
abstract class EntityControllerBase extends PluginBase implements EntityControllerInterface {

  /**
   * Drupal content entity.
   *
   * @var \Drupal\Core\Entity\ContentEntityInterface
   */
  private $entity;

  /**
   * {@inheritdoc}
   */
  public function setEntity(ContentEntityInterface $entity) {
    if (!$this->isValidEntity($entity)) {
      throw new EntityControllerException('Invalid entity provided to plugin.');
    }

    $this->entity = $entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getEntity() {
    return $this->entity;
  }

  /**
   * Check if an entity is valid for this controller.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *  Drupal content entity.
   *
   * @return bool
   *   TRUE when the entity can be used by this controller.
   */
  protected function isValidEntity(ContentEntityInterface $entity) {
    if ($this->pluginDefinition['entityType'] !== $entity->getEntityTypeId()) {
      return FALSE;
    }

    $bundles = $this->pluginDefinition['entityBundles'];
    // Treat no bundles supplied as applicable to all types.
    return empty($bundles) || in_array($entity->bundle(), $bundles, TRUE);
  }
}
