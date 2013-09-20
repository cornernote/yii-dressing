<?php
$auditTrail = new AuditTrail('search');
if (isset($_GET['AuditTrail'])) {
    $auditTrail->attributes = $_GET['AuditTrail'];
}
$auditTrail->model = get_class($model);
$auditTrail->model_id = $model->id;
$this->renderPartial('/auditTrail/_grid', array('auditTrail' => $auditTrail));
?>