<?php

/**
 * Blog post meta boxes and helpers for agency educational content.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_post_article_type_labels')) {
  function romonet_get_post_article_type_labels()
  {
    return array(
      'tutorial'  => __('Tutorial', 'romonet'),
      'guide'     => __('Guide', 'romonet'),
      'insight'   => __('Agency Insight', 'romonet'),
      'checklist' => __('Checklist', 'romonet'),
      'news'      => __('Industry News', 'romonet'),
    );
  }
}

if (! function_exists('romonet_get_post_difficulty_labels')) {
  function romonet_get_post_difficulty_labels()
  {
    return array(
      'beginner'     => __('Beginner', 'romonet'),
      'intermediate' => __('Intermediate', 'romonet'),
      'advanced'     => __('Advanced', 'romonet'),
    );
  }
}

if (! function_exists('romonet_get_post_meta_fields')) {
  function romonet_get_post_meta_fields()
  {
    return array(
      '_romonet_post_article_type' => array(
        'label'       => __('Article type', 'romonet'),
        'type'        => 'select',
        'description' => __('Helps readers find the right content format.', 'romonet'),
        'options'     => array_merge(
          array('' => __('Select a type', 'romonet')),
          romonet_get_post_article_type_labels()
        ),
      ),
      '_romonet_post_difficulty' => array(
        'label'       => __('Difficulty level', 'romonet'),
        'type'        => 'select',
        'description' => __('Technical depth of the article.', 'romonet'),
        'options'     => array_merge(
          array('' => __('Select a level', 'romonet')),
          romonet_get_post_difficulty_labels()
        ),
      ),
      '_romonet_post_reading_time' => array(
        'label'       => __('Reading time (minutes)', 'romonet'),
        'type'        => 'text',
        'description' => __('Leave empty to auto-calculate from content.', 'romonet'),
      ),
      '_romonet_post_audience' => array(
        'label'       => __('Target audience', 'romonet'),
        'type'        => 'text',
        'description' => __('Example: Business owners, marketing teams, developers.', 'romonet'),
      ),
      '_romonet_post_author_title' => array(
        'label'       => __('Author role / title', 'romonet'),
        'type'        => 'text',
        'description' => __('Example: Lead WordPress Developer.', 'romonet'),
      ),
      '_romonet_post_key_takeaways' => array(
        'label'       => __('Key takeaways', 'romonet'),
        'type'        => 'textarea',
        'description' => __('One actionable insight per line.', 'romonet'),
      ),
      '_romonet_post_prerequisites' => array(
        'label'       => __('Prerequisites', 'romonet'),
        'type'        => 'textarea',
        'description' => __('What the reader should know before starting (one item per line).', 'romonet'),
      ),
      '_romonet_post_technologies' => array(
        'label'       => __('Tools & technologies', 'romonet'),
        'type'        => 'textarea',
        'description' => __('One technology or tool per line (WordPress, WooCommerce, SEO, etc).', 'romonet'),
      ),
      '_romonet_post_related_url' => array(
        'label'       => __('Related resource URL', 'romonet'),
        'type'        => 'url',
        'description' => __('Optional link to a demo, docs page, or external reference.', 'romonet'),
      ),
      '_romonet_post_related_url_label' => array(
        'label'       => __('Related resource label', 'romonet'),
        'type'        => 'text',
        'description' => __('Button text for the related resource link.', 'romonet'),
      ),
    );
  }
}

if (! function_exists('romonet_parse_post_meta_lines')) {
  function romonet_parse_post_meta_lines($raw)
  {
    return array_values(
      array_filter(
        array_map(
          'trim',
          preg_split('/\r\n|\r|\n/', (string) $raw)
        )
      )
    );
  }
}

if (! function_exists('romonet_get_post_reading_time')) {
  function romonet_get_post_reading_time($post_id = 0)
  {
    $post_id = $post_id ? absint($post_id) : get_the_ID();
    $stored  = get_post_meta($post_id, '_romonet_post_reading_time', true);

    if ('' !== $stored && is_numeric($stored)) {
      return max(1, absint($stored));
    }

    $post = get_post($post_id);
    if (! $post) {
      return 1;
    }

    $content = wp_strip_all_tags($post->post_content . ' ' . $post->post_excerpt);
    $words   = str_word_count($content);

    return max(1, (int) ceil($words / 180));
  }
}

if (! function_exists('romonet_get_post_meta_bundle')) {
  function romonet_get_post_meta_bundle($post_id = 0)
  {
    $post_id = $post_id ? absint($post_id) : get_the_ID();
    $types   = romonet_get_post_article_type_labels();
    $levels  = romonet_get_post_difficulty_labels();

    $article_type = get_post_meta($post_id, '_romonet_post_article_type', true);
    $difficulty   = get_post_meta($post_id, '_romonet_post_difficulty', true);

    return array(
      'article_type'       => $article_type,
      'article_type_label' => isset($types[$article_type]) ? $types[$article_type] : '',
      'difficulty'         => $difficulty,
      'difficulty_label'   => isset($levels[$difficulty]) ? $levels[$difficulty] : '',
      'reading_time'       => romonet_get_post_reading_time($post_id),
      'audience'           => get_post_meta($post_id, '_romonet_post_audience', true),
      'author_title'       => get_post_meta($post_id, '_romonet_post_author_title', true),
      'key_takeaways'      => romonet_parse_post_meta_lines(get_post_meta($post_id, '_romonet_post_key_takeaways', true)),
      'prerequisites'      => romonet_parse_post_meta_lines(get_post_meta($post_id, '_romonet_post_prerequisites', true)),
      'technologies'       => romonet_parse_post_meta_lines(get_post_meta($post_id, '_romonet_post_technologies', true)),
      'related_url'        => get_post_meta($post_id, '_romonet_post_related_url', true),
      'related_url_label'  => get_post_meta($post_id, '_romonet_post_related_url_label', true),
    );
  }
}

if (! function_exists('romonet_get_related_posts')) {
  function romonet_get_related_posts($post_id = 0, $count = 3)
  {
    $post_id = $post_id ? absint($post_id) : get_the_ID();
    $count   = max(1, absint($count));
    $categories = wp_get_post_categories($post_id);

    $query_args = array(
      'post_type'           => 'post',
      'post_status'         => 'publish',
      'posts_per_page'      => $count,
      'post__not_in'        => array($post_id),
      'ignore_sticky_posts' => true,
      'no_found_rows'       => true,
    );

    if (! empty($categories)) {
      $query_args['category__in'] = $categories;
    }

    return new WP_Query($query_args);
  }
}

if (! function_exists('romonet_add_post_meta_box')) {
  function romonet_add_post_meta_box()
  {
    add_meta_box(
      'romonet_post_meta_box',
      __('Blog Article Details', 'romonet'),
      'romonet_render_post_meta_box',
      'post',
      'normal',
      'high'
    );
  }
}
add_action('add_meta_boxes', 'romonet_add_post_meta_box');

if (! function_exists('romonet_render_post_meta_box')) {
  function romonet_render_post_meta_box($post)
  {
    $fields = romonet_get_post_meta_fields();

    wp_nonce_field('romonet_save_post_meta', 'romonet_post_meta_nonce');

    echo '<table class="form-table" role="presentation"><tbody>';

    foreach ($fields as $meta_key => $field) {
      $field_id = sanitize_html_class($meta_key);
      $value    = get_post_meta($post->ID, $meta_key, true);

      echo '<tr>';
      echo '<th scope="row"><label for="' . esc_attr($field_id) . '">' . esc_html($field['label']) . '</label></th>';
      echo '<td>';

      if ('textarea' === $field['type']) {
        echo '<textarea class="widefat" rows="4" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '">' . esc_textarea($value) . '</textarea>';
      } elseif ('select' === $field['type']) {
        $options = isset($field['options']) && is_array($field['options']) ? $field['options'] : array();
        echo '<select class="widefat" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '">';
        foreach ($options as $option_value => $option_label) {
          echo '<option value="' . esc_attr($option_value) . '" ' . selected($value, $option_value, false) . '>' . esc_html($option_label) . '</option>';
        }
        echo '</select>';
      } else {
        $input_type = in_array($field['type'], array('text', 'url'), true) ? $field['type'] : 'text';
        echo '<input class="widefat" type="' . esc_attr($input_type) . '" id="' . esc_attr($field_id) . '" name="' . esc_attr($meta_key) . '" value="' . esc_attr($value) . '" />';
      }

      if (! empty($field['description'])) {
        echo '<p class="description">' . esc_html($field['description']) . '</p>';
      }

      echo '</td>';
      echo '</tr>';
    }

    echo '</tbody></table>';
  }
}

if (! function_exists('romonet_save_post_meta_box')) {
  function romonet_save_post_meta_box($post_id, $post)
  {
    if (! isset($_POST['romonet_post_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['romonet_post_meta_nonce'])), 'romonet_save_post_meta')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if (! $post || 'post' !== $post->post_type) {
      return;
    }

    if (! current_user_can('edit_post', $post_id)) {
      return;
    }

    if (wp_is_post_revision($post_id)) {
      return;
    }

    $fields = romonet_get_post_meta_fields();
    $url_fields = array(
      '_romonet_post_related_url',
    );
    $textarea_fields = array(
      '_romonet_post_key_takeaways',
      '_romonet_post_prerequisites',
      '_romonet_post_technologies',
    );
    $allowed_types = array_keys(romonet_get_post_article_type_labels());
    $allowed_levels = array_keys(romonet_get_post_difficulty_labels());

    foreach ($fields as $meta_key => $field) {
      $raw_value = isset($_POST[$meta_key]) ? wp_unslash($_POST[$meta_key]) : '';
      $value     = '';

      if (in_array($meta_key, $url_fields, true)) {
        $value = esc_url_raw($raw_value);
      } elseif (in_array($meta_key, $textarea_fields, true)) {
        $value = sanitize_textarea_field($raw_value);
      } elseif ('_romonet_post_article_type' === $meta_key) {
        $type_value = sanitize_key($raw_value);
        $value      = in_array($type_value, $allowed_types, true) ? $type_value : '';
      } elseif ('_romonet_post_difficulty' === $meta_key) {
        $level_value = sanitize_key($raw_value);
        $value       = in_array($level_value, $allowed_levels, true) ? $level_value : '';
      } elseif ('_romonet_post_reading_time' === $meta_key) {
        $value = is_numeric($raw_value) ? absint($raw_value) : '';
      } else {
        $value = sanitize_text_field($raw_value);
      }

      if ('' === $value) {
        delete_post_meta($post_id, $meta_key);
      } else {
        update_post_meta($post_id, $meta_key, $value);
      }
    }
  }
}
add_action('save_post_post', 'romonet_save_post_meta_box', 10, 2);

if (! function_exists('romonet_render_comment')) {
  function romonet_render_comment($comment, $args, $depth)
  {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo esc_attr($tag); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('rounded-3xl border border-slate-200 bg-slate-50 p-5 sm:p-6', $comment); ?>>
      <article class="flex gap-4">
        <div class="shrink-0">
          <?php echo get_avatar($comment, 48, '', '', array('class' => 'rounded-full')); ?>
        </div>
        <div class="min-w-0 flex-1">
          <header class="flex flex-wrap items-center gap-x-3 gap-y-1">
            <strong class="text-sm font-semibold text-slate-900"><?php comment_author(); ?></strong>
            <time datetime="<?php comment_time('c'); ?>" class="text-xs text-slate-500"><?php printf(esc_html__('%1$s at %2$s', 'romonet'), get_comment_date(), get_comment_time()); ?></time>
          </header>
          <?php if ('0' === $comment->comment_approved) : ?>
            <p class="mt-2 text-sm text-pink-700"><?php esc_html_e('Your comment is awaiting moderation.', 'romonet'); ?></p>
          <?php endif; ?>
          <div class="mt-3 text-sm leading-7 text-slate-700"><?php comment_text(); ?></div>
          <?php
          comment_reply_link(
            array_merge(
              $args,
              array(
                'depth'      => $depth,
                'max_depth'  => $args['max_depth'],
                'reply_text' => esc_html__('Reply', 'romonet'),
                'before'     => '<div class="mt-3 text-sm font-semibold text-pink-600">',
                'after'      => '</div>',
              )
            )
          );
          ?>
        </div>
      </article>
    </<?php echo esc_attr($tag); ?>>
    <?php
  }
}
