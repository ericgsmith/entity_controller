<?php

namespace Drupal\entity_facade_example\Plugin\EntityController\Node;

use Drupal\entity_facade\Plugin\EntityFacadeBase;

/**
 * Provides a facade to interact with article nodes.
 *
 * @method \Drupal\node\NodeInterface getEntity()
 *
 * @EntityController(
 *  id = "node_article",
 *  label = @Translation("Node: Article"),
 *  entityType = "node",
 *  entityBundles = {
 *   "article"
 *  }
 * )
 */
class Article extends EntityFacadeBase {

  // Fields on the article.
  const FIELD_IMAGE = 'field_image';
  const FIELD_TAGS = 'field_tags';

  /**
   * Check if the article has an image.
   *
   * Example of business logic that hides details of the field / entity
   * structure, but allows templates to easily check things like if the article
   * needs an image based layout.
   *
   * @return bool
   */
  public function hasImage() {
    return $this->getEntity()->get(self::FIELD_IMAGE)->isEmpty();
  }

  /**
   * Check if the article is a breaking news article.
   *
   * Example of encapsulating business logic around the terms. Example might be
   * styling needs to apply to the template based on if the page is breaking
   * news. The details of how the article is classified as breaking news is
   * hidden to the caller, and they don't need to be concerned with how it is
   * calculated.
   *
   * In the real world, this wouldn't be a safe check as its not multilingual and
   * relies on a term name, but shows how we can expose the business logic of something
   * without needed to deal with the internals of the content model.
   *
   * @return bool
   */
  public function isBreakingNews() {
    foreach ($this->getTagEntities() as $term) {
      if ($term->label() === 'Breaking news') {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * @return \Drupal\taxonomy\Entity\Term[]
   */
  protected function getTagEntities() {
    return $this->getEntity()->get(self::FIELD_TAGS)->referencedEntities();
  }
}
