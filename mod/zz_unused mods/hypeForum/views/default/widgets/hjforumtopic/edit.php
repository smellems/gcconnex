<?php
$widget = $vars['entity'];
if ($widget->section == 'default') {
    $widget->section = 'hjforumtopic';
}


$title_label = elgg_echo('hj:forum:widget:title');
$title_input = elgg_view('input/text', array(
        'name' => 'params[title]',
        'value' => $vars['entity']->title
        ));

$options = <<<HTML
    <div>
        <span>$title_label</span><br />
        <span>$title_input</span>
    </div>

HTML;

echo $options;
