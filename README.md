# VisualPaginator

VisualPaginator is a component for the [Nette Framework][nette], that
provides comfortable way to render pagination component on long listings.

Installation
------------
The best way to install this component is throught [Composer](http://getcomposer.org/).


```sh
$ composer require geniv/nette-visualpaginator
```

composer.json:
```json
  "geniv/nette-visualpaginator": ">=1.0",
```

Using
-----

basic usage:
```php

use VisualPaginator;

...

/** @var VisualPaginator @inject */
public $visualPaginator;

public function renderDefault()
    $items = $this->model->getList();
    
    $vp = $this->visualPaginator->getPaginator();
    $vp->setItemCount(count($items->fetchAll()))
        ->setItemsPerPage(5);

    $this->template->items = $items
        ->limit($vp->getLength())
        ->offset($vp->getOffset());
}

protected function createComponentVisualPaginator()
{
    return $this->visualPaginator;
}
```

advance usage:
```php
protected function createComponentVisualPaginator()
{
    return $this->visualPaginator
        ->setPathTemplate(__DIR__ . '/templates/pagination.latte');
}
```

or use with Autowire (eg. geniv/autowired)

```php
use AutowireComponentFactories;
use VisualPaginator;

protected function createComponentVisualPaginator(VisualPaginator $visualPaginator)
{
    return $this->visualPaginator
        ->setPathTemplate(__DIR__ . '/templates/pagination.latte');
}
```

Calling it from templates

```latte
{control visualPaginator}
```

## License

New BSD License

## Authors

- Davig Grudl
- Igor Hlina
- Radek Fryšták


[nette]: http://nette.org/
