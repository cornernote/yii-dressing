<?php
/**
 * @var $this YdAuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */

$auditTrail = new YdAuditTrail('search');
if (isset($_GET['YdAuditTrail'])) {
    $auditTrail->attributes = $_GET['YdAuditTrail'];
}
$auditTrail->model = get_class($model);
$auditTrail->model_id = is_array($model->getPrimaryKey()) ? implode('-', $model->getPrimaryKey()) : $model->getPrimaryKey();
$this->renderPartial('/auditTrail/_grid', array('auditTrail' => $auditTrail));
