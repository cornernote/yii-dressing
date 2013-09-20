<div class="view">
    <?php echo LogFormatter::format($data->notes, $data->model); ?>
    <br/>
    <br/>
    <?php echo $data->created_by . ' ' . t('at') . ' ' . date(Setting::item('dateFormat'), strtotime($data->created)); ?>
</div>