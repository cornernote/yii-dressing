<?php
/**
 * @var $this AuditController
 * @var $audit YdAudit
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
$this->pageTitle = $audit->getName();

$this->renderPartial('/audit/_menu', array(
    'audit' => $audit,
));

$attributes = array();
$attributes[] = array(
    'name' => 'id',
    'value' => ' audit-' . $audit->id,
);
$attributes[] = array(
    'name' => 'link',
    'value' => CHtml::link(urldecode($audit->link), urldecode($audit->link)),
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'referrer',
    'value' => CHtml::link(urldecode($audit->referrer), urldecode($audit->referrer)),
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'redirect',
    'value' => CHtml::link(urldecode($audit->redirect), urldecode($audit->redirect)),
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'created',
    'value' => $audit->created,
    'type' => 'raw',
);
$attributes[] = array(
    'name' => 'total_time',
);
$attributes[] = array(
    'name' => 'memory_usage',
    'value' => number_format($audit->memory_usage, 0),
);
$attributes[] = array(
    'name' => 'memory_peak',
    'value' => number_format($audit->memory_peak, 0),
);
$attributes[] = array(
    'name' => 'ip',
);
$attributes[] = array(
    'name' => 'user_id',
    'label' => 'user',
    'type' => 'raw',
    'value' => $audit->user ? $audit->link : null,
);
$attributes[] = array(
    'name' => 'preserve',
    'value' => $audit->preserve ? Yii::t('dressing', 'This audit is Preserved.') . ' - ' . CHtml::link('Remove Preserve', array('/audit/preserve', 'id' => $audit->id, 'status' => 0))
            : CHtml::link('Preserve Values', array('/audit/preserve', 'id' => $audit->id, 'status' => 1)),
    'type' => 'raw',
);
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $audit,
    'attributes' => $attributes,
));

echo '<h2>' . Yii::t('dressing', 'Audit Trail') . '</h2>';
$auditTrail = new YdAuditTrail('search');
if (isset($_GET['YdAuditTrail'])) {
    $auditTrail->attributes = $_GET['YdAuditTrail'];
}
$auditTrail->audit_id = $audit->id;
$this->renderPartial('/auditTrail/_grid', array(
    'auditTrail' => $auditTrail,
));


echo '<h2>' . Yii::t('dressing', 'Version Settings') . '</h2>';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $audit,
    'attributes' => array(
        array(
            'name' => 'app_version',
        ),
        array(
            'name' => 'yii_version',
        ),
    ),
));


echo '<h2>' . Yii::t('dressing', 'Page Variables') . '</h2>';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $audit,
    'attributes' => array(
        array(
            'label' => '$_GET',
            'value' => '<pre>' . print_r($audit->unpack('get'), true) . '</pre>',
            'type' => 'raw',
        ),
        array(
            'label' => '$_POST',
            'value' => '<pre>' . print_r($audit->unpack('post'), true) . '</pre>',
            'type' => 'raw',
        ),
        array(
            'label' => '$_FILES',
            'value' => '<pre>' . print_r($audit->unpack('files'), true) . '</pre>',
            'type' => 'raw',
        ),
    ),
));

echo '<h2>' . Yii::t('dressing', 'Session and Cookies') . '</h2>';
echo '<a href="javascript:void(0)" onclick="$(\'#show_session_detail\').show(\'slow\');$(\'#show_session\').hide();" id="show_session">Show</a>';
echo '<div id="show_session_detail" style="display: none;">';
echo '<a href="javascript:void(0)" onclick="$(\'#show_session_detail\').hide(\'hide\');$(\'#show_session\').show();">Hide</a>';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $audit,
    'attributes' => array(
        array(
            'label' => '$_SESSION',
            'value' => '<pre>' . print_r($audit->unpack('session'), true) . '</pre>',
            'type' => 'raw',
        ),
        array(
            'label' => '$_COOKIE',
            'value' => '<pre>' . print_r($audit->unpack('cookie'), true) . '</pre>',
            'type' => 'raw',
        ),
    ),
));
echo '</div>';

echo '<h2>' . Yii::t('dressing', 'Server Data') . '</h2>';
echo '<a href="javascript:void(0)" onclick="$(\'#show_server_detail\').show(\'slow\');$(\'#show_server\').hide();" id="show_server">Show</a>';
echo '<div id="show_server_detail" style="display: none;">';
echo '<a href="javascript:void(0)" onclick="$(\'#show_server_detail\').hide(\'hide\');$(\'#show_server\').show();">Hide</a>';
$this->widget('dressing.widgets.YdDetailView', array(
    'data' => $audit,
    'attributes' => array(
        array(
            'label' => '$_SERVER',
            'value' => '<pre>' . print_r($audit->unpack('server'), true) . '</pre>',
            'type' => 'raw',
        ),
    ),
));
echo '</div>';


if ($audit->error) {
    echo '<h2>' . Yii::t('dressing', 'Error') . ($audit->error_code ? '-' . $audit->error_code : '') . '</h2>';
    echo '<a href="javascript:void(0)" onclick="$(\'#show_error_detail\').show(\'slow\');$(\'#show_error\').hide();" id="show_error">Show</a>';
    echo '<div id="show_error_detail" style="display: none;">';
    echo '<a href="javascript:void(0)" onclick="$(\'#show_error_detail\').hide(\'hide\');$(\'#show_error\').show();">Hide</a>';
    $contents = $audit->unpack('error');
    $contents = str_replace('class="container"', 'class="container-fluid"', $contents);
    if (strpos($contents, '<body>')) {
        $contents = StringHelper::getBetweenString($contents, '<body>', '</body>');
        Yii::app()->clientScript->registerCss('error', file_get_contents(dirname($this->getViewFile('/error/index')) . '/view.css'));
    }
    else {
        $contents = '<pre>' . $contents . '</pre>';
    }
    echo $contents;
    echo '</div>';
}