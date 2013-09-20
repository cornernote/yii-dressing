<?php
/**
 * @var $this ErrorController
 * @var $errors array
 */
$this->pageTitle = t('Errors');
$this->pageHeading = t('Errors');
$this->breadcrumbs = array(t('Errors'));
?>

<?php echo l(t('Clear Errors'), array('/error/clear')); ?>

<table class="table table-bordered table-striped table-condensed">
    <tr>
        <td><?php echo t('Error'); ?></td>
        <td><?php echo t('Audit'); ?></td>
        <td><?php echo t('Route'); ?></td>
        <td><?php echo t('Date'); ?></td>
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
        if ($auditId && is_numeric($auditId) && Helper::tableExists('audit')) {
            $audit = Audit::model()->findByPk($auditId);
            if ($audit) {
                $auditLink = $audit->getLink();
                $auditCreated = $audit->created;
                $auditCreated = Time::agoIcon($auditCreated);
                $auditRoute = $audit->link;
                $auditRoute = str_replace(bu(), '', $auditRoute);
                $auditRoute = str_replace($_SERVER['HTTP_HOST'], '', $auditRoute);
                $auditRoute = str_replace('http://', '', $auditRoute);
                $auditRoute = StringHelper::getFirstLineWithIcon($auditRoute, 60);
            }
        }
        ?>
        <tr>
            <td><?php echo l($error, $errorLink); ?></td>
            <td><?php echo $auditLink; ?></td>
            <td><?php echo $auditRoute; ?></td>
            <td><?php echo $auditCreated; ?></td>
        </tr>
    <?php
    }
    ?>
</table>