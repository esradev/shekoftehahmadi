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
        'prev_text' => 'دیدگاه‌های قدیمی‌تر',
        'next_text' => 'دیدگاه‌های جدیدتر',
      )
    );
    ?>
  <?php endif; ?>

  <?php if (! comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">بخش نظرات برای این آموزش بسته شده است.</p>
  <?php endif; ?>

  <?php
  comment_form(
    array(
      'title_reply'          => 'پرسش یا نظر خود را درباره این آموزش بنویسید',
      'title_reply_before'   => '<h3 id="reply-title" class="text-xl font-bold text-slate-900">',
      'title_reply_after'    => '</h3>',
      'comment_notes_before' => '<p class="mb-4 text-sm text-slate-600">ایمیل شما محفوظ می‌ماند و منتشر نخواهد شد. فیلدهای الزامی با ستاره مشخص شده‌اند.</p>',
      'class_form'           => 'mt-6 space-y-4',
      'class_submit'         => 'inline-flex items-center justify-center rounded-xl bg-pink-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-pink-500',
      'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
      'fields'               => array(
        'author' => '<p class="comment-form-author"><label class="mb-2 block text-sm font-semibold text-slate-700" for="author">نام شما <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-pink-300" /></p>',
        'email'  => '<p class="comment-form-email"><label class="mb-2 block text-sm font-semibold text-slate-700" for="email">ایمیل شما <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-pink-300" /></p>',
        'url'    => '',
      ),
      'comment_field'        => '<p class="comment-form-comment"><label class="mb-2 block text-sm font-semibold text-slate-700" for="comment">متن پرسش یا نظر <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none focus:border-pink-300"></textarea></p>',
    )
  );
  ?>
</div>
