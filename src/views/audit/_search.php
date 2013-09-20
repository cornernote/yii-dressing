<?php
// search button 
$this->menu[] = array(
    'label' => t('Search'),
    'url' => '#',
    'itemOptions' => array('class' => 'search-button'),
);

// search toggle
cs()->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('audit-grid', {
        url: $(this).attr('action'),
		data: $(this).serialize()
	});
	return false;
});
");