<?php

namespace Drupal\entity_controller\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines an interface for Entity controllers.
 */
interface EntityControllerInterface extends PluginInspectionInterface {

  /**
   * Sets the entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   Drupal content entity.
   *
   * @throws \Drupal\entity_controller\Exception\EntityControllerException
   *   When an invalid entity is supplied for the controller.
   */
  public function setEntity(ContentEntityInterface $entity);

}
