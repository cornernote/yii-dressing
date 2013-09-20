<?php
/**
 * @var $this WebController
 * @var $content
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="language" content="en"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $this->renderPartial('//layouts/_scripts');
    ?>
</head>
<body id="top" class="<?php echo $this->id . '-' . $this->action->id; ?>">

<?php
echo $content;
?>

</body>
</html>