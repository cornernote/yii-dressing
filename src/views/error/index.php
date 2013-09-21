<?php
/**
 * @var $this ErrorController
 * @var $errors array
 */
$this->pageTitle = Yii::t('dressing', 'Errors');
$this->pageHeading = Yii::t('dressing', 'Errors');

$this->breadcrumbs[Yii::t('dressing', 'Tools')] = array('/tool/index');
$this->breadcrumbs[] = Yii::t('dressing', 'Errors');
?>

<?php echo CHtml::link(Yii::t('dressing', 'Clear Errors'), array('/error/clear')); ?>

<table class="table table-bordered table-striped table-condensed">
    <tr>
        <td><?php echo Yii::t('dressing', 'Error'); ?></td>
        <td><?php echo Yii::t('dressing', 'Audit'); ?></td>
        <td><?php echo Yii::t('dressing', 'Route'); ?></td>
        <td><?php echo Yii::t('dressing', 'Date'); ?></td>
    </tr>
    <?php
    foreach ($errors as $error) {
        $auditCreated = date('Y-m-d H:i:s', filemtime(app()->getRuntimePath() . '/errors/' . $error));
        $auditId = str_replace(array('archive/', 'audit-', '.html'), '', $error);
        $auditLink = '';
        $auditRoute = '';
        $errorLink = array('/error/view', 'error' => $error);
        if (strpos($error, 'archive/') !== false) {
            $errorLink = array('/error/view', 'error' => str_replace('archive/', '', $error), 'archive' => 1);
        }
        if ($auditId && is_numeric($auditId) && Helper::tableExists(Yii::app()->dressing->tableMap['YdAudit'])) {
            $audit = Audit::model()->findByPk($auditId);
            if ($audit) {
                $auditLink = $audit->getLink();
                $auditCreated = $audit->created;
                $auditCreated = Time::agoIcon($auditCreated);
                $auditRoute = $audit->link;
                $auditRoute = str_replace(Yii::app()->request->baseUrl, '', $auditRoute);
                $auditRoute = str_replace($_SERVER['HTTP_HOST'], '', $auditRoute);
                $auditRoute = str_replace('http://', '', $auditRoute);
                $auditRoute = StringHelper::getFirstLineWithIcon($auditRoute, 60);
            }
        }
        ?>
        <tr>
            <td><?php echo CHtml::link($error, $errorLink); ?></td>
            <td><?php echo $auditLink; ?></td>
            <td><?php echo $auditRoute; ?></td>
            <td><?php echo $auditCreated; ?></td>
        </tr>
    <?php
    }
    ?>
</table>