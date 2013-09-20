<?php
/**
 * @var $this WebController
 * @var $content string
 */
?>

<?php
$this->widget('widgets.Navbar', array(
    'id' => 'navbar',
    'fixed' => 'top',
    //'fluid' => true,
    'collapse' => true,
    'items' => Menu::topMenu(),
    'constantItems' => array(
        Menu::userMenu(),
    ),
));
?>

<div id="holder" class="content">
    <header>
        <?php if ($this->id == 'site' && $this->action->id == 'index') { ?>
            <div id="landing">
                <div class="container">
                    <div class="row">
                        <div class="span6">
                            <h1>Some Title</h1>
                            <br/>

                            <p>Great description!</p>
                            <br/><br/>

                            <p><?php echo l(t('Get Started Now'), array('/account/register'), array('class' => 'btn btn-primary btn-action', 'data-toggle' => 'modal-remote')); ?></p>
                        </div>
                        <div class="span6">
                            <iframe width="440" height="300" src="http://www.youtube.com/embed/vFaKs6OXMvk" frameborder="0" allowfullscreen class="pull-right"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($this->pageHeading) { ?>
            <div id="header">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <h1><?php echo $this->pageIcon ? '<i class="' . $this->pageIcon . '"></i> ' : ''; ?><?php echo $this->pageHeading; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </header>

    <div id="body" class="container">
        <?php
        if ($this->menu) {
            $this->widget('bootstrap.widgets.TbMenu', array(
                'id' => 'menu',
                'type' => 'tabs',
                'items' => $this->menu,
            ));
        }
        if ($this->breadcrumbs) {
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        }
        echo user()->multiFlash();
        echo $content;
        ?>
    </div>

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="span3">
                    <h3>Quick Links</h3>
                    <?php
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => Menu::getItemsFromMenu('Main'),
                        'htmlOptions' => array(
                            'id' => 'menu',
                        ),
                    ));
                    $this->widget('zii.widgets.CMenu', array(
                        'items' => Menu::getItemsFromMenu('Help'),
                        'htmlOptions' => array(
                            'id' => 'menu',
                        ),
                    ));
                    ?>
                </div>
                <div class="span3">
                    <h3>Company</h3>
                    <ul>
                        <li><?php echo l(t('Privacy Policy'), array('/site/page', 'view' => 'privacy')) ?></li>
                        <li><?php echo l(t('Terms of Use'), array('/site/page', 'view' => 'terms')) ?></li>
                    </ul>
                </div>
                <div class="span3">
                    <h3>We're Social</h3>
                    <ul>
                        <li><a target="_blank" href="#">Facebook</a></li>
                        <li><a target="_blank" href="#">Twitter</a></li>
                        <li><a target="_blank" href="#">Linked in</a></li>
                        <li><a target="_blank" href="#">YouTube</a></li>
                    </ul>
                </div>
                <div class="span3">
                    <h3>Subscribe</h3>

                    <p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>

                    <form action="#">
                        <input type="email" value="" placeholder="Your Email"/>
                        <button class="btn btn-primary">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>


        <div id="copywrite">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <p><?php echo '&copy; ' . date('Y') . ' ' . app()->name; ?>

                            <span <?php echo YII_DEBUG ? '' : 'style="color: #394755;"'; ?>>
                            <?php $this->renderPartial('/audit/_footer'); ?>
                        </span>
                        <span id="totop" class="pull-right"><a href="#">Back to Top
                                <i class="icon-arrow-up"></i></a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</div>
