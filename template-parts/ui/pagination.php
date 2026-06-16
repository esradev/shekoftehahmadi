<?php

if (! defined('ABSPATH')) {
  exit;
}

the_posts_pagination(
  array(
    'mid_size'           => 1,
    'prev_text'          => 'قبلی',
    'next_text'          => 'بعدی',
    'screen_reader_text' => 'صفحه‌بندی',
  )
);
