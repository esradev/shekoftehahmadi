<?php

if (! defined('ABSPATH')) {
  exit;
}

$faq_categories = function_exists('romonet_get_faq_categories') ? romonet_get_faq_categories() : array();
$popular_items  = function_exists('romonet_get_faq_popular_items') ? romonet_get_faq_popular_items() : array();

$total_questions = 0;
$faq_alpine_data = array();

foreach ($faq_categories as $category) {
  $items = array();

  foreach ($category['items'] as $item) {
    $items[] = array(
      'question' => $item['question'],
      'answer'   => $item['answer'],
    );
  }

  $faq_alpine_data[] = array(
    'id'    => $category['id'],
    'items' => $items,
  );

  $total_questions += count($category['items']);
}

?>

<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('romonetFaqPage', () => ({
    search: '',
    activeCategory: 'all',
    openItem: null,
    hasAutoScrolledToResults: false,
    categories: <?php echo wp_json_encode($faq_alpine_data, JSON_UNESCAPED_UNICODE); ?>,
    init() {
      this.$watch('search', (value) => {
        const query = this.normalize(value);
        if (!query) {
          this.hasAutoScrolledToResults = false;
          return;
        }
        if (this.hasAutoScrolledToResults) return;
        this.hasAutoScrolledToResults = true;
        this.$nextTick(() => this.scrollToResults());
      });
    },
    normalize(text) {
      return (text || '').toLowerCase().trim();
    },
    matchesItem(question, answer) {
      const q = this.normalize(this.search);
      if (!q) return true;
      return this.normalize(question).includes(q) || this.normalize(answer).includes(q);
    },
    categoryVisible(categoryId) {
      if (this.activeCategory !== 'all' && this.activeCategory !== categoryId) return false;
      const category = this.categories.find((entry) => entry.id === categoryId);
      if (!category) return false;
      if (!this.search) return true;
      return category.items.some((item) => this.matchesItem(item.question, item.answer));
    },
    itemVisible(categoryId, itemIndex) {
      if (this.activeCategory !== 'all' && this.activeCategory !== categoryId) return false;
      const category = this.categories.find((entry) => entry.id === categoryId);
      if (!category || !category.items[itemIndex]) return false;
      const item = category.items[itemIndex];
      return this.matchesItem(item.question, item.answer);
    },
    get visibleResultCount() {
      let count = 0;
      for (const category of this.categories) {
        category.items.forEach((item, itemIndex) => {
          if (this.itemVisible(category.id, itemIndex)) {
            count++;
          }
        });
      }
      return count;
    },
    toggleItem(id) {
      this.openItem = this.openItem === id ? null : id;
    },
    scrollToCategory(id) {
      this.activeCategory = id;
      this.$nextTick(() => {
        const el = document.getElementById('faq-cat-' + id);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    },
    scrollToItem(id) {
      this.activeCategory = 'all';
      this.openItem = id;
      this.$nextTick(() => {
        const el = document.getElementById('faq-item-' + id);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
      });
    },
    scrollToResults() {
      const el = this.$refs.resultsSection;
      if (!el) return;
      el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    },
  }));
});
</script>

<section
  class="py-16 lg:py-24"
  x-data="romonetFaqPage()"
  aria-label="پرسش‌های متداول"
>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <p class="mx-auto max-w-3xl text-center text-sm text-slate-500">
      <?php echo esc_html(sprintf('%d سوال در %d دسته', $total_questions, count($faq_categories))); ?>
    </p>

    <?php if (! empty($popular_items)) : ?>
      <div class="mt-10">
        <h2 class="text-center text-sm font-semibold uppercase tracking-wider text-slate-500">پرسش‌های پرتکرار</h2>
        <ul class="mt-4 flex flex-wrap justify-center gap-2">
          <?php foreach ($popular_items as $item) : ?>
            <li>
              <button
                type="button"
                class="rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-medium text-blue-700 transition hover:border-blue-200 hover:bg-blue-100"
                @click="scrollToItem('<?php echo esc_attr($item['id']); ?>')"
              >
                <?php echo esc_html($item['question']); ?>
              </button>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Category cards (mobile-friendly navigation) -->
    <div class="mt-14 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <?php foreach ($faq_categories as $category) : ?>
        <button
          type="button"
          class="group rounded-2xl border border-slate-200 bg-white p-5 text-right shadow-sm transition hover:border-blue-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500/30"
          :class="activeCategory === '<?php echo esc_attr($category['id']); ?>' ? 'border-blue-300 bg-blue-50 ring-2 ring-blue-500/20' : ''"
          @click="scrollToCategory('<?php echo esc_attr($category['id']); ?>')"
        >
          <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition group-hover:bg-blue-100">
            <?php echo romonet_get_faq_icon_svg($category['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
          </span>
          <span class="mt-4 block font-semibold text-slate-900"><?php echo esc_html($category['title']); ?></span>
          <span class="mt-1 block text-sm leading-6 text-slate-500"><?php echo esc_html($category['description']); ?></span>
          <span class="mt-3 inline-block text-xs font-medium text-blue-600"><?php echo esc_html(count($category['items']) . ' سوال'); ?></span>
        </button>
      <?php endforeach; ?>
    </div>

    <div class="mt-16 lg:grid lg:grid-cols-12 lg:gap-10">
      <!-- Sticky sidebar -->
      <aside class="hidden lg:col-span-3 lg:block">
        <div class="sticky top-28 space-y-6">
          <nav class="space-y-1 rounded-2xl border border-slate-200 bg-slate-50 p-4" aria-label="دسته‌بندی سوالات">
            <p class="px-3 pb-2 text-xs font-bold uppercase tracking-wider text-slate-500">دسته‌بندی</p>
            <button
              type="button"
              class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition"
              :class="activeCategory === 'all' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-white/70 hover:text-slate-900'"
              @click="activeCategory = 'all'"
            >
              <span>همه سوالات</span>
              <span class="text-xs text-slate-400"><?php echo (int) $total_questions; ?></span>
            </button>
            <?php foreach ($faq_categories as $category) : ?>
              <button
                type="button"
                class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 text-sm font-medium transition"
                :class="activeCategory === '<?php echo esc_attr($category['id']); ?>' ? 'bg-white text-blue-700 shadow-sm' : 'text-slate-600 hover:bg-white/70 hover:text-slate-900'"
                @click="scrollToCategory('<?php echo esc_attr($category['id']); ?>')"
              >
                <span><?php echo esc_html($category['title']); ?></span>
                <span class="text-xs text-slate-400"><?php echo (int) count($category['items']); ?></span>
              </button>
            <?php endforeach; ?>
          </nav>

          <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
            <p class="text-sm font-semibold text-blue-900">پاسخ را پیدا نکردید؟</p>
            <p class="mt-2 text-sm leading-6 text-blue-800/80">تیم ما ظرف ۲۴ ساعت به سوالات فنی و تجاری پاسخ می‌دهد.</p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-blue-700 hover:text-blue-800">
              تماس با ما
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7-7-7 7-7" /></svg>
            </a>
          </div>
        </div>
      </aside>

      <!-- FAQ accordion groups -->
      <div class="lg:col-span-9" x-ref="resultsSection">
        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
          <label for="faq-search" class="sr-only">جستجو در سوالات</label>
          <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-4 text-slate-400">
              <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
              </svg>
            </span>
            <input
              id="faq-search"
              type="search"
              x-model="search"
              placeholder="کلمهٔ کلیدی را بنویسید؛ مثلاً ووکامرس، پشتیبانی، قیمت…"
              class="w-full rounded-2xl border border-slate-200 bg-white py-4 ps-12 pe-4 text-base text-slate-900 transition placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20"
              autocomplete="off"
            />
          </div>
        </div>
        <!-- Mobile category filter -->
        <div class="mb-6 flex gap-2 overflow-x-auto pb-2 lg:hidden" role="tablist" aria-label="فیلتر دسته">
          <button
            type="button"
            role="tab"
            class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium transition"
            :class="activeCategory === 'all' ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 bg-white text-slate-600'"
            @click="activeCategory = 'all'"
          >همه</button>
          <?php foreach ($faq_categories as $category) : ?>
            <button
              type="button"
              role="tab"
              class="shrink-0 rounded-full border px-4 py-2 text-sm font-medium transition"
              :class="activeCategory === '<?php echo esc_attr($category['id']); ?>' ? 'border-blue-600 bg-blue-600 text-white' : 'border-slate-200 bg-white text-slate-600'"
              @click="activeCategory = '<?php echo esc_attr($category['id']); ?>'"
            ><?php echo esc_html($category['title']); ?></button>
          <?php endforeach; ?>
        </div>

        <p
          x-show="search && visibleResultCount > 0"
          x-cloak
          class="mb-6 rounded-xl border border-amber-100 bg-amber-50 px-4 py-3 text-sm text-amber-800"
          role="status"
        >
          در حال نمایش نتایج مرتبط با «<span x-text="search"></span>»
          <button type="button" class="ms-2 font-semibold underline" @click="search = ''">پاک کردن جستجو</button>
        </p>

        <div class="space-y-12">
          <?php foreach ($faq_categories as $category) : ?>
            <section
              id="faq-cat-<?php echo esc_attr($category['id']); ?>"
              class="scroll-mt-28"
              x-show="categoryVisible('<?php echo esc_attr($category['id']); ?>')"
              x-cloak
            >
              <div class="flex items-start gap-4 border-b border-slate-200 pb-4">
                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                  <?php echo romonet_get_faq_icon_svg($category['icon']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </span>
                <div>
                  <h2 class="text-xl font-bold text-slate-900"><?php echo esc_html($category['title']); ?></h2>
                  <p class="mt-1 text-sm text-slate-500"><?php echo esc_html($category['description']); ?></p>
                </div>
              </div>

              <div class="mt-4 divide-y divide-slate-200 rounded-2xl border border-slate-200 bg-white shadow-sm">
                <?php foreach ($category['items'] as $index => $item) :
                  $item_id = $category['id'] . '-' . $index;
                  $panel_id = 'faq-panel-' . $item_id;
                  ?>
                  <div
                    id="faq-item-<?php echo esc_attr($item_id); ?>"
                    class="scroll-mt-32"
                    x-show="itemVisible('<?php echo esc_attr($category['id']); ?>', <?php echo (int) $index; ?>)"
                    x-cloak
                  >
                    <h3>
                      <button
                        type="button"
                        class="flex w-full items-center justify-between gap-4 px-5 py-5 text-right font-semibold text-slate-900 transition hover:bg-slate-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-500"
                        :aria-expanded="openItem === '<?php echo esc_attr($item_id); ?>'"
                        aria-controls="<?php echo esc_attr($panel_id); ?>"
                        @click="toggleItem('<?php echo esc_attr($item_id); ?>')"
                      >
                        <span class="text-pretty leading-7"><?php echo esc_html($item['question']); ?></span>
                        <span
                          class="grid h-8 w-8 shrink-0 place-items-center rounded-lg bg-blue-50 text-blue-600 transition"
                          :class="openItem === '<?php echo esc_attr($item_id); ?>' ? 'rotate-45 bg-blue-600 text-white' : ''"
                          aria-hidden="true"
                        >+</span>
                      </button>
                    </h3>
                    <div
                      id="<?php echo esc_attr($panel_id); ?>"
                      role="region"
                      x-show="openItem === '<?php echo esc_attr($item_id); ?>'"
                      x-transition
                      class="overflow-hidden"
                    >
                      <div class="border-t border-slate-100 px-5 pb-5 pt-4 text-sm leading-7 text-slate-600">
                        <?php echo esc_html($item['answer']); ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>
        </div>

        <div
          x-show="search && visibleResultCount === 0"
          x-cloak
          class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center"
        >
          <span class="block text-lg font-semibold text-slate-900">نتیجه‌ای یافت نشد</span>
          <span class="mt-2 block text-sm text-slate-500">عبارت دیگری امتحان کنید یا مستقیماً با ما تماس بگیرید.</span>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="mt-6 inline-flex rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">ارسال پیام</a>
        </div>
      </div>
    </div>
  </div>
</section>
