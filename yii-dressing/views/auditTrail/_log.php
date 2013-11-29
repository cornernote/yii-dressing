<?php
/**
 * @var $this YdAuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$auditTrail = new YdAuditTrail('search');
if (isset($_GET['YdAuditTrail'])) {
    $auditTrail->attributes = $_GET['YdAuditTrail'];
}
$auditTrail->model = get_class($model);
$auditTrail->model_id = $model->id;
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
