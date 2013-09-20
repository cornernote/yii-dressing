<?php
/**
 * @var $this WebController
 */

// google analytics
$this->beginWidget('widgets.JavaScriptWidget', array('position' => CClientScript::POS_END));
?>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo Setting::item('google_analytics_id'); ?>']);
    _gaq.push(['_setDomainName', '<?php echo Setting::item('google_analytics_domain'); ?>']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_trackPageview']);

    (function () {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();

</script><?php
$this->endWidget();
