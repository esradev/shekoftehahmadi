<?php

if (! defined('ABSPATH')) {
  exit;
}

if (post_password_required()) {
  return;
}

$commenter = wp_get_current_commenter();
?>

<div id="comments" class="space-y-8">
  <?php if (have_comments()) : ?>
    <ol class="space-y-5">
      <?php
      wp_list_comments(
        array(
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 48,
          'callback'    => 'romonet_render_comment',
        )
      );
      ?>
    </ol>

    <?php
    the_comments_navigation(
      array(
        'prev_text' => esc_html__('Older comments', 'romonet'),
        'next_text' => esc_html__('Newer comments', 'romonet'),
      )
    );
    ?>
  <?php endif; ?>

  <?php if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600"><?php esc_html_e('Comments are closed for this article.', 'romonet'); ?></p>
  <?php endif; ?>

  <?php
  comment_form(
    array(
      'title_reply'          => esc_html__('Share your feedback', 'romonet'),
      'title_reply_before'   => '<h3 id="reply-title" class="text-xl font-bold text-slate-900">',
      'title_reply_after'    => '</h3>',
      'comment_notes_before' => '<p class="mb-4 text-sm text-slate-600">' . esc_html__('Your email will not be published. Required fields are marked.', 'romonet') . '</p>',
      'class_form'           => 'mt-6 space-y-4',
      'class_submit'         => 'inline-flex items-center justify-center rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-500',
      'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
      'fields'               => array(
        'author' => '<p class="comment-form-author"><label class="mb-2 block text-sm font-semibold text-slate-700" for="author">' . esc_html__('Name', 'romonet') . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-300" /></p>',
        'email'  => '<p class="comment-form-email"><label class="mb-2 block text-sm font-semibold text-slate-700" for="email">' . esc_html__('Email', 'romonet') . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-300" /></p>',
        'url'    => '',
      ),
      'comment_field'        => '<p class="comment-form-comment"><label class="mb-2 block text-sm font-semibold text-slate-700" for="comment">' . esc_html__('Comment', 'romonet') . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-300"></textarea></p>',
    )
  );
  ?>
</div>
