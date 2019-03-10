<?php

namespace Drupal\entity_controller\Factory;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\entity_controller\Plugin\EntityControllerManager;

/**
 * Class EntityControllerBaseFactory
 *
 * The base factory acts as a wrapper around the plugin manager.
 *
 * @package Drupal\entity_controller\Factory
 */
class EntityControllerBaseFactory {

  /**
   * Entity Controller plugin manager.
   *
   * @var \Drupal\entity_controller\Plugin\EntityControllerManager
   */
  private $pluginManager;

  /**
   * EntityControllerBaseFactory constructor.
   *
   * @param \Drupal\entity_controller\Plugin\EntityControllerManager $pluginManager
   *   Entity Controller plugin manager.
   */
  public function __construct(EntityControllerManager $pluginManager) {
    $this->pluginManager = $pluginManager;
  }

  /**
   * Get the controller for the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   Drupal content entity.
   *
   * @return \Drupal\entity_controller\Plugin\EntityControllerInterface
   *   Entity Controller plugin for the given entity.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   *   When an error occurs creating the plugin.
   * @throws \Drupal\entity_controller\Exception\EntityControllerException
   *   When no controller is found for the plugin.
   */
  public function getController(ContentEntityInterface $entity) {
    $entityControllerPluginDefinition = $this->pluginManager->getPluginForEntityBundle($entity->getEntityTypeId(), $entity->bundle());
    /** @var \Drupal\entity_controller\Plugin\EntityControllerInterface $instance */
    $instance = $this->pluginManager->createInstance($entityControllerPluginDefinition['id'], []);
    $instance->setEntity($entity);
    return $instance;
  }
}
