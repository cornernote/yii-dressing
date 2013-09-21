<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 */

$auditTrail = new AuditTrail('search');
if (isset($_GET['AuditTrail'])) {
    $auditTrail->attributes = $_GET['AuditTrail'];
}
$auditTrail->model = get_class($model);
$auditTrail->model_id = $model->id;
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
