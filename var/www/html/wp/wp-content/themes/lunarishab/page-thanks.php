<?php
/* Template Name: Contact Thanks */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // nonce チェック（confirm → thanks）
    if (!isset($_POST['contact_nonce2']) ||
        !wp_verify_nonce($_POST['contact_nonce2'], 'contact_step2')) {
        die('Invalid nonce');
    }

    // POSTデータ取得（sanitize）
    $name    = sanitize_text_field($_POST['lname'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    // ▼ ここにメール送信 or DB 保存を書く（必要なら後で一緒に作る）
    // send_mail($name, $email, $message);
}

get_header();
?>

<main>
  <section class="section">
    <div class="section_inner">
      <div class="section_header">
        <h2 class="heading heading-primary">
          <span><?php the_title(); ?></span>
          THANKS
        </h2>
      </div>

      <div class="section_body">
        <div class="content">
          <p>お問い合わせありがとうございました。</p>
          <p>内容を確認のうえ、担当者よりご連絡いたします。</p>
        </div>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>