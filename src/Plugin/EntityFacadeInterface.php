<?php

namespace Drupal\entity_facade\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for entity facades.
 *
 * There are no explicit methods on the face interface. Instead facades themselves
 * broker the interactions to the entity that is covered by each plugin.
 */
interface EntityFacadeInterface extends PluginInspectionInterface {

}
