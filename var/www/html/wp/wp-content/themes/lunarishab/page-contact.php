<?php

get_header();
?>
<?php if(have_posts()): ?>
  <?php while(have_posts()): the_post();?>
  <main>
    <section class="section">
      <div class="section_inner">
        <div class="section_header">
          <h2 class="heading heading-primary"><span><?php the_title();?></span><?php echo strtoupper($post->post_name);?></h2>
        </div>

        <div class="section_body">
          <div class="content">
            <form action="" method="post">
              <?php wp_nonce_field('contact_step1', 'contact_nonce'); ?>
              <input type="hidden" name="debug" value="from_contact">
              <div class="form">
                <div class="form_group">
                  <label>お名前<span>*</span></label>
                  <div>
                    <input type="text" name="lname" required>
                  </div>
                </div>
                <!-- /.form_group name -->
                <div class="form_group">
                  <label>メールアドレス<span>*</span></label>
                  <div>
                    <input type="email" name="email" required>
                  </div>
                </div>
                <!-- /.form_group email -->
                <div class="form_group">
                  <label>お問い合わせ内容<span>*</span></label>
                  <div>
                    <textarea name="message"rows="5"></textarea>
                    <!-- /# -->
                  </div>
                </div>
                <!-- /.form_group message -->
              </div>
              <!-- / -->

              <button class="form-btn" type="submit">確認画面へ</button>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php endwhile?>
<?php endif;?>
<?php get_footer();?>