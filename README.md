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

```neon
- VisualPaginator
```

basic usage:
```php

use VisualPaginator;

...

/** @var VisualPaginator @inject */
public $visualPaginator;

public function renderDefault()
    // for dibi
    $items = $this->model->getList();

    $items = range(1, 150);

    $vp = $this->visualPaginator->getPaginator();
    $vp->setItemCount(count($items))
        ->setItemsPerPage(5);

    // for dibi
    $this->template->items = $items->limit($vp->getLength())->offset($vp->getOffset());

    // for array
    $this->template->items = array_slice($items, $vp->getOffset(), $vp->getLength())
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
    return $visualPaginator;
}
```

Calling it from templates

```latte
{control visualPaginator}

or 

{control visualPaginator, count=>200, perPage=>5}
```

## License

New BSD License

## Authors

- Davig Grudl
- Igor Hlina
- Radek Fryšták


[nette]: http://nette.org/
