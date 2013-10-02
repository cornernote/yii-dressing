<?php
/**
 * @var $this AuditTrailController
 * @var $auditTrail YdAuditTrail
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Brett O'Donnell <cornernote@gmail.com>, Zain Ul abidin <zainengineer@gmail.com>
 * @link https://github.com/cornernote/yii-dressing
 * @license http://www.gnu.org/copyleft/gpl.html
 */

$auditTrail = new AuditTrail('search');
if (isset($_GET['AuditTrail'])) {
    $auditTrail->attributes = $_GET['AuditTrail'];
}
$auditTrail->model = get_class($model);
$auditTrail->model_id = $model->id;
$this->renderPartial('dressing.views.auditTrail._grid', array('auditTrail' => $auditTrail));
