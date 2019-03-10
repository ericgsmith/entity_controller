<?php

namespace Drupal\entity_controller_exmaple\Factory;

use Drupal\node\NodeInterface;
use Drupal\entity_controller\Factory\EntityControllerBaseFactory;
use Drupal\user\UserInterface;

class ControllerFactory extends EntityControllerBaseFactory {

  /**
   * @param \Drupal\node\NodeInterface $node
   *
   * @return \Drupal\entity_controller_exmaple\Plugin\EntityController\Node\ArticleCtrl
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getNodeArticleCtrl(NodeInterface $node) {
    return $this->getController($node);
  }

  /**
   * @param \Drupal\node\NodeInterface $node
   *
   * @return \Drupal\entity_controller_exmaple\Plugin\EntityController\NodeBasicPage
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getNodeBasicPageCtrl(NodeInterface $node) {
    return $this->getController($node);
  }

  /**
   * @param \Drupal\user\UserInterface $user
   *
   * @return \Drupal\entity_controller_exmaple\Plugin\EntityController\UserCtrl
   * @throws \Drupal\Component\Plugin\Exception\PluginException
   */
  public function getUserCtrl(UserInterface $user) {
    return $this->getController($user);
  }
}
