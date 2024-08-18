<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * データベース設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** データベース設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'zuttomo_wp5' );

/** データベースのユーザー名 */
define( 'DB_USER', 'zuttomo_wp5' );

/** データベースのパスワード */
define( 'DB_PASSWORD', '24gx49dnay' );

/** データベースのホスト名 */
define( 'DB_HOST', 'mysql8023.xserver.jp' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'l02d)eBG>s18=Ebb7, }`$Xws=N9/>qSs4{%x$6a8mgr5[E6&P<})KwE=c_Uc^(S' );
define( 'SECURE_AUTH_KEY',  '_Y}x6!@gg}+TC1=!ND>l%hcT5P44pWNWXMvtMR&,8 L9VP[j)1Rl8ds j252XC-4' );
define( 'LOGGED_IN_KEY',    's$v5{uz;0o&jaR0O2<ic7GSxL3FRCl5x5F])O)WfOJ#_*@X`&P//&Ku3q]m|gnlu' );
define( 'NONCE_KEY',        'rXEnbkd/+1yn293SCwE$fXdiVg<whhlqwGc#8{(FlWngQxaNfk2gQ MYZMJU]KCX' );
define( 'AUTH_SALT',        'O:Up@+)$V8@M:M_&nJ`kZVsC.n%|VR99jrMF,s!wKl[jA#5.#SeESO0$51e#Yt+C' );
define( 'SECURE_AUTH_SALT', 'ibn|lW`Y^l[JYky5ossX~W0e/J+=|ATQToubJHf:Y`nBl2DD9U{>C/?5qe?6e)$R' );
define( 'LOGGED_IN_SALT',   '=zg?YWm~2[S,,-:_L:bc&*fiRlogtzd[m dkUdC(EOjK$x1SyQCsFrDfjVuv_mSg' );
define( 'NONCE_SALT',       '!5I:WS:]aZ4EY!*8RlId[qBz{~.Z^4DyNnn^Sm2c<-z#9Hr|MoHUNL*~{Z bNi&1' );
define( 'WP_CACHE_KEY_SALT','ufFk0!26RZ/6jHIsEii/R`/MMA:!=04nwc-X=HPNAW;b0eUUg8~p0pl1Ktkxxcj$' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* カスタム値は、この行と「編集が必要なのはここまでです」の行の間に追加してください。 */



/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
