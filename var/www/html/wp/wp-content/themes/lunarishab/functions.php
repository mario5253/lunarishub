<?php

// カスタムメニュー機能使用可能にする
add_theme_support('menus');
register_nav_menus([
  'footer-sns' => 'フッターSNSメニュー',
]);

// ウィジェットエリア（サイドバー）を有効化
function lunarishab_widgets_init() {
    register_sidebar([
        'name'          => 'サイドバー',
        'id'            => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action('widgets_init', 'lunarishab_widgets_init');

// ブロックウィジェットを無効化して、クラシックウィジェットを使う
add_filter( 'use_widgets_block_editor', '__return_false' );

function luna_enqueue_scripts() {

    // Font Awesome
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css',
        array(),
        null
    );

    // Google Fonts
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap',
        array(),
        null
    );

    // メインCSS（必要なら）
    wp_enqueue_style(
        'luna-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        null
    );

    // jQuery（WordPress同梱）
    wp_enqueue_script('jquery');

    // メインJS
    wp_enqueue_script(
        'luna-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        null,
        true
    );
    // HOME JS
    if(is_home()) {
        wp_enqueue_script(
            'luna-home',
            get_stylesheet_directory_uri() . '/assets/js/home.js',
            array(),
            null,
            true
        );
    }
// slick
    wp_enqueue_style(
    'slick-css',
    'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
    array(),
    null
);
wp_enqueue_script(
    'slick-js',
    'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
    array('jquery'),
    null,
    true
);
}
add_action('wp_enqueue_scripts', 'luna_enqueue_scripts');
function luna_add_defer_to_scripts( $tag, $handle ) {
    if ( 'luna-home' === $handle ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'luna_add_defer_to_scripts', 10, 2 );

add_filter( 'wp_image_editors', function( $editors ) {
    return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
});

add_filter( 'big_image_size_threshold', '__return_false' );



add_theme_support('post-thumbnails');

// メインクエリを変更する
add_action('pre_get_posts', 'my_pre_get_posts');
function my_pre_get_posts($query){
    // 管理画面以外メインクエリ以外には設定しない
    if(is_admin() || !$query->is_main_query()) {
        return;
    }
    if($query->is_home()) {
        $query->set('posts_per_page', 3);
        return;
    }
}

// パスワード保護の保護中テキスト削除
add_filter('protected_title_format', 'my_protected_title');
function my_protected_title($title) {
    return '%s';
}

// お問い合わせフォーム
// セッション開始
add_action('init', function() {
    if (!session_id()) {
        session_start();
    }
});

// POSTしたらcheckへ遷移する処理
add_action('template_redirect', function() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['debug']) && $_POST['debug'] === 'from_contact') {

        // ★ ここが重要：POST をセッションに保存する
        $_SESSION['contact'] = [
            'lname'   => sanitize_text_field($_POST['lname']),
            'email'   => sanitize_email($_POST['email']),
            'message' => sanitize_textarea_field($_POST['message']),
        ];

        wp_redirect(home_url('/wp/check/'));
        exit;
    }
});


// 最終送信処理
add_action('template_redirect', function() {

    // 送信ボタンが押されたとき（debug がない POST）
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['debug'])) {

        // セッションからデータ取得
        $data = $_SESSION['contact'] ?? null;

        if (!$data) {
            // セッションが切れていたら contact に戻す
            wp_redirect(home_url('/wp/contact/'));
            exit;
        }

        // メール送信
        $to      = 'motonari75@gmail.com'; // ← 送信先
        $subject = 'お問い合わせが届きました';
        $body    =
            "お名前: {$data['lname']}\n" .
            "メール: {$data['email']}\n" .
            "内容:\n{$data['message']}\n";

        $headers = ['Content-Type: text/plain; charset=UTF-8'];

        wp_mail($to, $subject, $body, $headers);

        // セッション削除
        unset($_SESSION['contact']);

        // 完了ページへリダイレクト
        wp_redirect(home_url('/wp/thanks/'));
        exit;
    }
});


add_action( 'init', function() {
    register_block_pattern(
        'mytheme/hero-section',
        [
            'title'       => __( 'Hero セクション', 'mytheme' ),
            'description' => __( '大きな見出しとボタンを含むヒーローエリア', 'mytheme' ),
            'content'     => '
                <!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"}}}} -->
                <div class="wp-block-group alignfull" style="padding-top:80px;padding-bottom:80px;">
                    <!-- wp:heading {"textAlign":"center","level":1} -->
                    <h1 class="has-text-align-center">キャッチコピー</h1>
                    <!-- /wp:heading -->

                    <!-- wp:paragraph {"align":"center"} -->
                    <p class="has-text-align-center">説明文がここに入ります。</p>
                    <!-- /wp:paragraph -->

                    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
                    <div class="wp-block-buttons">
                        <!-- wp:button -->
                        <div class="wp-block-button"><a class="wp-block-button__link">詳しく見る</a></div>
                        <!-- /wp:button -->
                    </div>
                    <!-- /wp:buttons -->
                </div>
                <!-- /wp:group -->
            ',
        ]
    );
});

register_block_pattern_category(
    'mytheme-sections',
    [ 'label' => __( 'MyTheme セクション', 'mytheme' ) ]
);

add_action( 'after_setup_theme', function() {
    add_theme_support( 'block-patterns' );
});

// ブロックエディターにCSSを読みこむ
add_action('after_setup_theme', 'my_editor_support');
function my_editor_support(){
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');
}

