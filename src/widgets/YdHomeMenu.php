<?php

Yii::import('bootstrap.widgets.TbMenu');
/**
 * Class YdHomeMenu
 */
class YdHomeMenu extends TbMenu
{

    /**
     * Renders a single item in the menu.
     * @param array $item the item configuration
     * @return string the rendered item
     */
    protected function renderItem($item)
    {
        if (!isset($item['linkOptions']))
            $item['linkOptions'] = array();

        if (isset($item['linkOptions']['id']) && $item['linkOptions']['id'] === true) {
            $item['linkOptions']['id'] = 'homemenu-item-' . strtolower(preg_replace('/[^0-9a-z]/i', '', $item['label']));
        }

        if (isset($item['icon']))
            $item['label'] = '<span class="icon-home pull-left"><img src="' . au() . '/menu.white/' . $item['icon'] . '.png" width="25" height="25" /></span> <span class="menu-text">' . $item['label'] . '</span>';
        else
            $item['label'] = '<span class="menu-text">' . $item['label'] . '</span>';

        if (!isset($item['header']) && !isset($item['url']))
            $item['url'] = '#';

        if (isset($item['url']))
            return CHtml::link($item['label'], $item['url'], $item['linkOptions']);
        else
            return $item['label'];
    }


}