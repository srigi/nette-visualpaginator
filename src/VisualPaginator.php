<?php

/**
 * Nette Framework Extras
 *
 * This source file is subject to the New BSD License.
 *
 * For more information please see http://addons.nette.org
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 * @link       http://addons.nette.org
 */


use Nette\Utils\Paginator;


/**
 * Visual paginator control.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2009 David Grudl
 * @extendet by: geniv
 */
class VisualPaginator extends Nette\Application\UI\Control
{
    /** @var Nette\Utils\Paginator */
    private $paginator;

    /** @persistent */
    public $page = 1;

    /**
     * @var Nette\Localization\ITranslator
     */
    private $translator;

    /**
     * @var string path to template
     */
    private $pathTemplate;


    /**
     * VisualPaginator constructor.
     * @param Nette\Localization\ITranslator $translator
     */
    public function __construct(Nette\Localization\ITranslator $translator)
    {
        $this->translator = $translator;
        $this->pathTemplate = __DIR__ . '/visualPaginator.latte';
    }


    /**
     * @return Nette\Utils\Paginator
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
            $paginator->setItemsPerPage($options['pageSize']);
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
