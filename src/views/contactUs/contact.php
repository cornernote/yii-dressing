<?php
/**
 * @var $this ContactUsController
 * @var $contactUs ContactUs
 */

$this->pageTitle = $this->pageHeading = $this->getName();

$this->breadcrumbs = array();



?>
<div id="body" class="container">
    <div class="row">

        <section class="span9">
            <?php
            $this->renderPartial('_form', array(
                'contactUs' => $contactUs,
            ));
            ?>
        </section>
        <aside class="span3" role="complementary">
            <div class="well">
                <a href="mailto:editor@newsmaker.com.au" title="Please send NewsMaker Services Guide">Email us</a> for more
                information, support or business enquiries, or
                <a href="http://www.slideshare.net/newsgal/press-release-services-guide-newsmaker" title="download the User Guide Presentation.">download
                    the User Guide Presentation</a>

                <p style="margin-bottom: 0in" class="western"><strong>Australia - National</strong> <br/>&nbsp;<br/>Head
                    Office:&nbsp;
                </p>+61 414 697071<br/>

                <p style="margin-bottom: 0in" class="western"><br/></p> <strong>Mail to:</strong> <br/><br/>PO Box 73 <br/>Highgate
                <br/>South Australia 5063 <br/>Australia
            </div>
        </aside>

    </div>
</div>
