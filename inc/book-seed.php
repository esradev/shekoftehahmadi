<?php

/**
 * Seed sample data for the book library.
 */

if (! defined('ABSPATH')) {
  exit;
}

if (! function_exists('romonet_get_book_seed_payload')) {
  function romonet_get_book_seed_payload()
  {
    return array(
      'authors' => array(
        array(
          'name'        => 'علی محمدی',
          'slug'        => 'ali-mohammadi',
          'description' => 'نویسنده و توسعه‌دهنده ارشد وردپرس با تمرکز بر پروژه‌های مقیاس‌پذیر.',
        ),
        array(
          'name'        => 'نرگس احمدی',
          'slug'        => 'narges-ahmadi',
          'description' => 'مشاور بازاریابی دیجیتال و استراتژی محتوای کسب‌وکارهای آنلاین.',
        ),
        array(
          'name'        => 'رضا کریمی',
          'slug'        => 'reza-karimi',
          'description' => 'معمار نرم‌افزار و مدرس شیوه‌های توسعه تمیز در تیم‌های فنی.',
        ),
        array(
          'name'        => 'مهسا قاسمی',
          'slug'        => 'mahsa-ghasemi',
          'description' => 'مدیر محصول و تسهیل‌گر طراحی مسیر رشد برای محصولات دیجیتال.',
        ),
        array(
          'name'        => 'پویا رحیمی',
          'slug'        => 'pouya-rahimi',
          'description' => 'پژوهشگر و مدرس هوش مصنوعی کاربردی در توسعه محصولات وب.',
        ),
        array(
          'name'        => 'سارا توکلی',
          'slug'        => 'sara-tavakoli',
          'description' => 'طراح ارشد تجربه کاربر با سابقه طراحی محصول برای استارتاپ‌ها.',
        ),
      ),
      'topics' => array(
        array(
          'name'        => 'توسعه وردپرس',
          'slug'        => 'wordpress-development',
          'description' => 'مباحث مرتبط با توسعه قالب، افزونه و بهینه‌سازی وردپرس.',
        ),
        array(
          'name'        => 'طراحی رابط کاربری',
          'slug'        => 'ui-design',
          'description' => 'کتاب‌های مرتبط با اصول طراحی رابط کاربری و تجربه کاربر.',
        ),
        array(
          'name'        => 'معماری نرم‌افزار',
          'slug'        => 'software-architecture',
          'description' => 'الگوها و رویکردهای طراحی ساختار نرم‌افزارهای پایدار.',
        ),
        array(
          'name'        => 'مدیریت محصول',
          'slug'        => 'product-management',
          'description' => 'روش‌های تصمیم‌گیری محصول، اولویت‌بندی و رشد پایدار.',
        ),
        array(
          'name'        => 'بازاریابی دیجیتال',
          'slug'        => 'digital-marketing',
          'description' => 'استراتژی‌های جذب مخاطب و رشد فروش در بستر آنلاین.',
        ),
        array(
          'name'        => 'هوش مصنوعی کاربردی',
          'slug'        => 'applied-ai',
          'description' => 'کاربردهای عملی هوش مصنوعی در تولید محصول و توسعه نرم‌افزار.',
        ),
      ),
      'books' => array(
        array(
          'title'        => 'وردپرس حرفه‌ای برای پروژه‌های واقعی',
          'slug'         => 'pro-wordpress-for-real-projects',
          'excerpt'      => 'کتابی کاربردی برای طراحی و پیاده‌سازی پروژه‌های وردپرسی با استاندارد حرفه‌ای.',
          'content'      => 'این کتاب مسیر ساخت یک پروژه وردپرسی از تحلیل نیاز تا استقرار نهایی را به‌صورت قدم‌به‌قدم توضیح می‌دهد و روی کیفیت کد، امنیت و نگهداری تمرکز دارد.',
          'author_slugs' => array('ali-mohammadi'),
          'topic_slugs'  => array('wordpress-development', 'software-architecture'),
          'meta'         => array(
            'book_subtitle'      => 'راهنمای عملی قالب و افزونه',
            'book_download_url'  => 'https://example.com/books/pro-wordpress.pdf',
            'book_preview_url'   => 'https://example.com/books/pro-wordpress-preview',
            'book_isbn'          => '978-600-001-100-1',
            'book_publisher'     => 'انتشارات رومونت',
            'book_publish_year'  => '1402',
            'book_pages'         => '312',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'متوسط',
            'book_access_type'   => 'رایگان',
            'book_featured'      => '1',
          ),
        ),
        array(
          'title'        => 'طراحی رابط کاربری انسان‌محور',
          'slug'         => 'human-centered-ui-design',
          'excerpt'      => 'اصول طراحی رابط کاربری با رویکرد تجربه‌محور برای محصولات دیجیتال.',
          'content'      => 'در این کتاب با روش‌های تحقیق کاربر، ساخت وایرفریم، طراحی سیستم و ارزیابی تجربه کاربری آشنا می‌شوید تا بتوانید رابط‌هایی ساده و مؤثر طراحی کنید.',
          'author_slugs' => array('sara-tavakoli'),
          'topic_slugs'  => array('ui-design', 'product-management'),
          'meta'         => array(
            'book_subtitle'      => 'از تحقیق کاربر تا طراحی سیستم',
            'book_download_url'  => 'https://example.com/books/human-ui-design.pdf',
            'book_preview_url'   => 'https://example.com/books/human-ui-design-preview',
            'book_isbn'          => '978-600-001-100-2',
            'book_publisher'     => 'نشر تجربه محصول',
            'book_publish_year'  => '1401',
            'book_pages'         => '276',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'مبتدی',
            'book_access_type'   => 'رایگان',
            'book_featured'      => '0',
          ),
        ),
        array(
          'title'        => 'معماری تمیز در پروژه‌های PHP',
          'slug'         => 'clean-architecture-php-projects',
          'excerpt'      => 'راهکارهای عملی برای جداسازی لایه‌ها و افزایش پایداری در پروژه‌های PHP.',
          'content'      => 'این کتاب با مثال‌های واقعی نشان می‌دهد چطور معماری تمیز، تست‌پذیری و توسعه‌پذیری پروژه‌های PHP را به‌صورت پایدار افزایش می‌دهد.',
          'author_slugs' => array('reza-karimi'),
          'topic_slugs'  => array('software-architecture'),
          'meta'         => array(
            'book_subtitle'      => 'الگوهای معماری برای تیم‌های توسعه',
            'book_download_url'  => 'https://example.com/books/clean-architecture-php.pdf',
            'book_preview_url'   => 'https://example.com/books/clean-architecture-php-preview',
            'book_isbn'          => '978-600-001-100-3',
            'book_publisher'     => 'نشر مهندسی نرم‌افزار',
            'book_publish_year'  => '1400',
            'book_pages'         => '340',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'پیشرفته',
            'book_access_type'   => 'داخلی',
            'book_featured'      => '1',
          ),
        ),
        array(
          'title'        => 'راهنمای عملی مدیریت محصول دیجیتال',
          'slug'         => 'digital-product-management-guide',
          'excerpt'      => 'کتابی برای مدیریت بهتر بک‌لاگ، شاخص‌ها و مسیر رشد محصول.',
          'content'      => 'از کشف مسئله تا اولویت‌بندی و تحویل ارزش به کاربر، این کتاب فرآیندهای ضروری مدیریت محصول را با مثال‌های قابل اجرا آموزش می‌دهد.',
          'author_slugs' => array('mahsa-ghasemi'),
          'topic_slugs'  => array('product-management', 'digital-marketing'),
          'meta'         => array(
            'book_subtitle'      => 'از ایده تا رشد پایدار',
            'book_download_url'  => 'https://example.com/books/digital-product-management.pdf',
            'book_preview_url'   => 'https://example.com/books/digital-product-management-preview',
            'book_isbn'          => '978-600-001-100-4',
            'book_publisher'     => 'انتشارات مسیر محصول',
            'book_publish_year'  => '1402',
            'book_pages'         => '298',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'متوسط',
            'book_access_type'   => 'رایگان',
            'book_featured'      => '0',
          ),
        ),
        array(
          'title'        => 'بازاریابی دیجیتال برای تیم‌های فنی',
          'slug'         => 'digital-marketing-for-tech-teams',
          'excerpt'      => 'رویکردی عملی برای هم‌راستاسازی تیم فنی و بازاریابی در رشد محصول.',
          'content'      => 'این کتاب نشان می‌دهد چگونه تیم‌های فنی می‌توانند با داده‌محوری، سئو فنی و تحلیل رفتار کاربران به رشد مستمر محصول کمک کنند.',
          'author_slugs' => array('narges-ahmadi'),
          'topic_slugs'  => array('digital-marketing'),
          'meta'         => array(
            'book_subtitle'      => 'داده‌محوری در رشد آنلاین',
            'book_download_url'  => 'https://example.com/books/digital-marketing-tech-teams.pdf',
            'book_preview_url'   => 'https://example.com/books/digital-marketing-tech-teams-preview',
            'book_isbn'          => '978-600-001-100-5',
            'book_publisher'     => 'انتشارات رشد دیجیتال',
            'book_publish_year'  => '1401',
            'book_pages'         => '256',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'متوسط',
            'book_access_type'   => 'رایگان',
            'book_featured'      => '0',
          ),
        ),
        array(
          'title'        => 'هوش مصنوعی کاربردی برای توسعه‌دهندگان',
          'slug'         => 'applied-ai-for-developers',
          'excerpt'      => 'راهنمای پیاده‌سازی قابلیت‌های هوش مصنوعی در محصولات وب و نرم‌افزاری.',
          'content'      => 'این کتاب با مثال‌های پروژه‌محور، از انتخاب مسئله مناسب تا پیاده‌سازی، ارزیابی و نگهداری قابلیت‌های مبتنی بر هوش مصنوعی را پوشش می‌دهد.',
          'author_slugs' => array('pouya-rahimi'),
          'topic_slugs'  => array('applied-ai', 'software-architecture'),
          'meta'         => array(
            'book_subtitle'      => 'از ایده تا پیاده‌سازی در محصول',
            'book_download_url'  => 'https://example.com/books/applied-ai-for-developers.pdf',
            'book_preview_url'   => 'https://example.com/books/applied-ai-for-developers-preview',
            'book_isbn'          => '978-600-001-100-6',
            'book_publisher'     => 'نشر فناوری هوشمند',
            'book_publish_year'  => '1403',
            'book_pages'         => '324',
            'book_language'      => 'فارسی',
            'book_file_format'   => 'PDF',
            'book_reading_level' => 'پیشرفته',
            'book_access_type'   => 'داخلی',
            'book_featured'      => '1',
          ),
        ),
      ),
    );
  }
}

if (! function_exists('romonet_seed_book_terms')) {
  function romonet_seed_book_terms($taxonomy, $terms)
  {
    $mapped_ids   = array();
    $created      = 0;
    $updated      = 0;

    foreach ((array) $terms as $term_data) {
      $name = isset($term_data['name']) ? trim((string) $term_data['name']) : '';
      $slug = isset($term_data['slug']) ? sanitize_title((string) $term_data['slug']) : '';
      $desc = isset($term_data['description']) ? (string) $term_data['description'] : '';

      if ('' === $name || '' === $slug) {
        continue;
      }

      $existing = term_exists($slug, $taxonomy);
      $term_id  = 0;

      if (! $existing) {
        $inserted = wp_insert_term(
          $name,
          $taxonomy,
          array(
            'slug'        => $slug,
            'description' => $desc,
          )
        );

        if (is_wp_error($inserted)) {
          continue;
        }

        $term_id = isset($inserted['term_id']) ? (int) $inserted['term_id'] : 0;
        if ($term_id) {
          $created++;
        }
      } else {
        $term_id = is_array($existing) ? (int) $existing['term_id'] : (int) $existing;
        if ($term_id) {
          wp_update_term(
            $term_id,
            $taxonomy,
            array(
              'name'        => $name,
              'description' => $desc,
            )
          );
          $updated++;
        }
      }

      if ($term_id) {
        $mapped_ids[$slug] = $term_id;
      }
    }

    return array(
      'ids'     => $mapped_ids,
      'created' => $created,
      'updated' => $updated,
    );
  }
}

if (! function_exists('romonet_seed_book_library')) {
  function romonet_seed_book_library()
  {
    if (! post_type_exists('book')) {
      return new WP_Error('romonet_book_seed_missing_post_type', 'پست‌تایپ کتاب در سیستم ثبت نشده است.');
    }

    if (! taxonomy_exists('book_author') || ! taxonomy_exists('book_topic')) {
      return new WP_Error('romonet_book_seed_missing_taxonomy', 'تکسونومی نویسنده یا موضوع کتاب در دسترس نیست.');
    }

    $payload       = romonet_get_book_seed_payload();
    $author_result = romonet_seed_book_terms('book_author', $payload['authors']);
    $topic_result  = romonet_seed_book_terms('book_topic', $payload['topics']);

    $author_ids = isset($author_result['ids']) ? $author_result['ids'] : array();
    $topic_ids  = isset($topic_result['ids']) ? $topic_result['ids'] : array();

    $created_books = 0;
    $updated_books = 0;
    $failed_books  = 0;

    foreach ((array) $payload['books'] as $book) {
      $slug = isset($book['slug']) ? sanitize_title((string) $book['slug']) : '';
      if ('' === $slug) {
        continue;
      }

      $post_data = array(
        'post_type'    => 'book',
        'post_status'  => 'publish',
        'post_title'   => isset($book['title']) ? (string) $book['title'] : '',
        'post_name'    => $slug,
        'post_excerpt' => isset($book['excerpt']) ? (string) $book['excerpt'] : '',
        'post_content' => isset($book['content']) ? (string) $book['content'] : '',
      );

      $existing_post = get_page_by_path($slug, OBJECT, 'book');

      if ($existing_post instanceof WP_Post) {
        $post_data['ID'] = (int) $existing_post->ID;
        $post_id         = wp_update_post($post_data, true);
        if (! is_wp_error($post_id)) {
          $updated_books++;
        }
      } else {
        $post_id = wp_insert_post($post_data, true);
        if (! is_wp_error($post_id)) {
          $created_books++;
        }
      }

      if (is_wp_error($post_id) || ! $post_id) {
        $failed_books++;
        continue;
      }

      if (! empty($book['meta']) && is_array($book['meta'])) {
        foreach ($book['meta'] as $meta_key => $meta_value) {
          update_post_meta($post_id, sanitize_key($meta_key), (string) $meta_value);
        }
      }

      $assigned_authors = array();
      foreach ((array) $book['author_slugs'] as $author_slug) {
        $author_slug = sanitize_title((string) $author_slug);
        if ($author_slug && isset($author_ids[$author_slug])) {
          $assigned_authors[] = (int) $author_ids[$author_slug];
        }
      }
      if (! empty($assigned_authors)) {
        wp_set_object_terms($post_id, array_values(array_unique($assigned_authors)), 'book_author', false);
      }

      $assigned_topics = array();
      foreach ((array) $book['topic_slugs'] as $topic_slug) {
        $topic_slug = sanitize_title((string) $topic_slug);
        if ($topic_slug && isset($topic_ids[$topic_slug])) {
          $assigned_topics[] = (int) $topic_ids[$topic_slug];
        }
      }
      if (! empty($assigned_topics)) {
        wp_set_object_terms($post_id, array_values(array_unique($assigned_topics)), 'book_topic', false);
      }
    }

    return array(
      'created_books'   => $created_books,
      'updated_books'   => $updated_books,
      'failed_books'    => $failed_books,
      'created_authors' => isset($author_result['created']) ? (int) $author_result['created'] : 0,
      'updated_authors' => isset($author_result['updated']) ? (int) $author_result['updated'] : 0,
      'created_topics'  => isset($topic_result['created']) ? (int) $topic_result['created'] : 0,
      'updated_topics'  => isset($topic_result['updated']) ? (int) $topic_result['updated'] : 0,
    );
  }
}

if (! function_exists('romonet_get_book_seed_action_url')) {
  function romonet_get_book_seed_action_url()
  {
    return wp_nonce_url(admin_url('admin-post.php?action=romonet_seed_books'), 'romonet_seed_books_action');
  }
}

if (! function_exists('romonet_handle_book_seed_action')) {
  function romonet_handle_book_seed_action()
  {
    if (! current_user_can('manage_options')) {
      wp_die('دسترسی کافی برای اجرای سید وجود ندارد.');
    }

    check_admin_referer('romonet_seed_books_action');

    $result   = romonet_seed_book_library();
    $base_url = admin_url('edit.php?post_type=book');

    if (is_wp_error($result)) {
      $redirect = add_query_arg(
        array(
          'romonet_book_seed' => 'error',
          'message'           => $result->get_error_message(),
        ),
        $base_url
      );
      wp_safe_redirect($redirect);
      exit;
    }

    $redirect = add_query_arg(
      array(
        'romonet_book_seed' => 'success',
        'created_books'     => (int) $result['created_books'],
        'updated_books'     => (int) $result['updated_books'],
        'failed_books'      => (int) $result['failed_books'],
        'created_authors'   => (int) $result['created_authors'],
        'created_topics'    => (int) $result['created_topics'],
      ),
      $base_url
    );

    wp_safe_redirect($redirect);
    exit;
  }
}
add_action('admin_post_romonet_seed_books', 'romonet_handle_book_seed_action');

if (! function_exists('romonet_render_book_seed_notices')) {
  function romonet_render_book_seed_notices()
  {
    if (! is_admin()) {
      return;
    }

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (! $screen || 'edit-book' !== $screen->id) {
      return;
    }

    $action_url = romonet_get_book_seed_action_url();
    $status     = isset($_GET['romonet_book_seed']) ? sanitize_key(wp_unslash($_GET['romonet_book_seed'])) : '';

    if ('success' === $status) {
      $created_books   = isset($_GET['created_books']) ? absint($_GET['created_books']) : 0;
      $updated_books   = isset($_GET['updated_books']) ? absint($_GET['updated_books']) : 0;
      $failed_books    = isset($_GET['failed_books']) ? absint($_GET['failed_books']) : 0;
      $created_authors = isset($_GET['created_authors']) ? absint($_GET['created_authors']) : 0;
      $created_topics  = isset($_GET['created_topics']) ? absint($_GET['created_topics']) : 0;

      $message = sprintf(
        'سید کتابخانه انجام شد: %d کتاب جدید، %d کتاب بروزرسانی‌شده، %d خطا، %d نویسنده جدید و %d موضوع جدید.',
        $created_books,
        $updated_books,
        $failed_books,
        $created_authors,
        $created_topics
      );

      echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($message) . ' <a class="button button-secondary" href="' . esc_url($action_url) . '">اجرای دوباره سید</a></p></div>';
      return;
    }

    if ('error' === $status) {
      $message = isset($_GET['message']) ? sanitize_text_field(wp_unslash($_GET['message'])) : 'خطایی در اجرای سید رخ داد.';
      echo '<div class="notice notice-error is-dismissible"><p>' . esc_html($message) . ' <a class="button button-secondary" href="' . esc_url($action_url) . '">تلاش دوباره</a></p></div>';
      return;
    }

    echo '<div class="notice notice-info"><p>برای ایجاد داده نمونه کتابخانه (۶ کتاب فارسی به‌همراه نویسنده‌ها و موضوعات)، روی دکمه زیر کلیک کنید. <a class="button button-primary" href="' . esc_url($action_url) . '">اجرای سید کتابخانه</a></p></div>';
  }
}
add_action('admin_notices', 'romonet_render_book_seed_notices');
