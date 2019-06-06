<?php

namespace Drupal\entity_facade_example\Factory;

use Drupal\entity_facade\Plugin\EntityFacadeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Factory to get the entity facade.
 *
 * The is not required, but is useful to up casting the return type given by the
 * plugin manager.
 */
class FacadeFactory {

  /**
   * Entity facade plugin manager.
   *
   * @var \Drupal\entity_facade\Plugin\EntityFacadeManagerInterface
   */
  protected $entityFacadeManager;

  /**
   * FacadeFactory constructor.
   *
   * @param \Drupal\entity_facade\Plugin\EntityFacadeManagerInterface $entityFacadeManager
   */
  public function __construct(EntityFacadeManagerInterface $entityFacadeManager) {
    $this->entityFacadeManager = $entityFacadeManager;
  }

  /**
   * Get the facade for a node article.
   *
   * @param \Drupal\node\NodeInterface $node
   *   Drupal content entity.
   *
   * @return \Drupal\entity_facade_example\Plugin\EntityController\Node\Article
   *   The article facade.
   *
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getNodeArticleCtrl(NodeInterface $node) {
    return $this->entityFacadeManager->createInstanceFromEntity($node);
  }
}
