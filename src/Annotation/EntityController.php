<?php

namespace Drupal\entity_controller\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Entity controller item annotation object.
 *
 * @see \Drupal\entity_controller\Plugin\EntityControllerManager
 * @see plugin_api
 *
 * @Annotation
 */
class EntityController extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The entity type id the controller works with.
   *
   * @var string
   */
  public $entityType;

  /**
   * The entity bundles the controller works with.
   *
   * @var string[]
   */
  public $entityBundles;

}
