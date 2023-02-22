/*
SQLyog Community v13.1.6 (64 bit)
MySQL - 10.4.22-MariaDB : Database - quiz
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `company_table` */

DROP TABLE IF EXISTS `company_table`;

CREATE TABLE `company_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `項目` varchar(255) DEFAULT NULL,
  `会社名` varchar(255) DEFAULT NULL,
  `役職` varchar(255) DEFAULT NULL,
  `氏名` varchar(255) DEFAULT NULL,
  `メールアドレス` varchar(255) DEFAULT NULL,
  `電話番号` varchar(255) DEFAULT NULL,
  `パスワード` varchar(255) DEFAULT NULL,
  `興味のあるサービス` text DEFAULT NULL,
  `希望内容` text DEFAULT NULL,
  `サービスを知ったきっかけ` text DEFAULT NULL,
  `その他の方は記入ください` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `company_table` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `management_quiz_table` */

DROP TABLE IF EXISTS `management_quiz_table`;

CREATE TABLE `management_quiz_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `項目` text DEFAULT NULL,
  `回答項目` text DEFAULT NULL,
  `提案NO` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

/*Data for the table `management_quiz_table` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'2014_10_12_000000_create_users_table',1),
(2,'2014_10_12_100000_create_password_resets_table',1),
(3,'2018_08_08_100000_create_telescope_entries_table',1),
(4,'2019_08_19_000000_create_failed_jobs_table',1),
(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
(6,'2023_01_04_022441_create_upload1',1),
(7,'2023_01_08_035008_create_upload_ex1',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `personal_access_tokens` */

DROP TABLE IF EXISTS `personal_access_tokens`;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `personal_access_tokens` */

/*Table structure for table `quiz_result` */

DROP TABLE IF EXISTS `quiz_result`;

CREATE TABLE `quiz_result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `quiz` text DEFAULT NULL,
  `quiz1` text DEFAULT NULL,
  `quiz2` text DEFAULT NULL,
  `quiz3` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

/*Data for the table `quiz_result` */

insert  into `quiz_result`(`id`,`user_id`,`type`,`quiz`,`quiz1`,`quiz2`,`quiz3`,`created_at`,`status`) values 
(35,7,NULL,NULL,NULL,NULL,'現状確認-1-1-1,現状確認-1-2-1,現状確認-1-3-1, 現状確認-2-1-1,現状確認-2-2-1,現状確認-2-3-1, 現状確認-3-2-1,現状確認-3-3-1,現状確認-3-1-1',NULL,0);

/*Table structure for table `recruiment_quiz_table` */

DROP TABLE IF EXISTS `recruiment_quiz_table`;

CREATE TABLE `recruiment_quiz_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `項目` varchar(255) DEFAULT NULL,
  `回答項目` text DEFAULT NULL,
  `提案NO` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4;

/*Data for the table `recruiment_quiz_table` */

insert  into `recruiment_quiz_table`(`id`,`項目`,`回答項目`,`提案NO`,`created_at`,`status`) values 
(1,'職種適正','スピード感のある仕事がしたい,じっくり考えて丁寧な仕事がしたい','1',NULL,0),
(2,'職種適正','プレッシャーやタフさには自信がある,期待されすぎると病んでしまう','2',NULL,0),
(3,'職種適正','人と相談しながら問題解決することが好きだ,黙々と指示された作業をすることが好きだ','3',NULL,0),
(4,'職種適正','自主的に自宅で勉強できるほうだ,強制されないと頑張れない','4',NULL,0),
(5,'職種適正','将来独立・起業したい,安定して正社員として働きたい','5',NULL,0),
(6,'職種適正','数学や論理式を学習することが苦にならない,仕組みを作ることは苦手','6',NULL,0),
(7,'職種適正','最低年収1000万以上目指したい,収入はある程度あれば良い','7',NULL,0),
(8,'職種適正','技術へのこだわりは特にない,開発・技術に携わりたい','8',NULL,0),
(9,'企業適正','会社の事業に携わって成長したい,仕事は生活のためと割り切っている','1',NULL,0),
(10,'企業適正','周りと上手く合わせることが得意,周りと上手く合わせることが苦手','2',NULL,0),
(11,'企業適正','指示された業務を確実にこなしていきたい,一人で設計～開発全部に携わる仕事がしたい','3',NULL,0),
(12,'企業適正','企業システムや自動化ツールに興味がある,消費者の動向などに興味がある','4',NULL,0),
(13,'企業適正','実務経験を早く積んで技術取得したい,自社の先輩達に囲まれて教育されたい','5',NULL,0),
(14,'企業適正','人間関係は固定されているのが理想,就業先が定期的に変わっても抵抗なし','6',NULL,0),
(15,'企業適正','うつ病になったことがある,精神病は一回もない','7',NULL,0),
(16,'現状確認','Excel関数・VBAは調べればできる,Excelはあまり自信がない','1-1',NULL,0),
(17,'現状確認','パワポで資料作成したことがある,パワポを使用したことがない','1-2',NULL,0),
(18,'現状確認','リーダーもしくは管理業務経験がある,リーダー系の業務経験はない','1-3',NULL,0),
(19,'現状確認','一人でツールなど開発経験がある,一人で開発経験はない','2-1',NULL,0),
(20,'現状確認','基本的なWEBアーキテクチャがわかる,画面～DB周りのイメージが湧かない','2-2',NULL,0),
(23,'現状確認','関東圏遠方に引っ越して就業可能,引っ越し不可','3-2',NULL,0),
(24,'現状確認','電話対応は苦にならない,人と意思疎通が苦手','3-3',NULL,0),
(21,'現状確認','IF、for、intが理解できる,論理式のイメージが湧かない','2-3',NULL,0),
(22,'現状確認','夜勤勤務可能,夜勤勤務不可','3-1',NULL,0);

/*Table structure for table `result` */

DROP TABLE IF EXISTS `result`;

CREATE TABLE `result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `sub_type` text DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/*Data for the table `result` */

insert  into `result`(`id`,`type`,`sub_type`,`url`,`status`,`created_at`) values 
(1,'Sierページ','','https://result.engineermatch.net/sier/',0,'2023-02-20 10:49:02'),
(2,'Webページ','','https://result.engineermatch.net/web/',0,'2023-02-20 10:49:06'),
(3,'営業ページ','','https://result.engineermatch.net/sales/',0,'2023-02-20 10:49:09'),
(4,'事業会社ページ','','https://result.engineermatch.net/mc/',0,'2023-02-20 10:49:12'),
(5,'SESページ','','https://result.engineermatch.net/ses/',0,'2023-02-20 10:49:14'),
(6,'現状確認ページ','','https://result.engineermatch.net/status/',0,'2023-02-20 10:50:14'),
(7,NULL,'',NULL,0,NULL);

/*Table structure for table `sales_quiz_table` */

DROP TABLE IF EXISTS `sales_quiz_table`;

CREATE TABLE `sales_quiz_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `項目` text DEFAULT NULL,
  `回答項目` text DEFAULT NULL,
  `提案NO` int(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

/*Data for the table `sales_quiz_table` */

/*Table structure for table `upload1s` */

DROP TABLE IF EXISTS `upload1s`;

CREATE TABLE `upload1s` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `レコードID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `レコードタイプ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーンID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーン` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーンの1日の予算` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ポートフォリオID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーン開始日` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーン終了日` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーンターゲティングタイプ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `広告グループ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `入札額上限` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キーワードまたは商品ターゲティング` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `商品ターゲティングID` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `マッチタイプ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `キャンペーンステータス` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `広告グループステータス` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ステータス` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `インプレッション` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `クリック` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `広告費` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `注文数` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `商品点数の合計` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `売上` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ACOS` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `入札戦略` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `掲載枠タイプ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `掲載枠による入札額の引き上げ` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `upload1s` */

/*Table structure for table `upload_ex1s` */

DROP TABLE IF EXISTS `upload_ex1s`;

CREATE TABLE `upload_ex1s` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `SKU` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `注文商品売上` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `upload_ex1s` */

/*Table structure for table `user_table` */

DROP TABLE IF EXISTS `user_table`;

CREATE TABLE `user_table` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `項目` varchar(255) DEFAULT NULL,
  `会社名` varchar(255) DEFAULT NULL,
  `氏名` varchar(255) DEFAULT NULL,
  `メールアドレス` varchar(255) DEFAULT NULL,
  `イニシャル名字` varchar(255) DEFAULT NULL,
  `イニシャル名前` varchar(255) DEFAULT NULL,
  `パスワード` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `user_table` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initName_f` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `initName_l` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fav_task` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hop_content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `knw_case` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pwd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`role`,`company`,`pos`,`name`,`initName_f`,`initName_l`,`email`,`email_verified_at`,`phone`,`fav_task`,`hop_content`,`knw_case`,`others`,`password`,`pwd`,`remember_token`,`created_at`,`updated_at`,`status`) values 
(7,'recruiment',NULL,NULL,'aimi',NULL,NULL,'admin@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,'$2y$10$WiYQsGPHNOTfPklQXGZ8xuWeghwNI8KOp.1tKr3wInB9fVgfATGZu','123456789',NULL,'2023-02-20 09:26:19','2023-02-20 09:26:19',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
