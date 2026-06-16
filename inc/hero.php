<?php

/**
 * Page hero meta box and helpers.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_page_hero_meta')) {
  function romonet_get_page_hero_meta($post_id = null)
  {
    if (! $post_id) {
      $post_id = get_the_ID();
    }

    if (! $post_id) {
      return array();
    }

    $meta = array(
      'badge' => get_post_meta($post_id, 'romonet_page_hero_badge', true),
      'title' => get_post_meta($post_id, 'romonet_page_hero_title', true),
      'description' => get_post_meta($post_id, 'romonet_page_hero_description', true),
      'primary' => get_post_meta($post_id, 'romonet_page_hero_primary', true),
      'primary_url' => get_post_meta($post_id, 'romonet_page_hero_primary_url', true),
      'secondary' => get_post_meta($post_id, 'romonet_page_hero_secondary', true),
      'secondary_url' => get_post_meta($post_id, 'romonet_page_hero_secondary_url', true),
      'show_breadcrumbs' => get_post_meta($post_id, 'romonet_page_hero_show_breadcrumbs', true),
    );

    if ($meta['description']) {
      $meta['description'] = sanitize_textarea_field($meta['description']);
    }

    $meta['badge'] = $meta['badge'] ? sanitize_text_field($meta['badge']) : '';
    $meta['title'] = $meta['title'] ? sanitize_text_field($meta['title']) : '';
    $meta['primary'] = $meta['primary'] ? sanitize_text_field($meta['primary']) : '';
    $meta['secondary'] = $meta['secondary'] ? sanitize_text_field($meta['secondary']) : '';
    $meta['primary_url'] = $meta['primary_url'] ? esc_url_raw($meta['primary_url']) : '';
    $meta['secondary_url'] = $meta['secondary_url'] ? esc_url_raw($meta['secondary_url']) : '';
    $meta['show_breadcrumbs'] = $meta['show_breadcrumbs'] === '0' ? false : true;

    return $meta;
  }
}

if (! function_exists('romonet_merge_page_hero_args')) {
  function romonet_merge_page_hero_args(array $args = array())
  {
    if (! is_singular()) {
      return $args;
    }

    $page_meta = romonet_get_page_hero_meta(get_the_ID());

    foreach ($page_meta as $key => $value) {
      if ($value !== '') {
        $args[$key] = $value;
      }
    }

    return $args;
  }
}

if (! function_exists('romonet_add_page_hero_meta_boxes')) {
  function romonet_add_page_hero_meta_boxes()
  {
    add_meta_box(
      'romonet-page-hero',
      __('Hero Section', 'romonet'),
      'romonet_render_page_hero_meta_box',
      array('page'),
      'normal',
      'high'
    );
  }
}
add_action('add_meta_boxes', 'romonet_add_page_hero_meta_boxes');

if (! function_exists('romonet_render_page_hero_meta_box')) {
  function romonet_render_page_hero_meta_box($post)
  {
    wp_nonce_field('romonet_page_hero_meta', 'romonet_page_hero_meta_nonce');

    $hero_meta = romonet_get_page_hero_meta($post->ID);
    $badge = isset($hero_meta['badge']) ? $hero_meta['badge'] : '';
    $title = isset($hero_meta['title']) ? $hero_meta['title'] : '';
    $description = isset($hero_meta['description']) ? $hero_meta['description'] : '';
    $primary = isset($hero_meta['primary']) ? $hero_meta['primary'] : '';
    $primary_url = isset($hero_meta['primary_url']) ? $hero_meta['primary_url'] : '';
    $secondary = isset($hero_meta['secondary']) ? $hero_meta['secondary'] : '';
    $secondary_url = isset($hero_meta['secondary_url']) ? $hero_meta['secondary_url'] : '';
    $show_breadcrumbs = isset($hero_meta['show_breadcrumbs']) ? $hero_meta['show_breadcrumbs'] : true;
?>
    <div class="romonet-meta-box-grid" style="display:grid; gap:1rem;">
      <p>
        <label for="romonet_page_hero_badge"><strong><?php esc_html_e('Badge', 'romonet'); ?></strong></label><br>
        <input type="text" id="romonet_page_hero_badge" name="romonet_page_hero_badge" value="<?php echo esc_attr($badge); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_title"><strong><?php esc_html_e('Title', 'romonet'); ?></strong></label><br>
        <input type="text" id="romonet_page_hero_title" name="romonet_page_hero_title" value="<?php echo esc_attr($title); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_description"><strong><?php esc_html_e('Description', 'romonet'); ?></strong></label><br>
        <textarea id="romonet_page_hero_description" name="romonet_page_hero_description" rows="4" class="widefat"><?php echo esc_textarea($description); ?></textarea>
      </p>
      <p>
        <label for="romonet_page_hero_primary"><strong><?php esc_html_e('Primary button label', 'romonet'); ?></strong></label><br>
        <input type="text" id="romonet_page_hero_primary" name="romonet_page_hero_primary" value="<?php echo esc_attr($primary); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_primary_url"><strong><?php esc_html_e('Primary button URL', 'romonet'); ?></strong></label><br>
        <input type="url" id="romonet_page_hero_primary_url" name="romonet_page_hero_primary_url" value="<?php echo esc_attr($primary_url); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_secondary"><strong><?php esc_html_e('Secondary button label', 'romonet'); ?></strong></label><br>
        <input type="text" id="romonet_page_hero_secondary" name="romonet_page_hero_secondary" value="<?php echo esc_attr($secondary); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_secondary_url"><strong><?php esc_html_e('Secondary button URL', 'romonet'); ?></strong></label><br>
        <input type="url" id="romonet_page_hero_secondary_url" name="romonet_page_hero_secondary_url" value="<?php echo esc_attr($secondary_url); ?>" class="widefat">
      </p>
      <p>
        <label for="romonet_page_hero_show_breadcrumbs"><strong><?php esc_html_e('Show breadcrumbs', 'romonet'); ?></strong></label><br>
        <input type="checkbox" id="romonet_page_hero_show_breadcrumbs" name="romonet_page_hero_show_breadcrumbs" value="1" <?php checked($show_breadcrumbs, true); ?>>
      </p>
    </div>
<?php
  }
}

if (! function_exists('romonet_save_page_hero_meta_box')) {
  function romonet_save_page_hero_meta_box($post_id, $post)
  {
    if (! isset($_POST['romonet_page_hero_meta_nonce']) || ! wp_verify_nonce($_POST['romonet_page_hero_meta_nonce'], 'romonet_page_hero_meta')) {
      return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    if ($post->post_type !== 'page') {
      return;
    }

    if (! current_user_can('edit_post', $post_id)) {
      return;
    }

    $fields = array(
      'badge' => 'romonet_page_hero_badge',
      'title' => 'romonet_page_hero_title',
      'description' => 'romonet_page_hero_description',
      'primary' => 'romonet_page_hero_primary',
      'primary_url' => 'romonet_page_hero_primary_url',
      'secondary' => 'romonet_page_hero_secondary',
      'secondary_url' => 'romonet_page_hero_secondary_url',
      'show_breadcrumbs' => 'romonet_page_hero_show_breadcrumbs',
    );

    foreach ($fields as $key => $meta_key) {
      if ($key === 'show_breadcrumbs') {
        $value = isset($_POST[$meta_key]) ? '1' : '0';
      } else {
        $value = isset($_POST[$meta_key]) ? $_POST[$meta_key] : '';
      }

      switch ($key) {
        case 'description':
          $value = sanitize_textarea_field($value);
          break;
        case 'primary_url':
        case 'secondary_url':
          $value = esc_url_raw($value);
          break;
        default:
          $value = sanitize_text_field($value);
          break;
      }

      if ($key === 'show_breadcrumbs') {
        update_post_meta($post_id, $meta_key, $value);
      } elseif ($value === '') {
        delete_post_meta($post_id, $meta_key);
      } else {
        update_post_meta($post_id, $meta_key, $value);
      }
    }
  }
}
add_action('save_post', 'romonet_save_page_hero_meta_box', 10, 2);
