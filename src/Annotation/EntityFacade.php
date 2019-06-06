<?php

namespace Drupal\entity_facade\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines an entity facade annotation object.
 *
 * @see \Drupal\entity_facade\Plugin\EntityFacadeManager
 * @see plugin_api
 *
 * @Annotation
 */
class EntityFacade extends Plugin {

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
   * The entity type ID the facade works with.
   *
   * @var string
   */
  public $entityType;

  /**
   * The entity bundles the facade works with.
   *
   * @var string[]
   */
  public $entityBundles;

}
