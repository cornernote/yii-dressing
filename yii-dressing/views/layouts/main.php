<?php
/**
 * @var $this YdWebController
 * @var $content
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @author Zain Ul abidin <zainengineer@gmail.com>
 * @copyright 2013 Mr PHP
 * @link https://github.com/cornernote/yii-skeleton
 * @license https://raw.github.com/cornernote/yii-dressing/master/license.txt
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="language" content="en"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body id="top" class="<?php echo $this->id . '-' . $this->action->id; ?>">

<?php echo $content; ?>

</body>
</html>