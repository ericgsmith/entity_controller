# Entity Facade

> The primary goal of a Facade Pattern is not to avoid you having to read the manual of a complex API. It’s only a side-effect. The first goal is to reduce coupling and follow the Law of Demeter.

This provides an opinionated way to interact with content entities and govern the way they are used in your application.

The module provides a plugin type for entity facades. Entity facade plugins can be cover whole entity types, or specific bundles, to provide a point of entry to interact with the data and encapsulate any business logic around the entity.

The intent is that entities can be interacted with, such as in the theme layer, without the need for all areas of your code knowing your business logic, field and data structure, and dependencies to that logic.

## Background

In Drupal 8 there is [no easy way to subclass entities](https://www.drupal.org/project/drupal/issues/2570593). 

Using the `Node` entity as an example, the `\Drupal\node\Node` object provides a mix of methods to provide business logic (e.g isPromoted, isSticky) and ways to interact with the underlying structure of the node (field getters and setters).

Our application code can benefit from similar patters, hiding the data / implementation of business logic behind a facade that is easier to interact with.

## Example

We have an article content type, with the field field_tags.

One of the tags is a term 'Breaking News' - when an article is tagged as breaking news
we want to make some modification to the display of this article.

Without a facade, we would need to repeat the follow logic in the theme layer / wherever we are needed to check if an article is breaking news.

```php

foreach ($node->get('field_tags')->referencedEntities() as $term) {
      if ($term->label() === 'Breaking news') {
        // Do something...
      }
}
```

This has a few drawbacks - mainly the duplication of code, and using the magic string for the field accessor.

If we ever need to change the logic around if an article is breaking news, we have to search everywhere in our code for this check.

With a facade, we encapsulate this logic in the plugin class, and can instead call
```php
$article->isBreakingNews()
```

## Usage

The `entity_facade_example` shows how a this module can be used on a project.

This is based on a child module 
- providing plugins for the entity / bundle types they want to manage
- providing a factory to access the plugins (optional)

## Credit
- [CW Tool](https://github.com/cameronandwilding/cwtool) / [Peter Arato](https://github.com/itarato) for idea of wrapping native Drupal objects with business logic controllers, even if I may have butchered the idea :)
