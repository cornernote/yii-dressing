<?php

Yii::import('bootstrap.widgets.TbPager');

/**
 * YdPager
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license BSD-3-Clause https://raw.github.com/cornernote/yii-dressing/master/license.txt
 *
 * @package dressing.widgets
 */
class YdPager extends TbPager
{

    /**
     * @var bool
     */
    public $displayFirstAndLast = false;

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageLinks()
    {
        if (($pageCount = $this->getPageCount()) <= 0) {
            return array();
        }

        list ($beginPage, $endPage) = $this->getPageRange();

        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()

        $buttons = array();

        // first page
        if ($this->displayFirstAndLast) {
            $buttons[] = $this->createPageButton($this->firstPageLabel, 0, 'first', $currentPage <= 0, false);
        }

        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }

        $buttons[] = $this->createPageButton($this->prevPageLabel, $page, 'previous', $currentPage <= 0, false);

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->createPageButton($i + 1, $i, '', false, $i == $currentPage);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }

        $buttons[] = $this->createPageButton(
            $this->nextPageLabel,
            $page,
            'next',
            $currentPage >= ($pageCount - 1),
            false
        );

        // last page
        if ($this->displayFirstAndLast) {
            $buttons[] = $this->createPageButton(
                $this->lastPageLabel,
                $pageCount - 1,
                'last',
                $currentPage >= ($pageCount - 1),
                false
            );
        }

        return $buttons;
    }

}