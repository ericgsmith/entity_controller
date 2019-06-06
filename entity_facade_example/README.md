# Entity Facade Example

Contains an example implementation of providing a facade for the article node.

## Usage

Access the example factory:

### Within a service

Use the `plugin.manager.entity_facade` service:

```php
$factory = \Drupal::service('plugin.manager.entity_facade')
```

Pass a node object to the factory:

```php
$article = $factory->getArticleFacade($node);
```
