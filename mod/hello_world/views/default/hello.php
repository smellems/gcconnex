<?php

$params = array(
        'title' => 'Hello world!',
        'content' => 'This is my first plugin.',
        'filter' => '',
    );

$body = elgg_view_layout('content', $params);

    echo elgg_view_page('Hello', $body);