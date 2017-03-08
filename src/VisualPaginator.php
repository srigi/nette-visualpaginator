<?php

/**
 * Nette Framework Extras
 *
 * This source file is subject to the New BSD License.
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 */

use Nette\Utils\Paginator;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;

/**
 * Visual paginator control.
 *
 * @author     David Grudl edit by Radek Frystak <geniv.radek@gmail.com>
 * @copyright  Copyright (c) 2009 David Grudl
 */
class VisualPaginator extends Control
{
    /** @var Paginator */
    private $paginator;

    /** @persistent */
    public $page = 1;

    /** @var ITranslator */
    private $translator;

    /** @var string path to template */
    private $pathTemplate;


    /**
     * VisualPaginator constructor.
     * @param ITranslator|null $translator
     */
    public function __construct(ITranslator $translator = null)
    {
        parent::__construct();

        $this->translator = $translator;
        $this->pathTemplate = __DIR__ . '/visualPaginator.latte';
    }


    /**
     * @return Paginator
     */
    public function getPaginator()
    {
        if (!$this->paginator) {
            $this->paginator = new Paginator;
        }
        return $this->paginator;
    }


    /**
     * nastaveni cesty template
     * @param $path
     * @return $this
     */
    public function setPathTemplate($path)
    {
        $this->pathTemplate = $path;
        return $this;
    }


    /**
     * Renders paginator.
     * @param array $options
     * @return void
     */
    public function render($options = NULL)
    {
        $paginator = $this->getPaginator();

        if (NULL !== $options) {
            $paginator->setItemCount($options['count']);
            $paginator->setItemsPerPage($options['perPage']);
        }

        $page = $paginator->page;

        if ($paginator->pageCount < 2) {
            $steps = array($page);
        } else {
            $arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
            $count = 4;
            $quotient = ($paginator->pageCount - 1) / $count;
            for ($i = 0; $i <= $count; $i++) {
                $arr[] = round($quotient * $i) + $paginator->firstPage;
            }
            sort($arr);
            $steps = array_values(array_unique($arr));
        }

        $this->template->steps = $steps;
        $this->template->paginator = $paginator;

        $this->template->setTranslator($this->translator);
        $this->template->setFile($this->pathTemplate);
        $this->template->render();
    }


    /**
     * Loads state informations.
     * @param  array
     * @return void
     */
    public function loadState(array $params)
    {
        parent::loadState($params);
        $this->getPaginator()->page = $this->page;
    }
}
