<?php

namespace Drupal\entity_controller_example\Plugin\EntityController;

use Drupal\entity_controller\Plugin\EntityControllerBase;

/**
 * Example annotation.
 *
 * @EntityController(
 *  id = "user",
 *  label = @Translation("User"),
 *  entityType = "user"
 * )
 */
class UserCtrl extends EntityControllerBase {

}
