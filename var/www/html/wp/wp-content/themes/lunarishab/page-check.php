<?php

// POSTデータ取得
$name   = $_SESSION['contact']['lname'] ?? '';
$email   = $_SESSION['contact']['email'] ?? '';
$message = $_SESSION['contact']['message'] ?? '';


$errors = [];

// 必須チェック
if ($name === '') {
  $errors[] = 'お名前を入力してください';
}
if ($email === '') {
  $errors[] = 'メールアドレスを入力してください';
}
if ($message === '') {
  $errors[] = 'お問い合わせ内容を入力してください';
}
// メール形式をチェック
if($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'メールアドレスの形式が正しくありません。';
}
// 文字数チェック
if(mb_strlen($message) > 1000) {
  $errors[] = 'お問い合わせ内容は1000文字以内で入力してください。'; 
}
get_header();
?>
  <main>
    <section class="section">
      <div class="section_inner">
        <div class="section_header">
          <h2 class="heading heading-primary"><span><?php the_title();?></span>
            CHECK
          </h2>
        </div>

        <div class="section_body">
          <div class="content">

          <?php if(!empty($errors)): ?>
            <div class="errors">
                <h2>入力内容にエラーがあります</h2>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>

                <form action="" method="post">
                    <input type="hidden" name="lname" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit">戻る</button>
                </form>
            </div>
          <?php else: ?>
            <div class="form">
              <div class="form_group">
                <label>お名前<span>*</span></label>
                <div>
                  <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </div>
              <!-- /.form_group name -->
              <div class="form_group">
                <label>メールアドレス<span>*</span></label>
                <div>
                  <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>
                </div>
              </div>
              <!-- /.form_group email -->
              <div class="form_group">
                <label>お問い合わせ内容<span>*</span></label>
                <div>
                  <?php echo nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')); ?>
                  <!-- /# -->
                </div>
              </div>
              <!-- /.form_group message -->
            </div>
            <!-- /formの内容確認 -->
            <form action="" method="post">
                <input type="hidden" name="lname" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit">送信する</button>
            </form>
            <form action="" method="post">
              <input type="hidden" name="lname" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
              <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
              <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
              <button type="submit">戻る</button>
            </form>
          <?php endif;?>
            
          </div>
        </div>
      </div>
    </section>
  </main>
<?php get_footer();?>