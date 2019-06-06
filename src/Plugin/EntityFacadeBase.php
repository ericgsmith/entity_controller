<?php

namespace Drupal\entity_facade\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\entity_facade\Exception\InvalidEntityException;

/**
 * Base class for entity facades.
 */
abstract class EntityFacadeBase extends PluginBase implements EntityFacadeInterface {

  /**
   * Drupal content entity.
   *
   * @var \Drupal\Core\Entity\ContentEntityInterface
   */
  private $entity;

  /**
   * EntityFacadeBase constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param ContentEntityInterface $entity
   *   Drupal content entity.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ContentEntityInterface $entity) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->setEntity($entity);
  }

  /**
   * Sets the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   Drupal content entity.
   *
   * @throws \Drupal\entity_facade\Exception\InvalidEntityException
   *   When an invalid entity is supplied for the controller.
   */
  protected function setEntity(ContentEntityInterface $entity) {
    if (!$this->isValidEntity($entity)) {
      throw new InvalidEntityException('Invalid entity object provided to the entity facade.');
    }

    $this->entity = $entity;
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
