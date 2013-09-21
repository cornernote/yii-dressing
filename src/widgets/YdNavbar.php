<?php
Yii::import('bootstrap.widgets.TbNavbar');

/**
 * Class Navbar
 */
class YdNavbar extends TbNavbar
{
    /**
     * @var array navigation items that cannot be collapsed.
     */
    public $constantItems = array();

    /**
     * Runs the widget.
     */
    public function run()
    {
        // fix bootstrap padding on top with responsive views
        if (Yii::app()->controller->showNavBar) {
            Yii::app()->clientScript->registerCSS('fix-navbar-body-padding', 'body{padding-top:60px;} @media (max-width: 979px){ body{padding-top:0;} }');
        }

        $this->htmlOptions['id'] = $this->id;
        $this->brandOptions['id'] = 'brand';

        $containerCssClass = $this->fluid ? 'container-fluid' : 'container';

        echo CHtml::openTag('div', $this->htmlOptions);
        echo '<div class="navbar-inner"><div class="' . trim($containerCssClass) . '">';

        if ($this->collapse) {
            echo '<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">';
            echo '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';
            echo '</a>';
        }

        foreach ($this->constantItems as $item) {
            if (is_string($item))
                echo $item;
            else {
                if (isset($item['class'])) {
                    $className = $item['class'];
                    unset($item['class']);

                    $this->controller->widget($className, $item);
                }
            }
        }

        if ($this->brand !== false)
            echo CHtml::openTag('a', $this->brandOptions) . $this->brand . '</a>';

        if ($this->collapse)
            echo '<div class="nav-collapse">';

        foreach ($this->items as $item) {
            if (is_string($item))
                echo $item;
            else {
                if (isset($item['class'])) {
                    $className = $item['class'];
                    unset($item['class']);

                    $this->controller->widget($className, $item);
                }
            }
        }

        if ($this->collapse)
            echo '</div>';

        echo '</div></div></div>';
    }
}
