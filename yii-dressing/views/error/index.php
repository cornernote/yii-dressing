<?php
/**
 * @var $this ErrorController
 * @var $errors array
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */
$this->pageTitle = $this->pageHeading = Yii::t('dressing', 'Errors');

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
        if ($auditId && is_numeric($auditId) && YdHelper::tableExists(YdAudit::model()->tableName())) {
            $audit = YdAudit::model()->findByPk($auditId);
            if ($audit) {
                $auditLink = $audit->getLink();
                $auditCreated = $audit->created;
                $auditCreated = Yii::app()->format->agoIcon($auditCreated);
                $auditRoute = str_replace(array(Yii::app()->request->baseUrl, $_SERVER['HTTP_HOST'], 'http://', 'https://'), '', $audit->link);
                $auditRoute = YdStringHelper::getFirstLineWithIcon($auditRoute, 60);
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