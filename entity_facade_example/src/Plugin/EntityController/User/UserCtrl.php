<?php

namespace Drupal\entity_facade_example\Plugin\EntityController;

use Drupal\entity_facade\Plugin\EntityFacadeBase;

/**
 * Example annotation.
 *
 * @EntityController(
 *  id = "user",
 *  label = @Translation("User"),
 *  entityType = "user"
 * )
 */
class UserCtrl extends EntityFacadeBase {

}
