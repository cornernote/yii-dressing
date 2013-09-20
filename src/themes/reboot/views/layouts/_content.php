<?php
/**
 * @var $this WebController
 * @var $content
 */

?>

<div id="holder">
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

    <?php
    if ($this->pageHeading) {
        ?>
        <div id="subheader">
            <div class="inner">
                <div class="container">
                    <h1><?php echo $this->pageHeading; ?></h1>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <div id="subpage">

        <div class="container">
            <?php
            if ($this->menu) {
                $this->widget('bootstrap.widgets.TbMenu', array(
                    'id' => 'menu',
                    'type' => 'tabs',
                    'items' => $this->menu,
                ));
            }
            if ($this->breadcrumbs) {
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'htmlOptions' => array(
                        'id' => 'breadcrumbs',
                    ),
                    'separator' => '',
                    'links' => $this->breadcrumbs,
                ));
            }
            echo user()->multiFlash();
            echo $content;
            ?>
        </div>

        <footer>


            <div id="extra">
                <div class="inner">
                    <div class="container">
                        <div class="row">

                            <div class="span4">

                                <h3><span class="slash">//</span> Quick Links</h3>


                                <ul class="footer-links clearfix">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="/site/page/view/features">Features</a></li>
                                    <li><a href="/site/page/view/plans">Plans</a></li>
                                </ul>

                                <ul class="footer-links clearfix">
                                    <li><a href="/site/page/view/about">About</a></li>
                                    <li><a href="/site/page/view/faq">FAQ</a></li>
                                    <li><a href="/site/contact">Contact</a></li>
                                </ul>

                            </div>
                            <!-- /span4 -->


                            <div class="span4">

                                <h3><span class="slash">//</span> Stay In Touch</h3>

                                <p>There are real people behind Zagazoo, so if you have a question or suggestion (no
                                    matter how
                                    small) please get in touch with us:</p>

                                <ul class="social-icons-container">

                                    <li>
                                        <a href="javascript:;" class="social-icon social-icon-twitter">
                                            Twitter
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:;" class="social-icon social-icon-googleplus">
                                            Google +
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript:;" class="social-icon social-icon-facebook">
                                            Facebook
                                        </a>
                                    </li>

                                </ul>
                                <!-- /extra-social -->

                            </div>
                            <!-- /span4 -->

                            <div class="span4">

                                <h3><span class="slash">//</span> Subscribe and get updates</h3>


                                <p>Subscribe to our newsletter and get exclusive deals you wont find anywhere else
                                    straight to
                                    your
                                    inbox!</p>


                                <form>

                                    <input type="text" name="subscribe_email" placeholder="Your Email">

                                    <br>

                                    <button class="btn ">Subscribe</button>
                                </form>


                            </div>
                            <!-- /span4 -->

                        </div>
                        <!-- /row -->
                    </div>
                    <!-- /container -->
                </div>
                <!-- /inner -->

            </div>


            <div id="footer">
                <div class="inner">
                    <div class="container">
                        <?php
                        echo '<p class="pull-right">' . l(t('Back to Top') . ' &uarr;', '#') . '</p>';
                        ?>
                    </div>
                </div>
            </div>

        </footer>
    </div>
</div>
