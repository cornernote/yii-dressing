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
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageLinks()
    {
        if (($pageCount = $this->getPageCount()) <= 0) {
            return array();
        }

        list($beginPage, $endPage) = $this->getPageRange();

        $currentPage = $this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $links = array();

        // first page
        if (!$this->hideFirstAndLast) {
            $links[] = $this->createPageLink($this->firstPageLabel, 0, $currentPage <= 0, false);
        }

        // prev page
        if (($page = $currentPage - 1) < 0) {
            $page = 0;
        }

        $links[] = $this->createPageLink($this->prevPageLabel, $page, $currentPage <= 0, false);

        // internal pages
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $links[] = $this->createPageLink($i + 1, $i, false, $i == $currentPage);
        }

        // next page
        if (($page = $currentPage + 1) >= $pageCount - 1) {
            $page = $pageCount - 1;
        }

        $links[] = $this->createPageLink($this->nextPageLabel, $page, $currentPage >= $pageCount - 1, false);

        // last page
        if (!$this->hideFirstAndLast) {
            $links[] = $this->createPageLink(
                $this->lastPageLabel,
                $pageCount - 1,
                $currentPage >= $pageCount - 1,
                false
            );
        }

        return $links;
    }

}