<?php
/**
 * YdDynamicMenu
 */
class YdDynamicMenu
{
    /**
     * @static
     * @param $item
     * @param string $menu
     */
    public static function add($item, $menu = 'menu')
    {
        $data = user()->getState($menu, array());
        $item['active'] = false;
        array_unshift($data, $item);
        while (count($data) > 20) array_pop($data);
        $labels = array();
        foreach ($data as $k => $v) {
            if (in_array($v['label'], $labels)) {
                unset($data[$k]);
                continue;
            }
            $labels[] = $v['label'];
        }
        user()->setState($menu, $data);
    }

    /**
     * @static
     * @param string $menu
     * @return array
     */
    public static function output($menu = 'menu')
    {
        $data = user()->getState($menu, array());
        if (empty($data)) return $data;
        return array(
            'class' => 'bootstrap.widgets.TbNav',
            'items' => array(
                array(
                    'label' => Yii::t('dressing', 'History'),
                    'items' => $data,
                ),
            ),
        );
    }

}
