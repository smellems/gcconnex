-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2015 at 08:46 PM
-- Server version: 5.6.27-0ubuntu1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gcconnexdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `elgg_access_collections`
--

DROP TABLE IF EXISTS `elgg_access_collections`;
CREATE TABLE IF NOT EXISTS `elgg_access_collections` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `owner_guid` bigint(20) unsigned NOT NULL,
  `site_guid` bigint(20) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_access_collections`
--

INSERT INTO `elgg_access_collections` (`id`, `name`, `owner_guid`, `site_guid`) VALUES
(3, 'Group: Un groupe - A Group', 117, 1);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_access_collection_membership`
--

DROP TABLE IF EXISTS `elgg_access_collection_membership`;
CREATE TABLE IF NOT EXISTS `elgg_access_collection_membership` (
  `user_guid` int(11) NOT NULL,
  `access_collection_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_access_collection_membership`
--

INSERT INTO `elgg_access_collection_membership` (`user_guid`, `access_collection_id`) VALUES
(97, 3);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_annotations`
--

DROP TABLE IF EXISTS `elgg_annotations`;
CREATE TABLE IF NOT EXISTS `elgg_annotations` (
  `id` int(11) NOT NULL,
  `entity_guid` bigint(20) unsigned NOT NULL,
  `name_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `value_type` enum('integer','text') NOT NULL,
  `owner_guid` bigint(20) unsigned NOT NULL,
  `access_id` int(11) NOT NULL,
  `time_created` int(11) NOT NULL,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_annotations`
--

INSERT INTO `elgg_annotations` (`id`, `entity_guid`, `name_id`, `value_id`, `value_type`, `owner_guid`, `access_id`, `time_created`, `enabled`) VALUES
(1, 139, 110, 109, 'text', 97, 0, 1448631109, 'yes'),
(2, 139, 110, 115, 'text', 97, 0, 1448631734, 'yes'),
(3, 142, 124, 124, 'text', 97, 1, 1449541522, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_api_users`
--

DROP TABLE IF EXISTS `elgg_api_users`;
CREATE TABLE IF NOT EXISTS `elgg_api_users` (
  `id` int(11) NOT NULL,
  `site_guid` bigint(20) unsigned DEFAULT NULL,
  `api_key` varchar(40) DEFAULT NULL,
  `secret` varchar(40) NOT NULL,
  `active` int(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elgg_config`
--

DROP TABLE IF EXISTS `elgg_config`;
CREATE TABLE IF NOT EXISTS `elgg_config` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `site_guid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_config`
--

INSERT INTO `elgg_config` (`name`, `value`, `site_guid`) VALUES
('view', 's:7:"default";', 1),
('language', 's:2:"fr";', 1),
('default_access', 's:1:"1";', 1),
('allow_registration', 'b:1;', 1),
('walled_garden', 'b:0;', 1),
('allow_user_default_access', 'b:0;', 1),
('default_limit', 'i:25;', 1),
('search_ft_min_word_len', 's:1:"4";', 1),
('search_ft_max_word_len', 's:2:"84";', 1),
('simplecache_minify_js', 'b:1;', 1),
('simplecache_minify_css', 'b:1;', 1),
('site_featured_menu_names', 'a:6:{i:0;s:8:"activity";i:1;s:4:"blog";i:2;s:6:"groups";i:3;s:7:"thewire";i:4;s:7:"members";i:5;s:9:"dashboard";}', 1),
('site_custom_menu_items', 'a:0:{}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_datalists`
--

DROP TABLE IF EXISTS `elgg_datalists`;
CREATE TABLE IF NOT EXISTS `elgg_datalists` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_datalists`
--

INSERT INTO `elgg_datalists` (`name`, `value`) VALUES
('installed', '1447809797'),
('dataroot', '/home/smel2990/gcconnexdata/'),
('default_site', '1'),
('version', '2015041400'),
('simplecache_enabled', '0'),
('system_cache_enabled', '0'),
('simplecache_lastupdate', '1449591887'),
('path', '/home/smel2990/public_html/pchgc.ca/dev/gcconnex/'),
('processed_upgrades', 'a:62:{i:0;s:14:"2008100701.php";i:1;s:14:"2008101303.php";i:2;s:14:"2009022701.php";i:3;s:14:"2009041701.php";i:4;s:14:"2009070101.php";i:5;s:14:"2009102801.php";i:6;s:14:"2010010501.php";i:7;s:14:"2010033101.php";i:8;s:14:"2010040201.php";i:9;s:14:"2010052601.php";i:10;s:14:"2010060101.php";i:11;s:14:"2010060401.php";i:12;s:14:"2010061501.php";i:13;s:14:"2010062301.php";i:14;s:14:"2010062302.php";i:15;s:14:"2010070301.php";i:16;s:14:"2010071001.php";i:17;s:14:"2010071002.php";i:18;s:14:"2010111501.php";i:19;s:14:"2010121601.php";i:20;s:14:"2010121602.php";i:21;s:14:"2010121701.php";i:22;s:14:"2010123101.php";i:23;s:14:"2011010101.php";i:24;s:61:"2011021800-1.8_svn-goodbye_walled_garden-083121a656d06894.php";i:25;s:61:"2011022000-1.8_svn-custom_profile_fields-390ac967b0bb5665.php";i:26;s:60:"2011030700-1.8_svn-blog_status_metadata-4645225d7b440876.php";i:27;s:51:"2011031300-1.8_svn-twitter_api-12b832a5a7a3e1bd.php";i:28;s:57:"2011031600-1.8_svn-datalist_grows_up-0b8aec5a55cc1e1c.php";i:29;s:61:"2011032000-1.8_svn-widgets_arent_plugins-61836261fa280a5c.php";i:30;s:59:"2011032200-1.8_svn-admins_like_widgets-7f19d2783c1680d3.php";i:31;s:14:"2011052801.php";i:32;s:60:"2011061200-1.8b1-sites_need_a_site_guid-6d9dcbf46c0826cc.php";i:33;s:62:"2011092500-1.8.0.1-forum_reply_river_view-5758ce8d86ac56ce.php";i:34;s:54:"2011123100-1.8.2-fix_friend_river-b17e7ff8345c2269.php";i:35;s:53:"2011123101-1.8.2-fix_blog_status-b14c2a0e7b9e7d55.php";i:36;s:50:"2012012000-1.8.3-ip_in_syslog-87fe0f068cf62428.php";i:37;s:50:"2012012100-1.8.3-system_cache-93100e7d55a24a11.php";i:38;s:59:"2012041800-1.8.3-dont_filter_passwords-c0ca4a18b38ae2bc.php";i:39;s:58:"2012041801-1.8.3-multiple_user_tokens-852225f7fd89f6c5.php";i:40;s:59:"2013010200-1.9.0_dev-river_target_guid-66cbcae057cfa3ad.php";i:41;s:62:"2013010400-1.9.0_dev-comments_to_entities-faba94768b055b08.php";i:42;s:61:"2013021000-1.9.0_dev-web_services_plugin-85a61b4884b9b9e3.php";i:43;s:60:"2013022000-1.9.0-datadir_dates_to_guids-efb02ff11b9d6444.php";i:44;s:59:"2013030600-1.8.13-update_user_location-8999eb8bf1bdd9a3.php";i:45;s:62:"2013051700-1.8.15-add_missing_group_index-52a63a3a3ffaced2.php";i:46;s:53:"2013052900-1.8.15-ipv6_in_syslog-f5c2cc0196e9e731.php";i:47;s:50:"2013060900-1.8.15-site_secret-404fc165cf9e0ac9.php";i:48;s:63:"2013062200-1.9.0_dev-new_remember_me_table-da1bfc6f36c7952e.php";i:49;s:54:"2013062700-1.9.0_dev-add_db_queue-e6af82afc6d3eee3.php";i:50;s:50:"2014012000-1.8.18-remember_me-9a8a433685cf7be9.php";i:51;s:61:"2014031100-1.9.0_dev-elgg_upgrade_object-5577af53c93abd1a.php";i:52;s:55:"2014032200-1.9.0_dev-tinymce_to_ck-bbd2daa1912deaef.php";i:53;s:60:"2014042500-1.9.0_dev-site-notifications-0aae171afb7a00d8.php";i:54;s:61:"2014050600-1.9.0_dev-replies_to_entities-094ea0e36bc027d3.php";i:55;s:60:"2014070600-1.9.0_rc.3-river_enabled_col-bef9e6f0533ac338.php";i:56;s:60:"2014090900-1.9.0-fix_processed_upgrades-183ad189c71872d8.php";i:57;s:62:"2014111600-1.9.4-recheck_comments_upgrade-9da270072a5b0cad.php";i:58;s:58:"2014111800-1.10.0-add_new_hash_column-536087bbb2dbc82b.php";i:59;s:56:"2014130300-1.10.0-add_default_limit-fcef9e7ce01e26a4.php";i:60;s:62:"2015031300-1.11.0_dev-comment-access-sync-50c9764e5845315c.php";i:61;s:59:"2015041400-1.11.0_dev-trim_metastrings-d9a9fdfa28a981a3.php";}'),
('admin_registered', '1'),
('__site_secret__', 'zXOHLsyWWC95CmYWlLf6Oo_Wj5xqrOYp'),
('phloor_logo_manager_run_function_once', '1447857633'),
('te_last_update_en', '1447859023'),
('hj_forum_1358206168', '1447890323'),
('hj_forum_1358285155', '1447890323'),
('hj_forum_1359738428', '1447890323'),
('hj_forum_1360277917', '1447890323'),
('hj_forum_1360948016', '1447890323'),
('hj_forum_1360948621', '1447890323'),
('hj_forum_1361379905', '1447890323'),
('hj_forum_1372438394', '1447890323'),
('te_last_update_de', '1447941120'),
('te_last_update_pl', '1447941121'),
('te_last_update_fi', '1447941121'),
('te_last_update_it', '1447941121'),
('te_last_update_ja', '1447941121'),
('te_last_update_ru', '1447941121'),
('te_last_update_gl', '1447941122'),
('te_last_update_fr', '1447941122'),
('te_last_update_pt_br', '1447941122'),
('te_last_update_es', '1447941122'),
('te_last_update_nl', '1447941123'),
('te_last_update_ko', '1447941123'),
('te_last_update_da', '1447941123'),
('te_last_update_eu_es', '1447941123'),
('te_last_update_cmn', '1447941124'),
('te_last_update_ca', '1447941124'),
('te_last_update_sr', '1447941124'),
('te_last_update_el', '1447941124'),
('te_last_update_ro_ro', '1447941125'),
('te_last_update_tr', '1447941125'),
('te_last_update_zh_hans', '1447941125'),
('te_last_update_sr_latin', '1447941125'),
('te_last_update_fa', '1447941125'),
('te_last_update_ar', '1447941126'),
('AU\\SubGroups\\upgrade20150912', '1448981443'),
('AU\\ActivityTabs\\upgrade20151017', '1448981445');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_entities`
--

DROP TABLE IF EXISTS `elgg_entities`;
CREATE TABLE IF NOT EXISTS `elgg_entities` (
  `guid` bigint(20) unsigned NOT NULL,
  `type` enum('object','user','group','site') NOT NULL,
  `subtype` int(11) DEFAULT NULL,
  `owner_guid` bigint(20) unsigned NOT NULL,
  `site_guid` bigint(20) unsigned NOT NULL,
  `container_guid` bigint(20) unsigned NOT NULL,
  `access_id` int(11) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  `last_action` int(11) NOT NULL DEFAULT '0',
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_entities`
--

INSERT INTO `elgg_entities` (`guid`, `type`, `subtype`, `owner_guid`, `site_guid`, `container_guid`, `access_id`, `time_created`, `time_updated`, `last_action`, `enabled`) VALUES
(1, 'site', 0, 0, 1, 0, 2, 1447809797, 1447940393, 1447809797, 'yes'),
(2, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(3, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(4, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(5, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(6, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(7, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(8, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(9, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(10, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(11, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(12, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(13, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(14, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(15, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(16, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'no'),
(17, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(18, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(19, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'no'),
(20, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(21, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(22, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(23, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(24, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(25, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(26, 'object', 1, 1, 1, 1, 2, 1447809797, 1447809797, 1447809797, 'yes'),
(27, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(28, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(29, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(30, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(31, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(32, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(33, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(34, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(35, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(36, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(37, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(38, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(39, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(40, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(41, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(42, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(43, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(44, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(45, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(46, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(47, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(48, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(49, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(50, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(51, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(52, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(53, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(54, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(55, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(56, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(57, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(58, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(59, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(60, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(61, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(62, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(63, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(64, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(65, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(66, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(67, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(68, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(69, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(70, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(71, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(72, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(73, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'no'),
(74, 'object', 1, 1, 1, 1, 2, 1447809798, 1447809798, 1447809798, 'yes'),
(75, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(76, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'no'),
(77, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(78, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(79, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(80, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(81, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(82, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(83, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(84, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(85, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(86, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(87, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(88, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(89, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(90, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(91, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(92, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(93, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(94, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(95, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(96, 'object', 1, 1, 1, 1, 2, 1447809799, 1447809799, 1447809799, 'yes'),
(97, 'user', 0, 0, 1, 0, 2, 1447809853, 1448026524, 1448542325, 'yes'),
(98, 'object', 3, 97, 1, 97, 0, 1447809854, 1447809854, 1447809854, 'yes'),
(99, 'object', 3, 97, 1, 97, 0, 1447809854, 1447809854, 1447809854, 'yes'),
(100, 'object', 3, 97, 1, 97, 0, 1447809854, 1447809854, 1447809854, 'yes'),
(101, 'object', 3, 97, 1, 97, 0, 1447809854, 1447809854, 1447809854, 'yes'),
(102, 'object', 3, 97, 1, 97, 0, 1447809854, 1447809854, 1447809854, 'yes'),
(116, 'object', 10, 97, 1, 97, 0, 1448026144, 1448026144, 1448026144, 'yes'),
(108, 'object', 1, 1, 1, 1, 2, 1448024751, 1448024751, 1448024751, 'no'),
(109, 'object', 1, 1, 1, 1, 2, 1448024752, 1448024752, 1448024752, 'yes'),
(110, 'object', 1, 1, 1, 1, 2, 1448024752, 1448024752, 1448024752, 'yes'),
(111, 'object', 1, 1, 1, 1, 2, 1448024752, 1448024752, 1448024752, 'yes'),
(112, 'object', 1, 1, 1, 1, 2, 1448024752, 1448024752, 1448024752, 'no'),
(118, 'object', 2, 97, 1, 117, 1, 1448026970, 1449582596, 1448027630, 'yes'),
(117, 'group', 0, 97, 1, 97, 2, 1448026781, 1448590898, 1448026781, 'yes'),
(134, 'object', 29, 97, 1, 97, 2, 1448545438, 1448549276, 1448545438, 'yes'),
(121, 'object', 4, 97, 1, 118, 1, 1448027630, 1448027630, 1448027630, 'yes'),
(122, 'user', 0, 0, 1, 0, 2, 1448389666, 1448389666, 1448389666, 'yes'),
(123, 'object', 3, 122, 1, 122, 1, 1448389666, 1448389666, 1448389666, 'yes'),
(124, 'object', 3, 122, 1, 122, 1, 1448389666, 1448389666, 1448389666, 'yes'),
(125, 'object', 3, 122, 1, 122, 1, 1448389666, 1448389666, 1448389666, 'yes'),
(126, 'object', 3, 122, 1, 122, 1, 1448389666, 1448389666, 1448389666, 'yes'),
(127, 'object', 3, 122, 1, 122, 1, 1448389666, 1448389666, 1448389666, 'yes'),
(128, 'user', 0, 0, 1, 0, 2, 1448389719, 1448389719, 1448390201, 'yes'),
(129, 'object', 3, 128, 1, 128, 1, 1448389719, 1448389719, 1448389719, 'yes'),
(130, 'object', 3, 128, 1, 128, 1, 1448389719, 1448389719, 1448389719, 'yes'),
(131, 'object', 3, 128, 1, 128, 1, 1448389719, 1448389719, 1448389719, 'yes'),
(132, 'object', 3, 128, 1, 128, 1, 1448389719, 1448389719, 1448389719, 'yes'),
(133, 'object', 3, 128, 1, 128, 1, 1448389719, 1448389719, 1448389719, 'yes'),
(138, 'object', 6, 97, 1, 117, 0, 1448590999, 1448590999, 1448590999, 'yes'),
(136, 'object', 1, 1, 1, 1, 2, 1448589816, 1448589816, 1448589816, 'yes'),
(137, 'object', 1, 1, 1, 1, 2, 1448589816, 1448589816, 1448589816, 'yes'),
(139, 'object', 6, 97, 1, 97, 2, 1448631734, 1448631734, 1448631734, 'yes'),
(140, 'object', 1, 1, 1, 1, 2, 1448972706, 1448972706, 1448972706, 'yes'),
(141, 'user', 0, 0, 1, 0, 2, 1449493835, 1449493835, 1449493835, 'yes'),
(142, 'object', 2, 141, 1, 141, 1, 1449502517, 1449541548, 1449502517, 'yes'),
(144, 'object', 1, 1, 1, 1, 2, 1449541380, 1449541380, 1449541380, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_entity_relationships`
--

DROP TABLE IF EXISTS `elgg_entity_relationships`;
CREATE TABLE IF NOT EXISTS `elgg_entity_relationships` (
  `id` int(11) NOT NULL,
  `guid_one` bigint(20) unsigned NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `guid_two` bigint(20) unsigned NOT NULL,
  `time_created` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_entity_relationships`
--

INSERT INTO `elgg_entity_relationships` (`id`, `guid_one`, `relationship`, `guid_two`, `time_created`) VALUES
(38, 71, 'active_plugin', 1, 1447853337),
(47, 28, 'active_plugin', 1, 1447856686),
(3, 9, 'active_plugin', 1, 1447809799),
(4, 11, 'active_plugin', 1, 1447809799),
(81, 5, 'active_plugin', 1, 1447946163),
(6, 29, 'active_plugin', 1, 1447809799),
(7, 33, 'active_plugin', 1, 1447809799),
(8, 36, 'active_plugin', 1, 1447809799),
(9, 43, 'active_plugin', 1, 1447809799),
(10, 45, 'active_plugin', 1, 1447809799),
(11, 48, 'active_plugin', 1, 1447809799),
(12, 49, 'active_plugin', 1, 1447809799),
(13, 51, 'active_plugin', 1, 1447809799),
(14, 52, 'active_plugin', 1, 1447809799),
(15, 54, 'active_plugin', 1, 1447809799),
(16, 56, 'active_plugin', 1, 1447809800),
(17, 57, 'active_plugin', 1, 1447809800),
(18, 58, 'active_plugin', 1, 1447809800),
(19, 61, 'active_plugin', 1, 1447809800),
(20, 63, 'active_plugin', 1, 1447809800),
(21, 70, 'active_plugin', 1, 1447809800),
(22, 72, 'active_plugin', 1, 1447809800),
(74, 83, 'active_plugin', 1, 1447890614),
(24, 74, 'active_plugin', 1, 1447809800),
(25, 81, 'active_plugin', 1, 1447809800),
(26, 88, 'active_plugin', 1, 1447809800),
(27, 90, 'active_plugin', 1, 1447809800),
(28, 91, 'active_plugin', 1, 1447809800),
(98, 140, 'active_plugin', 1, 1448972855),
(30, 97, 'member_of_site', 1, 1447809853),
(31, 42, 'active_plugin', 1, 1447810310),
(32, 7, 'active_plugin', 1, 1447810422),
(33, 12, 'active_plugin', 1, 1447810693),
(34, 8, 'active_plugin', 1, 1447810732),
(100, 3, 'active_plugin', 1, 1449497317),
(36, 92, 'active_plugin', 1, 1447810960),
(39, 31, 'active_plugin', 1, 1447853385),
(42, 22, 'active_plugin', 1, 1447854852),
(43, 21, 'active_plugin', 1, 1447855247),
(44, 23, 'active_plugin', 1, 1447855392),
(45, 24, 'active_plugin', 1, 1447855557),
(48, 41, 'active_plugin', 1, 1447856943),
(49, 60, 'active_plugin', 1, 1447857240),
(53, 69, 'active_plugin', 1, 1447857648),
(54, 80, 'active_plugin', 1, 1447858150),
(55, 84, 'active_plugin', 1, 1447858201),
(56, 94, 'active_plugin', 1, 1447858398),
(57, 89, 'active_plugin', 1, 1447858481),
(58, 39, 'active_plugin', 1, 1447858552),
(73, 59, 'active_plugin', 1, 1447890466),
(60, 30, 'active_plugin', 1, 1447858617),
(61, 26, 'active_plugin', 1, 1447858686),
(62, 53, 'active_plugin', 1, 1447858827),
(63, 44, 'active_plugin', 1, 1447858878),
(64, 55, 'active_plugin', 1, 1447858939),
(65, 85, 'active_plugin', 1, 1447859018),
(66, 78, 'active_plugin', 1, 1447859107),
(67, 34, 'active_plugin', 1, 1447859235),
(68, 35, 'active_plugin', 1, 1447859403),
(94, 109, 'active_plugin', 1, 1448590276),
(71, 86, 'active_plugin', 1, 1447862376),
(75, 38, 'active_plugin', 1, 1447892946),
(76, 77, 'active_plugin', 1, 1447893013),
(77, 95, 'active_plugin', 1, 1447893054),
(84, 111, 'active_plugin', 1, 1448025132),
(79, 14, 'active_plugin', 1, 1447937065),
(80, 13, 'active_plugin', 1, 1447937471),
(83, 110, 'active_plugin', 1, 1448024933),
(93, 25, 'active_plugin', 1, 1448590126),
(86, 97, 'member', 117, 1448026781),
(87, 122, 'member_of_site', 1, 1448389666),
(88, 128, 'member_of_site', 1, 1448389719),
(89, 97, 'friendrequest', 122, 1448389768),
(91, 128, 'friend', 97, 1448390200),
(92, 97, 'friend', 128, 1448390200),
(96, 18, 'active_plugin', 1, 1448629773),
(99, 141, 'member_of_site', 1, 1449493835);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_entity_subtypes`
--

DROP TABLE IF EXISTS `elgg_entity_subtypes`;
CREATE TABLE IF NOT EXISTS `elgg_entity_subtypes` (
  `id` int(11) NOT NULL,
  `type` enum('object','user','group','site') NOT NULL,
  `subtype` varchar(50) NOT NULL,
  `class` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_entity_subtypes`
--

INSERT INTO `elgg_entity_subtypes` (`id`, `type`, `subtype`, `class`) VALUES
(1, 'object', 'plugin', 'ElggPlugin'),
(2, 'object', 'file', 'ElggFile'),
(3, 'object', 'widget', 'WidgetManagerWidget'),
(4, 'object', 'comment', 'ElggComment'),
(5, 'object', 'elgg_upgrade', 'ElggUpgrade'),
(6, 'object', 'blog', 'ElggBlog'),
(7, 'object', 'discussion_reply', 'ElggDiscussionReply'),
(8, 'object', 'thewire', 'ElggWire'),
(9, 'object', 'upload_users_file', 'UploadUsersFile'),
(10, 'object', 'admin_notice', ''),
(11, 'object', 'phloor_favicon', ''),
(12, 'object', 'phloor_topbar_logo', ''),
(13, 'object', 'multi_dashboard', 'MultiDashboard'),
(14, 'object', 'hjform', ''),
(15, 'object', 'hjfield', ''),
(16, 'object', 'hjfile', ''),
(17, 'object', 'hjfilefolder', ''),
(18, 'object', 'hjsegment', ''),
(19, 'object', 'hjannotation', ''),
(20, 'object', 'hjcategory', 'hjCategory'),
(21, 'object', 'hjforum', ''),
(22, 'object', 'hjforumtopic', ''),
(23, 'object', 'hjforumpost', ''),
(24, 'object', 'hjforumcategory', ''),
(25, 'object', 'album', 'TidypicsAlbum'),
(26, 'object', 'image', 'TidypicsImage'),
(27, 'object', 'tidypics_batch', 'TidypicsBatch'),
(28, 'object', 'site_notification', 'SiteNotification'),
(29, 'object', 'etherpad', '');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_geocode_cache`
--

DROP TABLE IF EXISTS `elgg_geocode_cache`;
CREATE TABLE IF NOT EXISTS `elgg_geocode_cache` (
  `id` int(11) NOT NULL,
  `location` varchar(128) DEFAULT NULL,
  `lat` varchar(20) DEFAULT NULL,
  `long` varchar(20) DEFAULT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elgg_groups_entity`
--

DROP TABLE IF EXISTS `elgg_groups_entity`;
CREATE TABLE IF NOT EXISTS `elgg_groups_entity` (
  `guid` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_groups_entity`
--

INSERT INTO `elgg_groups_entity` (`guid`, `name`, `description`) VALUES
(117, 'Un groupe - A Group', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ullamcorper sollicitudin dui id laoreet. Nam dignissim, urna ac cursus finibus, dui nisi dignissim ex, nec sodales massa ligula in enim. Suspendisse commodo ligula massa, non finibus lectus tincidunt vel. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus ac lobortis libero, ac pretium dui. Donec sed turpis tristique, hendrerit urna ut, varius justo. Donec luctus pulvinar quam ut mollis. Aliquam venenatis, augue et hendrerit porta, arcu dui fringilla turpis, ut elementum ante ligula at quam. Sed a gravida ligula. Integer eget maximus odio. Nulla eu diam ut mi tempor viverra. Nulla ut nisi lectus. Nullam consequat justo elit.</p>\r\n<p>----<br><br>Quisque mattis lacus vel rhoncus bibendum. Suspendisse euismod rhoncus turpis sed maximus. Vivamus aliquam velit eu risus consequat, et lacinia enim tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris elementum elit non tincidunt lobortis. Vivamus risus elit, congue ac blandit gravida, ultricies sit amet odio. Nam ac quam cursus, tincidunt augue non, feugiat enim. Phasellus efficitur sapien in enim egestas maximus. Nullam et feugiat ante. Ut sodales sodales mauris in sagittis. Sed nisl dui, aliquam et elit vel, ullamcorper tincidunt nunc. Nunc rhoncus lacus quam, quis porta dolor iaculis at. In volutpat ligula mi, id volutpat ex luctus in. Vestibulum vestibulum orci nunc, non porta mauris cursus a.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_hmac_cache`
--

DROP TABLE IF EXISTS `elgg_hmac_cache`;
CREATE TABLE IF NOT EXISTS `elgg_hmac_cache` (
  `hmac` varchar(255) NOT NULL,
  `ts` int(11) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elgg_metadata`
--

DROP TABLE IF EXISTS `elgg_metadata`;
CREATE TABLE IF NOT EXISTS `elgg_metadata` (
  `id` int(11) NOT NULL,
  `entity_guid` bigint(20) unsigned NOT NULL,
  `name_id` int(11) NOT NULL,
  `value_id` int(11) NOT NULL,
  `value_type` enum('integer','text') NOT NULL,
  `owner_guid` bigint(20) unsigned NOT NULL,
  `access_id` int(11) NOT NULL,
  `time_created` int(11) NOT NULL,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_metadata`
--

INSERT INTO `elgg_metadata` (`id`, `entity_guid`, `name_id`, `value_id`, `value_type`, `owner_guid`, `access_id`, `time_created`, `enabled`) VALUES
(1, 1, 1, 2, 'text', 0, 2, 1447809797, 'yes'),
(2, 97, 3, 4, 'text', 97, 2, 1447809853, 'yes'),
(3, 97, 5, 4, 'text', 0, 2, 1447809854, 'yes'),
(4, 97, 6, 7, 'text', 0, 2, 1447809854, 'yes'),
(20, 116, 8, 9, 'text', 97, 0, 1448026144, 'yes'),
(23, 117, 33, 35, 'text', 97, 2, 1448026781, 'yes'),
(11, 97, 20, 18, 'text', 97, 2, 1447811713, 'yes'),
(21, 117, 31, 32, 'text', 97, 2, 1448026781, 'yes'),
(22, 117, 33, 34, 'text', 97, 2, 1448026781, 'yes'),
(12, 97, 21, 18, 'text', 97, 2, 1447811713, 'yes'),
(13, 97, 22, 18, 'text', 97, 2, 1447811713, 'yes'),
(14, 97, 23, 18, 'text', 97, 2, 1447811713, 'yes'),
(15, 97, 24, 18, 'text', 97, 2, 1447811713, 'yes'),
(24, 117, 36, 37, 'text', 97, 2, 1448026781, 'yes'),
(25, 117, 38, 37, 'text', 97, 2, 1448026781, 'yes'),
(26, 117, 39, 40, 'text', 97, 2, 1448026781, 'yes'),
(27, 117, 41, 37, 'text', 97, 2, 1448026781, 'yes'),
(28, 117, 42, 37, 'text', 97, 2, 1448026781, 'yes'),
(29, 117, 43, 37, 'text', 97, 2, 1448026781, 'yes'),
(30, 117, 44, 37, 'text', 97, 2, 1448026781, 'yes'),
(84, 117, 45, 40, 'text', 97, 2, 1448590898, 'yes'),
(32, 117, 46, 37, 'text', 97, 2, 1448026781, 'yes'),
(85, 117, 47, 40, 'text', 97, 2, 1448590898, 'yes'),
(34, 117, 48, 37, 'text', 97, 2, 1448026781, 'yes'),
(35, 117, 49, 37, 'text', 97, 2, 1448026781, 'yes'),
(36, 117, 50, 37, 'text', 97, 2, 1448026781, 'yes'),
(37, 117, 51, 37, 'text', 97, 2, 1448026781, 'yes'),
(38, 117, 52, 37, 'text', 97, 2, 1448026781, 'yes'),
(39, 117, 53, 37, 'text', 97, 2, 1448026781, 'yes'),
(40, 117, 54, 37, 'text', 97, 2, 1448026781, 'yes'),
(41, 117, 55, 56, 'integer', 97, 2, 1448026781, 'yes'),
(42, 117, 57, 58, 'integer', 97, 2, 1448026781, 'yes'),
(43, 117, 59, 13, 'integer', 97, 2, 1448026784, 'yes'),
(44, 117, 60, 61, 'text', 97, 2, 1448026784, 'yes'),
(45, 118, 62, 34, 'text', 97, 1, 1448026970, 'yes'),
(46, 118, 62, 63, 'text', 97, 1, 1448026970, 'yes'),
(47, 118, 64, 65, 'text', 97, 1, 1448026970, 'yes'),
(48, 118, 66, 67, 'text', 97, 1, 1448026970, 'yes'),
(49, 118, 68, 69, 'text', 97, 1, 1448026970, 'yes'),
(50, 118, 70, 71, 'text', 97, 1, 1448026970, 'yes'),
(153, 118, 72, 73, 'text', 97, 1, 1449582596, 'yes'),
(154, 118, 74, 75, 'text', 97, 1, 1449582596, 'yes'),
(80, 134, 76, 98, 'text', 97, 2, 1448545438, 'yes'),
(81, 134, 78, 99, 'text', 97, 2, 1448545438, 'yes'),
(82, 134, 80, 11, 'text', 97, 2, 1448545438, 'yes'),
(59, 122, 3, 4, 'text', 122, 2, 1448389666, 'yes'),
(60, 122, 5, 4, 'text', 97, 2, 1448389666, 'yes'),
(61, 122, 6, 7, 'text', 97, 2, 1448389666, 'yes'),
(62, 122, 83, 4, 'text', 122, 2, 1448389666, 'yes'),
(63, 122, 84, 11, 'integer', 122, 2, 1448389666, 'yes'),
(64, 128, 3, 4, 'text', 128, 2, 1448389719, 'yes'),
(65, 128, 5, 4, 'text', 97, 2, 1448389719, 'yes'),
(66, 128, 6, 7, 'text', 97, 2, 1448389719, 'yes'),
(67, 128, 83, 4, 'text', 128, 2, 1448389719, 'yes'),
(68, 128, 84, 11, 'integer', 128, 2, 1448389719, 'yes'),
(76, 97, 86, 94, 'integer', 97, 2, 1448542325, 'yes'),
(77, 97, 87, 95, 'integer', 97, 2, 1448542325, 'yes'),
(78, 97, 88, 96, 'integer', 97, 2, 1448542325, 'yes'),
(79, 97, 89, 97, 'integer', 97, 2, 1448542325, 'yes'),
(75, 97, 59, 93, 'integer', 97, 2, 1448542325, 'yes'),
(74, 97, 91, 92, 'text', 97, 2, 1448542324, 'yes'),
(86, 138, 101, 102, 'text', 97, 0, 1448590999, 'yes'),
(87, 138, 103, 104, 'text', 97, 0, 1448590999, 'yes'),
(88, 138, 105, 106, 'text', 97, 0, 1448590999, 'yes'),
(89, 138, 107, 4, 'text', 97, 0, 1448590999, 'yes'),
(94, 139, 101, 111, 'text', 97, 2, 1448631734, 'yes'),
(91, 139, 103, 104, 'text', 97, 2, 1448631001, 'yes'),
(95, 139, 105, 112, 'text', 97, 2, 1448631734, 'yes'),
(93, 139, 107, 4, 'text', 97, 2, 1448631001, 'yes'),
(96, 139, 62, 34, 'text', 97, 2, 1448631734, 'yes'),
(97, 139, 62, 113, 'text', 97, 2, 1448631734, 'yes'),
(98, 139, 62, 114, 'text', 97, 2, 1448631734, 'yes'),
(109, 141, 3, 4, 'text', 141, 2, 1449493835, 'yes'),
(110, 141, 83, 4, 'text', 141, 2, 1449493835, 'yes'),
(111, 141, 84, 11, 'integer', 141, 2, 1449493835, 'yes'),
(118, 142, 62, 117, 'text', 141, 1, 1449502517, 'yes'),
(119, 142, 62, 118, 'text', 141, 1, 1449502517, 'yes'),
(120, 142, 62, 119, 'text', 141, 1, 1449502517, 'yes'),
(121, 142, 62, 120, 'text', 141, 1, 1449502517, 'yes'),
(122, 142, 64, 121, 'text', 141, 1, 1449502517, 'yes'),
(123, 142, 66, 122, 'text', 141, 1, 1449502517, 'yes'),
(124, 142, 68, 69, 'text', 141, 1, 1449502517, 'yes'),
(125, 142, 70, 71, 'text', 141, 1, 1449502517, 'yes'),
(145, 142, 72, 73, 'text', 141, 1, 1449541548, 'yes'),
(146, 142, 74, 75, 'text', 141, 1, 1449541548, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_metastrings`
--

DROP TABLE IF EXISTS `elgg_metastrings`;
CREATE TABLE IF NOT EXISTS `elgg_metastrings` (
  `id` int(11) NOT NULL,
  `string` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=125 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_metastrings`
--

INSERT INTO `elgg_metastrings` (`id`, `string`) VALUES
(1, 'email'),
(2, 'elgg@pchgc.ca'),
(3, 'notification:method:email'),
(4, '1'),
(5, 'validated'),
(6, 'validated_method'),
(7, 'admin_user'),
(8, 'admin_notice_id'),
(9, 'elgg:ws:1.9'),
(10, 'toId'),
(11, '97'),
(12, 'readYet'),
(13, '0'),
(14, 'msg'),
(15, 'email_invitation'),
(16, 'disable_reason'),
(17, 'uservalidationbyemail_new_user'),
(18, ''),
(19, '105'),
(20, 'job'),
(21, 'department'),
(22, 'location'),
(23, 'phone'),
(24, 'mobile'),
(25, 'translation_editor'),
(26, 'start_date'),
(27, 'end_date'),
(28, 'priority'),
(29, 'sticky'),
(30, 'cannot_start Facebook-Login-1.9-1.12'),
(31, 'briefdescription'),
(32, 'C''est un groupe - This is a group'),
(33, 'interests'),
(34, 'PCH'),
(35, 'Group'),
(36, 'activity_enable'),
(37, 'yes'),
(38, 'forum_enable'),
(39, 'related_groups_enable'),
(40, 'no'),
(41, 'blog_enable'),
(42, 'bookmarks_enable'),
(43, 'event_calendar_enable'),
(44, 'file_enable'),
(45, 'file_tools_structure_management_enable'),
(46, 'subgroups_enable'),
(47, 'subgroups_members_create_enable'),
(48, 'ideas_enable'),
(49, 'pages_enable'),
(50, 'polls_enable'),
(51, 'tasks_enable'),
(52, 'photos_enable'),
(53, 'tp_images_enable'),
(54, 'etherpad_enable'),
(55, 'membership'),
(56, '2'),
(57, 'group_acl'),
(58, '3'),
(59, 'icontime'),
(60, 'content_access_mode'),
(61, 'unrestricted'),
(62, 'tags'),
(63, 'WebODF'),
(64, 'filename'),
(65, 'file/1448026970webodf_test.odt'),
(66, 'originalfilename'),
(67, 'webODF_test.odt'),
(68, 'mimetype'),
(69, 'application/vnd.oasis.opendocument.text'),
(70, 'simpletype'),
(71, 'document'),
(72, 'filestore::dir_root'),
(73, '/home/smel2990/gcconnexdata/'),
(74, 'filestore::filestore'),
(75, 'ElggDiskFilestore'),
(76, 'url'),
(77, 'https://public.etherpad-mozilla.org//p/8qacskyyah'),
(78, 'objetive'),
(79, '<p>Collaborer sur un pad</p>'),
(80, 'group_guid'),
(81, 'https://public.etherpad-mozilla.org/p/8qacskyyah'),
(82, '<p>un pad - a pad</p>'),
(83, 'admin_created'),
(84, 'created_by_guid'),
(85, '128'),
(86, 'x1'),
(87, 'x2'),
(88, 'y1'),
(89, 'y2'),
(90, '1448542249'),
(91, 'active_badge'),
(92, 'none'),
(93, '1448542325'),
(94, '16'),
(95, '491'),
(96, '20'),
(97, '495'),
(98, 'https://beta.etherpad.org/p/3i2r3ltzzg'),
(99, '<p>Un nouveau pad sur Etherpad.org - A new pad on Etherpad.org</p>'),
(100, 'cannot_start webodf'),
(101, 'status'),
(102, 'draft'),
(103, 'comments_on'),
(104, 'On'),
(105, 'excerpt'),
(106, 'vidéo'),
(107, 'future_access'),
(108, 'Aweille Aweille Aweille Aweille Aweille Aweille Aweille Aweille'),
(109, '<p><cite>https://www.youtube.com/watch?v=E9osOjNww10</cite></p>'),
(110, 'blog_revision'),
(111, 'published'),
(112, 'Vidéo Aweille Aweille Aweille Aweille Aweille Aweille'),
(113, 'Video'),
(114, 'Embed'),
(115, '<p>Test un lien Youtube avec Embed Extender activ&eacute;.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><cite>https://www.youtube.com/watch?v=E9osOjNww10</cite></p>'),
(116, '141'),
(117, 'tests'),
(118, 'test'),
(119, 'sahben'),
(120, 'équipe'),
(121, 'file/1449502517fichiertest01.odt'),
(122, 'fichierTest01.odt'),
(123, 'cannot_start phloor_custom_logo'),
(124, 'likes');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_objects_entity`
--

DROP TABLE IF EXISTS `elgg_objects_entity`;
CREATE TABLE IF NOT EXISTS `elgg_objects_entity` (
  `guid` bigint(20) unsigned NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_objects_entity`
--

INSERT INTO `elgg_objects_entity` (`guid`, `title`, `description`) VALUES
(2, 'GoC_dev_banner', ''),
(3, 'aalborg_theme', ''),
(4, 'activity', ''),
(5, 'advanced_notifications', ''),
(6, 'analytics', ''),
(7, 'au_subgroups', ''),
(8, 'b_extended_profile', ''),
(9, 'blog', ''),
(10, 'blog_tools', ''),
(11, 'bookmarks', ''),
(12, 'c_email_extensions', ''),
(13, 'c_members_byDepartment', ''),
(14, 'c_module_dump', ''),
(15, 'c_notification_messages', ''),
(16, 'c_profile_changes', ''),
(17, 'categories', ''),
(18, 'ckeditor', ''),
(19, 'custom_index', ''),
(20, 'custom_index_widgets', ''),
(21, 'dashboard', ''),
(22, 'developers', ''),
(23, 'diagnostics', ''),
(24, 'elgg-bulk_user_admin', ''),
(25, 'embed', ''),
(26, 'event_calendar', ''),
(27, 'extended_tinymce', ''),
(28, 'externalpages', ''),
(29, 'file', ''),
(30, 'file_tools', ''),
(31, 'friend_request', ''),
(32, 'galliStatus', ''),
(33, 'garbagecollector', ''),
(34, 'gcProfilePictureBadges', ''),
(35, 'gcRegistration', ''),
(36, 'gc_api', ''),
(37, 'gc_glee_theme', ''),
(38, 'gc_group_deletion', ''),
(39, 'gc_help', ''),
(40, 'glee', ''),
(41, 'group_operators', ''),
(42, 'group_tools', ''),
(43, 'groups', ''),
(44, 'html_email_handler', ''),
(45, 'htmlawed', ''),
(46, 'hypeForum', ''),
(47, 'hypeFramework', ''),
(48, 'ideas', ''),
(49, 'invitefriends', ''),
(50, 'legacy_urls', ''),
(51, 'likes', ''),
(52, 'logbrowser', ''),
(53, 'login_as', ''),
(54, 'logrotate', ''),
(55, 'maintenance', ''),
(56, 'members', ''),
(57, 'messageboard', ''),
(58, 'messages', ''),
(59, 'mobilize', ''),
(60, 'msoffice_mime_types_patch', ''),
(61, 'notifications', ''),
(62, 'oauth_api', ''),
(63, 'pages', ''),
(64, 'phloor', ''),
(65, 'phloor_custom_favicon', ''),
(66, 'phloor_custom_logo', ''),
(67, 'phloor_custom_topbar_logo', ''),
(68, 'phloor_logo_manager', ''),
(69, 'polls', ''),
(70, 'profile', ''),
(71, 'rename_friends', ''),
(72, 'reportedcontent', ''),
(73, 'saml_link', ''),
(74, 'search', ''),
(75, 'set_no_notifications', ''),
(76, 'simplesaml', ''),
(77, 'site_notifications', ''),
(78, 'sphinx', ''),
(79, 'tagcloud', ''),
(80, 'tasks', ''),
(81, 'thewire', ''),
(82, 'thewire_tools', ''),
(83, 'tidypics', ''),
(84, 'toggle_language', ''),
(85, 'translation_editor', ''),
(86, 'twitter', ''),
(87, 'twitter_api', ''),
(88, 'unvalidated_user_cleanup', ''),
(89, 'unvalidatedemailchange', ''),
(90, 'upload_users', ''),
(91, 'uservalidationbyemail', ''),
(92, 'web_services', ''),
(93, 'wet4', ''),
(94, 'widget_manager', ''),
(95, 'widget_manager_accessibility', ''),
(96, 'zaudio', ''),
(98, '', ''),
(99, '', ''),
(100, '', ''),
(101, '', ''),
(102, '', ''),
(116, '', 'The web services are now a plugin in Elgg 1.9.\n			You must enable this plugin and update your web services to use elgg_ws_expose_function().'),
(108, 'Facebook-Login-1.9-1.12', ''),
(109, 'embed_extender', ''),
(110, 'etherpad', ''),
(111, 'mt_activity_tabs', ''),
(112, 'webodf', ''),
(134, '', ''),
(121, '', '<p>??</p>'),
(123, '', ''),
(124, '', ''),
(125, '', ''),
(126, '', ''),
(127, '', ''),
(129, '', ''),
(118, 'WebODF Test', '<p>Le plugin WebODF devrait permettre d''&eacute;diter ce fichier directement dans GCConnex</p>'),
(130, '', ''),
(131, '', ''),
(132, '', ''),
(133, '', ''),
(138, 'test', 'https://www.youtube.com/watch?v=E9osOjNww10'),
(139, 'Aweille!', '<p>Test un lien Youtube avec Embed Extender activ&eacute;<cite>.</cite></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>On dirait que &ccedil;a marche!</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>https://www.youtube.com/watch?v=E9osOjNww10</p>'),
(136, 'contactform', ''),
(137, 'webodf_elgg', ''),
(140, 'odt_editor', ''),
(142, 'Fichier de test 1', 'fichier téléversé pour testing'),
(144, 'odt_collabeditor', '');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_private_settings`
--

DROP TABLE IF EXISTS `elgg_private_settings`;
CREATE TABLE IF NOT EXISTS `elgg_private_settings` (
  `id` int(11) NOT NULL,
  `entity_guid` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` text NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=562 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_private_settings`
--

INSERT INTO `elgg_private_settings` (`id`, `entity_guid`, `name`, `value`) VALUES
(1, 2, 'elgg:internal:priority', '81'),
(2, 3, 'elgg:internal:priority', '79'),
(3, 4, 'elgg:internal:priority', '11'),
(4, 5, 'elgg:internal:priority', '83'),
(5, 6, 'elgg:internal:priority', '13'),
(6, 7, 'elgg:internal:priority', '34'),
(7, 8, 'elgg:internal:priority', '55'),
(8, 9, 'elgg:internal:priority', '6'),
(9, 10, 'elgg:internal:priority', '12'),
(10, 11, 'elgg:internal:priority', '7'),
(11, 12, 'elgg:internal:priority', '14'),
(12, 13, 'elgg:internal:priority', '82'),
(13, 14, 'elgg:internal:priority', '15'),
(14, 15, 'elgg:internal:priority', '16'),
(435, 110, 'etherpad', 'https://beta.etherpad.org'),
(16, 17, 'elgg:internal:priority', '17'),
(17, 18, 'elgg:internal:priority', '18'),
(19, 20, 'elgg:internal:priority', '19'),
(20, 21, 'elgg:internal:priority', '8'),
(21, 22, 'elgg:internal:priority', '20'),
(22, 23, 'elgg:internal:priority', '9'),
(23, 24, 'elgg:internal:priority', '21'),
(24, 25, 'elgg:internal:priority', '24'),
(25, 26, 'elgg:internal:priority', '22'),
(27, 28, 'elgg:internal:priority', '10'),
(28, 29, 'elgg:internal:priority', '23'),
(29, 30, 'elgg:internal:priority', '25'),
(30, 31, 'elgg:internal:priority', '1'),
(31, 32, 'elgg:internal:priority', '26'),
(32, 33, 'elgg:internal:priority', '2'),
(33, 34, 'elgg:internal:priority', '27'),
(34, 35, 'elgg:internal:priority', '28'),
(35, 36, 'elgg:internal:priority', '29'),
(37, 38, 'elgg:internal:priority', '30'),
(38, 39, 'elgg:internal:priority', '31'),
(40, 41, 'elgg:internal:priority', '32'),
(41, 42, 'elgg:internal:priority', '4'),
(42, 43, 'elgg:internal:priority', '3'),
(43, 44, 'elgg:internal:priority', '33'),
(44, 45, 'elgg:internal:priority', '35'),
(45, 46, 'elgg:internal:priority', '36'),
(46, 47, 'elgg:internal:priority', '37'),
(47, 48, 'elgg:internal:priority', '38'),
(48, 49, 'elgg:internal:priority', '39'),
(49, 50, 'elgg:internal:priority', '40'),
(50, 51, 'elgg:internal:priority', '41'),
(51, 52, 'elgg:internal:priority', '42'),
(52, 53, 'elgg:internal:priority', '43'),
(53, 54, 'elgg:internal:priority', '5'),
(54, 55, 'elgg:internal:priority', '44'),
(55, 56, 'elgg:internal:priority', '45'),
(56, 57, 'elgg:internal:priority', '46'),
(57, 58, 'elgg:internal:priority', '47'),
(58, 59, 'elgg:internal:priority', '48'),
(59, 60, 'elgg:internal:priority', '49'),
(60, 61, 'elgg:internal:priority', '50'),
(61, 62, 'elgg:internal:priority', '51'),
(62, 63, 'elgg:internal:priority', '52'),
(68, 69, 'elgg:internal:priority', '53'),
(69, 70, 'elgg:internal:priority', '54'),
(70, 71, 'elgg:internal:priority', '56'),
(71, 72, 'elgg:internal:priority', '57'),
(73, 74, 'elgg:internal:priority', '58'),
(74, 75, 'elgg:internal:priority', '59'),
(436, 94, 'profile_fixed_ts', '1448026145'),
(76, 77, 'elgg:internal:priority', '60'),
(77, 78, 'elgg:internal:priority', '61'),
(78, 79, 'elgg:internal:priority', '62'),
(79, 80, 'elgg:internal:priority', '63'),
(80, 81, 'elgg:internal:priority', '64'),
(81, 82, 'elgg:internal:priority', '65'),
(82, 83, 'elgg:internal:priority', '66'),
(83, 84, 'elgg:internal:priority', '67'),
(84, 85, 'elgg:internal:priority', '68'),
(85, 86, 'elgg:internal:priority', '69'),
(86, 87, 'elgg:internal:priority', '70'),
(87, 88, 'elgg:internal:priority', '71'),
(88, 89, 'elgg:internal:priority', '74'),
(89, 90, 'elgg:internal:priority', '72'),
(90, 91, 'elgg:internal:priority', '73'),
(91, 92, 'elgg:internal:priority', '75'),
(92, 93, 'elgg:internal:priority', '80'),
(93, 94, 'elgg:internal:priority', '76'),
(94, 95, 'elgg:internal:priority', '77'),
(95, 96, 'elgg:internal:priority', '78'),
(96, 81, 'limit', '140'),
(97, 98, 'handler', 'control_panel'),
(98, 98, 'context', 'admin'),
(99, 98, 'column', '1'),
(100, 98, 'order', '0'),
(101, 99, 'handler', 'admin_welcome'),
(102, 99, 'context', 'admin'),
(103, 99, 'order', '10'),
(104, 99, 'column', '1'),
(105, 100, 'handler', 'online_users'),
(106, 100, 'context', 'admin'),
(107, 100, 'column', '2'),
(108, 100, 'order', '0'),
(109, 101, 'handler', 'new_users'),
(110, 101, 'context', 'admin'),
(111, 101, 'order', '10'),
(112, 101, 'column', '2'),
(113, 102, 'handler', 'content_stats'),
(114, 102, 'context', 'admin'),
(115, 102, 'order', '20'),
(116, 102, 'column', '2'),
(117, 7, 'version', '20150912'),
(118, 68, 'enable_powered_by_elgg', 'true'),
(119, 68, 'enable_powered_by_phloor', 'false'),
(120, 68, 'enable_elgg_topbar_logo', 'true'),
(121, 68, 'enable_phloor_topbar_logo', 'false'),
(122, 20, 'ciw_layout', 'index_2rmsb'),
(123, 20, 'ciw_showdashboard', 'yes'),
(149, 83, 'tagging', ''),
(129, 94, 'dashboard_fixed_ts', '1447859747'),
(130, 97, 'plugin:user_setting:widget_manager:dashboard_fixed_ts', '1447859747'),
(174, 42, 'auto_notification_site', '0'),
(175, 42, 'show_membership_mode', 'yes'),
(171, 42, 'admin_transfer', 'no'),
(172, 42, 'search_index', 'no'),
(173, 42, 'auto_notification_email', '0'),
(170, 43, 'limited_groups', 'no'),
(169, 43, 'hidden_groups', 'no'),
(141, 47, 'release', '1356044864'),
(144, 46, 'release', '1372438394'),
(150, 83, 'view_count', '1'),
(151, 83, 'uploader', ''),
(152, 83, 'exif', ''),
(153, 83, 'download_link', '1'),
(154, 83, 'album_comments', ''),
(155, 83, 'slideshow', ''),
(156, 83, 'maxfilesize', '5'),
(157, 83, 'image_lib', 'GD'),
(158, 83, 'img_river_view', 'batch'),
(159, 83, 'album_river_view', 'cover'),
(160, 83, 'river_comments_thumbnails', 'none'),
(161, 83, 'image_sizes', 'a:6:{s:18:"large_image_height";i:600;s:17:"large_image_width";i:600;s:18:"small_image_height";i:153;s:17:"small_image_width";i:153;s:17:"tiny_image_height";i:60;s:16:"tiny_image_width";i:60;}'),
(162, 83, 'notify_interval', '86400'),
(459, 126, 'order', '10'),
(176, 42, 'show_hidden_group_indicator', 'no'),
(177, 42, 'auto_suggest_groups', 'yes'),
(178, 42, 'multiple_admin', 'no'),
(179, 42, 'mail', 'no'),
(180, 42, 'member_export', 'no'),
(181, 42, 'group_listing', 'discussion'),
(182, 42, 'group_listing_discussion_available', '1'),
(183, 42, 'group_listing_yours_available', '1'),
(184, 42, 'group_listing_newest_available', '1'),
(185, 42, 'group_listing_popular_available', '1'),
(186, 42, 'group_listing_open_available', '1'),
(187, 42, 'group_listing_closed_available', '1'),
(188, 42, 'group_listing_alpha_available', '1'),
(189, 42, 'group_listing_ordered_available', '0'),
(190, 42, 'group_listing_suggested_available', '1'),
(191, 42, 'invite', 'yes'),
(192, 42, 'invite_email', 'yes'),
(193, 42, 'invite_csv', 'no'),
(194, 42, 'invite_members', 'yes_on'),
(195, 42, 'domain_based', 'no'),
(196, 42, 'group_default_access', '1'),
(197, 71, 'frsingular', 'collègue'),
(198, 71, 'frplural', 'Collègues'),
(199, 71, 'ensingular', 'colleague'),
(200, 71, 'enplural', 'Colleagues'),
(201, 7, 'display_subgroups', 'yes'),
(202, 7, 'display_featured', 'no'),
(203, 12, 'db_add_ext', ''),
(204, 12, 'db_add_dept', ''),
(205, 26, 'version', '2015042201'),
(206, 30, 'allowed_extensions', 'txt, jpg, jpeg, png, bmp, gif, pdf, doc, docx, xls, xlsx, ppt, pptx, odt, ods, odp'),
(207, 30, 'user_folder_structure', 'yes'),
(208, 30, 'file_tools_default_time_display', 'date'),
(209, 30, 'sort', 'oe.description'),
(210, 30, 'sort_direction', 'asc'),
(211, 30, 'list_length', '50'),
(212, 94, 'dashboard_friends_can_add', 'yes'),
(213, 94, 'dashboard_friends_hide', 'no'),
(214, 94, 'dashboard_river_widget_can_add', 'yes'),
(215, 94, 'dashboard_river_widget_hide', 'no'),
(216, 94, 'dashboard_a_users_groups_can_add', 'yes'),
(217, 94, 'dashboard_a_users_groups_hide', 'no'),
(218, 94, 'dashboard_group_river_widget_can_add', 'yes'),
(219, 94, 'dashboard_group_river_widget_hide', 'no'),
(220, 94, 'dashboard_group_invitations_can_add', 'yes'),
(221, 94, 'dashboard_group_invitations_hide', 'no'),
(222, 94, 'dashboard_start_discussion_can_add', 'yes'),
(223, 94, 'dashboard_start_discussion_hide', 'no'),
(224, 94, 'dashboard_group_news_can_add', 'yes'),
(225, 94, 'dashboard_group_news_hide', 'no'),
(226, 94, 'dashboard_discussion_can_add', 'yes'),
(227, 94, 'dashboard_discussion_hide', 'no'),
(228, 94, 'dashboard_blog_can_add', 'yes'),
(229, 94, 'dashboard_blog_hide', 'no'),
(230, 94, 'dashboard_bookmarks_can_add', 'yes'),
(231, 94, 'dashboard_bookmarks_hide', 'no'),
(232, 94, 'dashboard_event_calendar_can_add', 'yes'),
(233, 94, 'dashboard_event_calendar_hide', 'no'),
(234, 94, 'dashboard_filerepo_can_add', 'yes'),
(235, 94, 'dashboard_filerepo_hide', 'no'),
(236, 94, 'dashboard_file_tree_can_add', 'yes'),
(237, 94, 'dashboard_file_tree_hide', 'no'),
(238, 94, 'dashboard_ideas_can_add', 'yes'),
(239, 94, 'dashboard_ideas_hide', 'no'),
(240, 94, 'dashboard_pages_can_add', 'yes'),
(241, 94, 'dashboard_pages_hide', 'no'),
(242, 94, 'dashboard_poll_can_add', 'yes'),
(243, 94, 'dashboard_poll_hide', 'no'),
(244, 94, 'dashboard_latestPolls_can_add', 'yes'),
(245, 94, 'dashboard_latestPolls_hide', 'no'),
(246, 94, 'dashboard_poll_individual_can_add', 'yes'),
(247, 94, 'dashboard_poll_individual_hide', 'no'),
(248, 94, 'dashboard_tasks_can_add', 'yes'),
(249, 94, 'dashboard_tasks_hide', 'no'),
(250, 94, 'dashboard_thewire_can_add', 'yes'),
(251, 94, 'dashboard_thewire_hide', 'no'),
(252, 94, 'dashboard_twitter_can_add', 'yes'),
(253, 94, 'dashboard_twitter_hide', 'no'),
(254, 94, 'dashboard_content_by_tag_can_add', 'yes'),
(255, 94, 'dashboard_content_by_tag_hide', 'no'),
(256, 94, 'dashboard_free_html_can_add', 'yes'),
(257, 94, 'dashboard_free_html_hide', 'no'),
(258, 94, 'dashboard_tagcloud_can_add', 'yes'),
(259, 94, 'dashboard_tagcloud_hide', 'no'),
(260, 94, 'dashboard_iframe_can_add', 'no'),
(261, 94, 'dashboard_iframe_hide', 'yes'),
(262, 94, 'dashboard_rss_can_add', 'yes'),
(263, 94, 'dashboard_rss_hide', 'no'),
(264, 94, 'dashboard_twitter_search_can_add', 'yes'),
(265, 94, 'dashboard_twitter_search_hide', 'no'),
(266, 94, 'dashboard_messages_can_add', 'yes'),
(267, 94, 'dashboard_messages_hide', 'no'),
(268, 94, 'dashboard_favorites_can_add', 'yes'),
(269, 94, 'dashboard_favorites_hide', 'no'),
(270, 94, 'groups_friends_can_add', 'no'),
(271, 94, 'groups_friends_hide', 'no'),
(272, 94, 'groups_river_widget_can_add', 'no'),
(273, 94, 'groups_river_widget_hide', 'no'),
(274, 94, 'groups_a_users_groups_can_add', 'no'),
(275, 94, 'groups_a_users_groups_hide', 'no'),
(276, 94, 'groups_group_river_widget_can_add', 'yes'),
(277, 94, 'groups_group_river_widget_hide', 'no'),
(278, 94, 'groups_group_members_can_add', 'yes'),
(279, 94, 'groups_group_members_hide', 'no'),
(280, 94, 'groups_start_discussion_can_add', 'yes'),
(281, 94, 'groups_start_discussion_hide', 'no'),
(282, 94, 'groups_group_related_can_add', 'yes'),
(283, 94, 'groups_group_related_hide', 'no'),
(284, 94, 'groups_group_forum_topics_can_add', 'yes'),
(285, 94, 'groups_group_forum_topics_hide', 'no'),
(286, 94, 'groups_blog_can_add', 'no'),
(287, 94, 'groups_blog_hide', 'no'),
(288, 94, 'groups_bookmarks_can_add', 'no'),
(289, 94, 'groups_bookmarks_hide', 'no'),
(290, 94, 'groups_event_calendar_can_add', 'no'),
(291, 94, 'groups_event_calendar_hide', 'no'),
(292, 94, 'groups_groups_event_calendar_can_add', 'yes'),
(293, 94, 'groups_groups_event_calendar_hide', 'no'),
(294, 94, 'groups_filerepo_can_add', 'no'),
(295, 94, 'groups_filerepo_hide', 'no'),
(296, 94, 'groups_file_tree_can_add', 'yes'),
(297, 94, 'groups_file_tree_hide', 'no'),
(298, 94, 'groups_group_files_can_add', 'yes'),
(299, 94, 'groups_group_files_hide', 'no'),
(300, 94, 'groups_au_subgroups_can_add', 'yes'),
(301, 94, 'groups_au_subgroups_hide', 'no'),
(302, 94, 'groups_ideas_can_add', 'no'),
(303, 94, 'groups_ideas_hide', 'no'),
(304, 94, 'groups_pages_can_add', 'no'),
(305, 94, 'groups_pages_hide', 'no'),
(306, 94, 'groups_poll_can_add', 'no'),
(307, 94, 'groups_poll_hide', 'no'),
(308, 94, 'groups_latestPolls_can_add', 'no'),
(309, 94, 'groups_latestPolls_hide', 'no'),
(310, 94, 'groups_poll_individual_can_add', 'no'),
(311, 94, 'groups_poll_individual_hide', 'no'),
(312, 94, 'groups_tasks_can_add', 'yes'),
(313, 94, 'groups_tasks_hide', 'no'),
(314, 94, 'groups_thewire_can_add', 'no'),
(315, 94, 'groups_thewire_hide', 'no'),
(316, 94, 'groups_groups_latest_photos_can_add', 'yes'),
(317, 94, 'groups_groups_latest_photos_hide', 'no'),
(318, 94, 'groups_groups_latest_albums_can_add', 'yes'),
(319, 94, 'groups_groups_latest_albums_hide', 'no'),
(320, 94, 'groups_twitter_can_add', 'no'),
(321, 94, 'groups_twitter_hide', 'no'),
(322, 94, 'groups_content_by_tag_can_add', 'yes'),
(323, 94, 'groups_content_by_tag_hide', 'no'),
(324, 94, 'groups_free_html_can_add', 'yes'),
(325, 94, 'groups_free_html_hide', 'no'),
(326, 94, 'groups_tagcloud_can_add', 'yes'),
(327, 94, 'groups_tagcloud_hide', 'no'),
(328, 94, 'groups_iframe_can_add', 'no'),
(329, 94, 'groups_iframe_hide', 'yes'),
(330, 94, 'groups_rss_can_add', 'yes'),
(331, 94, 'groups_rss_hide', 'no'),
(332, 94, 'groups_image_slider_can_add', 'yes'),
(333, 94, 'groups_image_slider_hide', 'no'),
(334, 94, 'groups_twitter_search_can_add', 'yes'),
(335, 94, 'groups_twitter_search_hide', 'no'),
(336, 94, 'profile_friends_can_add', 'yes'),
(337, 94, 'profile_friends_hide', 'no'),
(338, 94, 'profile_river_widget_can_add', 'yes'),
(339, 94, 'profile_river_widget_hide', 'no'),
(340, 94, 'profile_a_users_groups_can_add', 'yes'),
(341, 94, 'profile_a_users_groups_hide', 'no'),
(342, 94, 'profile_group_river_widget_can_add', 'yes'),
(343, 94, 'profile_group_river_widget_hide', 'no'),
(344, 94, 'profile_group_news_can_add', 'yes'),
(345, 94, 'profile_group_news_hide', 'no'),
(346, 94, 'profile_blog_can_add', 'yes'),
(347, 94, 'profile_blog_hide', 'no'),
(348, 94, 'profile_bookmarks_can_add', 'yes'),
(349, 94, 'profile_bookmarks_hide', 'no'),
(350, 94, 'profile_event_calendar_can_add', 'yes'),
(351, 94, 'profile_event_calendar_hide', 'no'),
(352, 94, 'profile_filerepo_can_add', 'yes'),
(353, 94, 'profile_filerepo_hide', 'no'),
(354, 94, 'profile_file_tree_can_add', 'yes'),
(355, 94, 'profile_file_tree_hide', 'no'),
(356, 94, 'profile_ideas_can_add', 'yes'),
(357, 94, 'profile_ideas_hide', 'no'),
(358, 94, 'profile_messageboard_can_add', 'yes'),
(359, 94, 'profile_messageboard_hide', 'no'),
(360, 94, 'profile_pages_can_add', 'yes'),
(361, 94, 'profile_pages_hide', 'no'),
(362, 94, 'profile_poll_can_add', 'yes'),
(363, 94, 'profile_poll_hide', 'no'),
(364, 94, 'profile_latestPolls_can_add', 'yes'),
(365, 94, 'profile_latestPolls_hide', 'no'),
(366, 94, 'profile_poll_individual_can_add', 'yes'),
(367, 94, 'profile_poll_individual_hide', 'no'),
(368, 94, 'profile_tasks_can_add', 'yes'),
(369, 94, 'profile_tasks_hide', 'no'),
(370, 94, 'profile_thewire_can_add', 'yes'),
(371, 94, 'profile_thewire_hide', 'no'),
(372, 94, 'profile_album_view_can_add', 'yes'),
(373, 94, 'profile_album_view_hide', 'no'),
(374, 94, 'profile_latest_photos_can_add', 'yes'),
(375, 94, 'profile_latest_photos_hide', 'no'),
(376, 94, 'profile_twitter_can_add', 'yes'),
(377, 94, 'profile_twitter_hide', 'no'),
(378, 94, 'profile_content_by_tag_can_add', 'yes'),
(379, 94, 'profile_content_by_tag_hide', 'no'),
(380, 94, 'profile_free_html_can_add', 'yes'),
(381, 94, 'profile_free_html_hide', 'no'),
(382, 94, 'profile_tagcloud_can_add', 'yes'),
(383, 94, 'profile_tagcloud_hide', 'no'),
(384, 94, 'profile_iframe_can_add', 'no'),
(385, 94, 'profile_iframe_hide', 'yes'),
(386, 94, 'profile_rss_can_add', 'yes'),
(387, 94, 'profile_rss_hide', 'no'),
(388, 94, 'profile_twitter_search_can_add', 'yes'),
(389, 94, 'profile_twitter_search_hide', 'no'),
(458, 126, 'context', 'admin'),
(457, 126, 'handler', 'new_users'),
(456, 125, 'order', '0'),
(455, 125, 'column', '2'),
(454, 125, 'context', 'admin'),
(453, 125, 'handler', 'online_users'),
(452, 124, 'column', '1'),
(451, 124, 'order', '10'),
(450, 124, 'context', 'admin'),
(449, 124, 'handler', 'admin_welcome'),
(448, 123, 'order', '0'),
(447, 123, 'column', '1'),
(446, 123, 'context', 'admin'),
(445, 123, 'handler', 'control_panel'),
(437, 97, 'plugin:user_setting:widget_manager:profile_fixed_ts', '1448026145'),
(494, 109, 'width', ''),
(427, 111, 'elgg:internal:priority', '86'),
(426, 110, 'elgg:internal:priority', '85'),
(425, 109, 'elgg:internal:priority', '84'),
(527, 144, 'elgg:internal:priority', '90'),
(432, 111, 'version', '20151017'),
(420, 85, 'disabled_languages', 'de,pl,fi,it,ja,ru,gl,nl,ko,da,eu_es,zh_hans,cmn,ca,sr,el,ro_ro,tr,sr_latin,fa,ar'),
(460, 126, 'column', '2'),
(461, 127, 'handler', 'content_stats'),
(462, 127, 'context', 'admin'),
(463, 127, 'order', '20'),
(464, 127, 'column', '2'),
(465, 129, 'handler', 'control_panel'),
(466, 129, 'context', 'admin'),
(467, 129, 'column', '1'),
(468, 129, 'order', '0'),
(469, 130, 'handler', 'admin_welcome'),
(470, 130, 'context', 'admin'),
(471, 130, 'order', '10'),
(472, 130, 'column', '1'),
(473, 131, 'handler', 'online_users'),
(474, 131, 'context', 'admin'),
(475, 131, 'column', '2'),
(476, 131, 'order', '0'),
(477, 132, 'handler', 'new_users'),
(478, 132, 'context', 'admin'),
(479, 132, 'order', '10'),
(480, 132, 'column', '2'),
(481, 133, 'handler', 'content_stats'),
(482, 133, 'context', 'admin'),
(483, 133, 'order', '20'),
(484, 133, 'column', '2'),
(486, 128, 'plugin:user_setting:widget_manager:profile_fixed_ts', '1448552520'),
(488, 136, 'elgg:internal:priority', '87'),
(489, 137, 'elgg:internal:priority', '88'),
(495, 109, 'widget_width', ''),
(496, 109, 'wire_show', 'no'),
(497, 109, 'blog_show', 'yes'),
(498, 109, 'comment_show', 'no'),
(499, 109, 'topicposts_show', 'no'),
(500, 109, 'messageboard_show', 'no'),
(501, 109, 'page_show', 'yes'),
(502, 109, 'bookmark_show', 'no'),
(503, 109, 'custom_views', ''),
(504, 109, 'custom_provider', 'no'),
(508, 140, 'elgg:internal:priority', '89'),
(511, 118, 'odt_editor_lock_guid', '1449582596'),
(512, 118, 'odt_editor_lock_time', '1449582596'),
(513, 118, 'odt_editor_lock_user', '97'),
(514, 90, 'templates', 'a:0:{}'),
(515, 90, 'v1_8_2', '1'),
(520, 142, 'odt_editor_lock_guid', '1449541548'),
(521, 142, 'odt_editor_lock_time', '1449541548'),
(522, 142, 'odt_editor_lock_user', '97'),
(561, 22, 'show_modules', '0'),
(560, 22, 'show_gear', '0'),
(559, 22, 'log_events', '0'),
(558, 22, 'wrap_views', '0'),
(557, 22, 'show_strings', '0'),
(556, 22, 'screen_log', '0'),
(555, 22, 'display_errors', '1'),
(554, 1, 'te_last_update_en', '1449591718');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_queue`
--

DROP TABLE IF EXISTS `elgg_queue`;
CREATE TABLE IF NOT EXISTS `elgg_queue` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `data` mediumblob NOT NULL,
  `timestamp` int(11) NOT NULL,
  `worker` varchar(32) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_queue`
--

INSERT INTO `elgg_queue` (`id`, `name`, `data`, `timestamp`, `worker`) VALUES
(1, 'notifications', 0x4f3a32343a22456c67675c4e6f74696669636174696f6e735c4576656e74223a353a7b733a393a22002a00616374696f6e223b733a363a22637265617465223b733a31343a22002a006f626a6563745f74797065223b733a363a226f626a656374223b733a31373a22002a006f626a6563745f73756274797065223b733a343a2266696c65223b733a31323a22002a006f626a6563745f6964223b693a3131383b733a31333a22002a006163746f725f67756964223b693a39373b7d, 1448026970, NULL),
(2, 'notifications', 0x4f3a32343a22456c67675c4e6f74696669636174696f6e735c4576656e74223a353a7b733a393a22002a00616374696f6e223b733a373a227075626c697368223b733a31343a22002a006f626a6563745f74797065223b733a363a226f626a656374223b733a31373a22002a006f626a6563745f73756274797065223b733a343a22626c6f67223b733a31323a22002a006f626a6563745f6964223b693a3133393b733a31333a22002a006163746f725f67756964223b693a39373b7d, 1448631734, NULL),
(3, 'notifications', 0x4f3a32343a22456c67675c4e6f74696669636174696f6e735c4576656e74223a353a7b733a393a22002a00616374696f6e223b733a363a22637265617465223b733a31343a22002a006f626a6563745f74797065223b733a363a226f626a656374223b733a31373a22002a006f626a6563745f73756274797065223b733a343a2266696c65223b733a31323a22002a006f626a6563745f6964223b693a3134323b733a31333a22002a006163746f725f67756964223b693a3134313b7d, 1449502517, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_river`
--

DROP TABLE IF EXISTS `elgg_river`;
CREATE TABLE IF NOT EXISTS `elgg_river` (
  `id` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  `subtype` varchar(32) NOT NULL,
  `action_type` varchar(32) NOT NULL,
  `access_id` int(11) NOT NULL,
  `view` text NOT NULL,
  `subject_guid` int(11) NOT NULL,
  `object_guid` int(11) NOT NULL,
  `target_guid` int(11) NOT NULL,
  `annotation_id` int(11) NOT NULL,
  `posted` int(11) NOT NULL,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_river`
--

INSERT INTO `elgg_river` (`id`, `type`, `subtype`, `action_type`, `access_id`, `view`, `subject_guid`, `object_guid`, `target_guid`, `annotation_id`, `posted`, `enabled`) VALUES
(1, 'group', '', 'create', 2, 'river/group/create', 97, 117, 0, 0, 1448026781, 'yes'),
(2, 'object', 'file', 'create', 1, 'river/object/file/create', 97, 118, 0, 0, 1448026970, 'yes'),
(10, 'object', 'etherpad', 'create', 2, 'river/object/etherpad/create', 97, 134, 0, 0, 1448545438, 'yes'),
(5, 'object', 'comment', 'comment', 1, 'river/object/comment/create', 97, 121, 118, 0, 1448027630, 'yes'),
(6, 'user', '', 'friend', 2, 'river/relationship/friend/create', 128, 97, 0, 0, 1448390201, 'yes'),
(7, 'user', '', 'friend', 2, 'river/relationship/friend/create', 97, 128, 0, 0, 1448390201, 'yes'),
(9, 'user', '', 'update', 2, 'river/user/default/profileiconupdate', 97, 97, 0, 0, 1448542325, 'yes'),
(11, 'object', 'blog', 'create', 2, 'river/object/blog/create', 97, 139, 0, 0, 1448631734, 'yes'),
(12, 'object', 'file', 'create', 1, 'river/object/file/create', 141, 142, 0, 0, 1449502517, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_sites_entity`
--

DROP TABLE IF EXISTS `elgg_sites_entity`;
CREATE TABLE IF NOT EXISTS `elgg_sites_entity` (
  `guid` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_sites_entity`
--

INSERT INTO `elgg_sites_entity` (`guid`, `name`, `description`, `url`) VALUES
(1, 'GCConnex (pchgc.ca)', 'Code GCConnex', 'http://localhost/gcconnex/');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_system_log`
--

DROP TABLE IF EXISTS `elgg_system_log`;
CREATE TABLE IF NOT EXISTS `elgg_system_log` (
  `id` int(11) NOT NULL,
  `object_id` int(11) NOT NULL,
  `object_class` varchar(50) NOT NULL,
  `object_type` varchar(50) NOT NULL,
  `object_subtype` varchar(50) NOT NULL,
  `event` varchar(50) NOT NULL,
  `performed_by_guid` int(11) NOT NULL,
  `owner_guid` int(11) NOT NULL,
  `access_id` int(11) NOT NULL,
  `enabled` enum('yes','no') NOT NULL DEFAULT 'yes',
  `time_created` int(11) NOT NULL,
  `ip_address` varchar(46) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=747 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_system_log`
--

INSERT INTO `elgg_system_log` (`id`, `object_id`, `object_class`, `object_type`, `object_subtype`, `event`, `performed_by_guid`, `owner_guid`, `access_id`, `enabled`, `time_created`, `ip_address`) VALUES
(1, 2, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(2, 3, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(3, 4, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(4, 5, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(5, 6, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(6, 7, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(7, 8, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(8, 9, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(9, 10, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(10, 11, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(11, 12, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(12, 13, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(13, 14, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(14, 15, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(15, 16, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(16, 17, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(17, 18, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(18, 19, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(19, 20, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(20, 21, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(21, 22, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(22, 23, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(23, 24, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(24, 25, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(25, 26, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809797, '192.226.236.47'),
(26, 27, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(27, 28, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(28, 29, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(29, 30, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(30, 31, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(31, 32, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(32, 33, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(33, 34, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(34, 35, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(35, 36, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(36, 37, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(37, 38, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(38, 39, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(39, 40, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(40, 41, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(41, 42, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(42, 43, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(43, 44, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(44, 45, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(45, 46, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(46, 47, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(47, 48, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(48, 49, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(49, 50, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(50, 51, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(51, 52, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(52, 53, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(53, 54, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(54, 55, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(55, 56, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(56, 57, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(57, 58, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(58, 59, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(59, 60, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(60, 61, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(61, 62, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(62, 63, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(63, 64, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(64, 65, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(65, 66, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(66, 67, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(67, 68, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(68, 69, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(69, 70, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(70, 71, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(71, 72, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(72, 73, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(73, 74, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809798, '192.226.236.47'),
(74, 75, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(75, 76, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(76, 77, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(77, 78, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(78, 79, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(79, 80, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(80, 81, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(81, 82, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(82, 83, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(83, 84, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(84, 85, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(85, 86, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(86, 87, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(87, 88, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(88, 89, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(89, 90, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(90, 91, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(91, 92, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(92, 93, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(93, 94, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(94, 95, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(95, 96, 'ElggPlugin', 'object', 'plugin', 'create', 0, 1, 2, 'yes', 1447809799, '192.226.236.47'),
(96, 1, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(97, 2, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(98, 3, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(99, 4, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(100, 5, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(101, 6, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(102, 7, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(103, 8, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(104, 9, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(105, 10, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(106, 11, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(107, 12, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(108, 13, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(109, 14, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(110, 15, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809799, '192.226.236.47'),
(111, 16, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(112, 17, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(113, 18, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(114, 19, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(115, 20, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(116, 21, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(117, 22, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(118, 23, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(119, 24, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(120, 25, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(121, 26, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(122, 27, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(123, 28, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(124, 29, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 0, 0, 2, 'yes', 1447809800, '192.226.236.47'),
(125, 30, 'ElggRelationship', 'relationship', 'member_of_site', 'create', 0, 0, 2, 'yes', 1447809853, '192.226.236.47'),
(126, 97, 'ElggUser', 'user', '', 'create', 0, 0, 2, 'yes', 1447809853, '192.226.236.47'),
(127, 2, 'ElggMetadata', 'metadata', 'notification:method:email', 'create', 0, 97, 2, 'yes', 1447809853, '192.226.236.47'),
(128, 98, 'ElggWidget', 'object', 'widget', 'create', 0, 97, 2, 'yes', 1447809854, '192.226.236.47'),
(129, 99, 'ElggWidget', 'object', 'widget', 'create', 0, 97, 2, 'yes', 1447809854, '192.226.236.47'),
(130, 100, 'ElggWidget', 'object', 'widget', 'create', 0, 97, 2, 'yes', 1447809854, '192.226.236.47'),
(131, 101, 'ElggWidget', 'object', 'widget', 'create', 0, 97, 2, 'yes', 1447809854, '192.226.236.47'),
(132, 102, 'ElggWidget', 'object', 'widget', 'create', 0, 97, 2, 'yes', 1447809854, '192.226.236.47'),
(133, 97, 'ElggUser', 'user', '', 'make_admin', 0, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(134, 3, 'ElggMetadata', 'metadata', 'validated', 'create', 0, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(135, 4, 'ElggMetadata', 'metadata', 'validated_method', 'create', 0, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(136, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(137, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(138, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447809854, '192.226.236.47'),
(139, 5, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1447809858, '192.226.236.47'),
(140, 103, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1447809858, '192.226.236.47'),
(141, 31, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810310, '192.226.236.47'),
(142, 32, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810422, '192.226.236.47'),
(143, 33, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810693, '192.226.236.47'),
(144, 34, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810732, '192.226.236.47'),
(145, 35, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810786, '192.226.236.47'),
(146, 36, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447810960, '192.226.236.47'),
(147, 103, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1447811000, '192.226.236.47'),
(148, 5, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1447811001, '192.226.236.47'),
(149, 6, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1447811007, '192.226.236.47'),
(150, 104, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1447811007, '192.226.236.47'),
(151, 1, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447811248, '192.226.236.47'),
(152, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1447811359, '192.226.236.47'),
(153, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1447811359, '192.226.236.47'),
(154, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1447811359, '192.226.236.47'),
(155, 37, 'ElggRelationship', 'relationship', 'member_of_site', 'create', 0, 0, 2, 'yes', 1447811448, '192.226.236.47'),
(156, 105, 'ElggUser', 'user', '', 'create', 0, 0, 2, 'yes', 1447811448, '192.226.236.47'),
(157, 7, 'ElggMetadata', 'metadata', 'notification:method:email', 'create', 0, 105, 2, 'yes', 1447811448, '192.226.236.47'),
(158, 105, 'ElggUser', 'user', '', 'disable', 0, 0, 2, 'yes', 1447811448, '192.226.236.47'),
(159, 8, 'ElggMetadata', 'metadata', 'disable_reason', 'create', 0, 105, 2, 'yes', 1447811448, '192.226.236.47'),
(160, 7, 'ElggMetadata', 'metadata', 'notification:method:email', 'disable', 0, 105, 2, 'yes', 1447811448, '192.226.236.47'),
(161, 8, 'ElggMetadata', 'metadata', 'disable_reason', 'disable', 0, 105, 2, 'yes', 1447811448, '192.226.236.47'),
(162, 105, 'ElggUser', 'user', '', 'disable:after', 0, 0, 2, 'no', 1447811448, '192.226.236.47'),
(163, 9, 'ElggMetadata', 'metadata', 'validated', 'create', 0, 0, 2, 'yes', 1447811448, '192.226.236.47'),
(164, 10, 'ElggMetadata', 'metadata', 'validated_method', 'create', 0, 0, 2, 'yes', 1447811448, '192.226.236.47'),
(165, 9, 'ElggMetadata', 'metadata', 'validated', 'update', 0, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(166, 10, 'ElggMetadata', 'metadata', 'validated_method', 'update', 0, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(167, 105, 'ElggUser', 'user', '', 'enable', 0, 0, 2, 'no', 1447811487, '142.169.78.140'),
(168, 8, 'ElggMetadata', 'metadata', 'disable_reason', 'delete', 0, 105, 2, 'no', 1447811487, '142.169.78.140'),
(169, 7, 'ElggMetadata', 'metadata', 'notification:method:email', 'enable', 0, 105, 2, 'no', 1447811487, '142.169.78.140'),
(170, 105, 'ElggUser', 'user', '', 'enable:after', 0, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(171, 105, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(172, 105, 'ElggUser', 'user', '', 'login', 105, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(173, 105, 'ElggUser', 'user', '', 'login:after', 105, 0, 2, 'yes', 1447811487, '142.169.78.140'),
(174, 105, 'ElggUser', 'user', '', 'logout:before', 105, 0, 2, 'yes', 1447811499, '142.169.78.140'),
(175, 105, 'ElggUser', 'user', '', 'logout', 105, 0, 2, 'yes', 1447811499, '142.169.78.140'),
(176, 105, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1447811499, '142.169.78.140'),
(177, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447811609, '192.226.236.47'),
(178, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447811609, '192.226.236.47'),
(179, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447811609, '192.226.236.47'),
(180, 11, 'ElggMetadata', 'metadata', 'job', 'create', 97, 97, 2, 'yes', 1447811713, '192.226.236.47'),
(181, 12, 'ElggMetadata', 'metadata', 'department', 'create', 97, 97, 2, 'yes', 1447811713, '192.226.236.47'),
(182, 13, 'ElggMetadata', 'metadata', 'location', 'create', 97, 97, 2, 'yes', 1447811713, '192.226.236.47'),
(183, 14, 'ElggMetadata', 'metadata', 'phone', 'create', 97, 97, 2, 'yes', 1447811713, '192.226.236.47'),
(184, 15, 'ElggMetadata', 'metadata', 'mobile', 'create', 97, 97, 2, 'yes', 1447811713, '192.226.236.47'),
(185, 105, 'ElggUser', 'user', '', 'delete', 97, 0, 2, 'yes', 1447811850, '192.226.236.47'),
(186, 7, 'ElggMetadata', 'metadata', 'notification:method:email', 'delete', 97, 105, 2, 'yes', 1447811850, '192.226.236.47'),
(187, 9, 'ElggMetadata', 'metadata', 'validated', 'delete', 97, 0, 2, 'yes', 1447811850, '192.226.236.47'),
(188, 10, 'ElggMetadata', 'metadata', 'validated_method', 'delete', 97, 0, 2, 'yes', 1447811850, '192.226.236.47'),
(189, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1447811937, '192.226.236.47'),
(190, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1447811937, '192.226.236.47'),
(191, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1447811937, '192.226.236.47'),
(192, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447853127, '198.103.196.150'),
(193, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447853127, '198.103.196.150'),
(194, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447853127, '198.103.196.150'),
(195, 38, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447853337, '198.103.196.150'),
(196, 39, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447853385, '198.103.196.150'),
(197, 40, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447854521, '198.103.196.150'),
(198, 41, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447854668, '198.103.196.150'),
(199, 42, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447854852, '198.103.196.150'),
(200, 43, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447855247, '198.103.196.150'),
(201, 44, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447855392, '198.103.196.150'),
(202, 45, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447855557, '198.103.196.150'),
(203, 35, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447855980, '198.103.196.150'),
(204, 46, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447856106, '198.103.196.150'),
(205, 2, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447856214, '198.103.196.150'),
(206, 47, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447856686, '198.103.196.150'),
(207, 48, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447856943, '198.103.196.150'),
(208, 49, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447857240, '198.103.196.150'),
(209, 50, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447857493, '198.103.196.150'),
(210, 51, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447857579, '198.103.196.150'),
(211, 52, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447857630, '198.103.196.150'),
(212, 53, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447857649, '198.103.196.150'),
(213, 54, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858150, '198.103.196.150'),
(214, 55, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858201, '198.103.196.150'),
(215, 56, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858398, '198.103.196.150'),
(216, 57, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858481, '198.103.196.150'),
(217, 58, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858552, '198.103.196.150'),
(218, 59, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858602, '198.103.196.150'),
(219, 60, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858617, '198.103.196.150'),
(220, 61, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858686, '198.103.196.150'),
(221, 62, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858827, '198.103.196.150'),
(222, 63, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858878, '198.103.196.150'),
(223, 64, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447858939, '198.103.196.150'),
(224, 65, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447859018, '198.103.196.150'),
(225, 66, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447859107, '198.103.196.150'),
(226, 67, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447859235, '198.103.196.150'),
(227, 68, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447859403, '198.103.196.150'),
(228, 106, 'ElggWidget', 'object', 'widget', 'create', 97, 97, 2, 'yes', 1447859805, '198.103.196.150'),
(229, 106, 'WidgetManagerWidget', 'object', 'widget', 'update', 97, 97, 2, 'yes', 1447860011, '198.103.196.150'),
(230, 106, 'WidgetManagerWidget', 'object', 'widget', 'update:after', 97, 97, 2, 'yes', 1447860011, '198.103.196.150'),
(231, 106, 'WidgetManagerWidget', 'object', 'widget', 'update', 97, 97, 2, 'yes', 1447860011, '198.103.196.150'),
(232, 106, 'WidgetManagerWidget', 'object', 'widget', 'update:after', 97, 97, 2, 'yes', 1447860011, '198.103.196.150'),
(233, 69, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447861153, '198.103.196.150'),
(234, 70, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447861947, '198.103.196.150'),
(235, 71, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447862376, '198.103.196.150'),
(236, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1447864171, '198.103.196.150'),
(237, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1447864171, '198.103.196.150'),
(238, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1447864171, '198.103.196.150'),
(239, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447871253, '198.103.196.150'),
(240, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447871253, '198.103.196.150'),
(241, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447871253, '198.103.196.150'),
(242, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447889760, '192.226.236.47'),
(243, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447889760, '192.226.236.47'),
(244, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447889760, '192.226.236.47'),
(245, 72, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447889833, '192.226.236.47'),
(246, 59, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447890370, '192.226.236.47'),
(247, 73, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447890466, '192.226.236.47'),
(248, 23, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447890540, '192.226.236.47'),
(249, 74, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447890614, '192.226.236.47'),
(250, 75, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447892946, '192.226.236.47'),
(251, 76, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447893013, '192.226.236.47'),
(252, 77, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447893054, '192.226.236.47'),
(253, 78, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447893281, '192.226.236.47'),
(254, 106, 'WidgetManagerWidget', 'object', 'widget', 'delete', 97, 97, 2, 'yes', 1447893538, '192.226.236.47'),
(255, 1, 'ElggSite', 'site', '', 'update', 97, 0, 2, 'yes', 1447894041, '192.226.236.47'),
(256, 1, 'ElggSite', 'site', '', 'update:after', 97, 0, 2, 'yes', 1447894041, '192.226.236.47'),
(257, 104, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1447894092, '192.226.236.47'),
(258, 6, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1447894092, '192.226.236.47'),
(259, 16, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1447894168, '192.226.236.47'),
(260, 107, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1447894168, '192.226.236.47'),
(261, 1, 'ElggSite', 'site', '', 'update', 97, 0, 2, 'yes', 1447894169, '192.226.236.47'),
(262, 1, 'ElggSite', 'site', '', 'update:after', 97, 0, 2, 'yes', 1447894169, '192.226.236.47'),
(263, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1447936877, '198.103.196.150'),
(264, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1447936877, '198.103.196.150'),
(265, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1447936877, '198.103.196.150'),
(266, 79, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447937065, '198.103.196.150'),
(267, 80, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447937471, '198.103.196.150'),
(268, 5, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447937734, '198.103.196.150'),
(269, 1, 'ElggSite', 'site', '', 'update', 97, 0, 2, 'yes', 1447940393, '198.103.196.150'),
(270, 1, 'ElggSite', 'site', '', 'update:after', 97, 0, 2, 'yes', 1447940393, '198.103.196.150'),
(271, 81, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1447946163, '198.103.196.150'),
(272, 78, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1447946264, '198.103.196.150'),
(273, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448024597, '192.226.236.47'),
(274, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448024597, '192.226.236.47'),
(275, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448024597, '192.226.236.47'),
(276, 108, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448024751, '192.226.236.47'),
(277, 109, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(278, 110, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(279, 111, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(280, 112, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(281, 76, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(282, 76, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1448024752, '192.226.236.47'),
(283, 73, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(284, 73, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1448024752, '192.226.236.47'),
(285, 16, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1448024752, '192.226.236.47'),
(286, 16, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1448024752, '192.226.236.47'),
(287, 82, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448024925, '192.226.236.47'),
(288, 83, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448024933, '192.226.236.47'),
(289, 82, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448025047, '192.226.236.47'),
(290, 82, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448025048, '192.226.236.47'),
(291, 17, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1448025048, '192.226.236.47'),
(292, 113, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1448025048, '192.226.236.47'),
(293, 108, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1448025051, '192.226.236.47'),
(294, 108, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1448025051, '192.226.236.47'),
(295, 84, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448025132, '192.226.236.47'),
(296, 85, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448025235, '192.226.236.47'),
(297, 107, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1448025308, '192.226.236.47'),
(298, 16, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1448025308, '192.226.236.47'),
(299, 18, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1448025311, '192.226.236.47'),
(300, 114, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1448025311, '192.226.236.47'),
(301, 19, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1448025311, '192.226.236.47'),
(302, 115, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1448025311, '192.226.236.47'),
(303, 113, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1448025950, '192.226.236.47'),
(304, 17, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1448025950, '192.226.236.47'),
(305, 115, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1448025954, '192.226.236.47'),
(306, 19, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1448025954, '192.226.236.47'),
(307, 114, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1448025957, '192.226.236.47'),
(308, 18, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1448025957, '192.226.236.47'),
(309, 20, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1448026144, '192.226.236.47'),
(310, 116, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1448026144, '192.226.236.47'),
(311, 97, 'ElggUser', 'user', '', 'update', 97, 0, 2, 'yes', 1448026319, '192.226.236.47'),
(312, 97, 'ElggUser', 'user', '', 'update:after', 97, 0, 2, 'yes', 1448026319, '192.226.236.47'),
(313, 97, 'ElggUser', 'user', '', 'update', 97, 0, 2, 'yes', 1448026524, '192.226.236.47'),
(314, 97, 'ElggUser', 'user', '', 'update:after', 97, 0, 2, 'yes', 1448026524, '192.226.236.47'),
(315, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448026538, '192.226.236.47'),
(316, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448026538, '192.226.236.47'),
(317, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448026538, '192.226.236.47'),
(318, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448026656, '192.226.236.47'),
(319, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448026656, '192.226.236.47'),
(320, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448026656, '192.226.236.47'),
(321, 21, 'ElggMetadata', 'metadata', 'briefdescription', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(322, 22, 'ElggMetadata', 'metadata', 'interests', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(323, 23, 'ElggMetadata', 'metadata', 'interests', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(324, 24, 'ElggMetadata', 'metadata', 'activity_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(325, 25, 'ElggMetadata', 'metadata', 'forum_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(326, 26, 'ElggMetadata', 'metadata', 'related_groups_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(327, 27, 'ElggMetadata', 'metadata', 'blog_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(328, 28, 'ElggMetadata', 'metadata', 'bookmarks_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(329, 29, 'ElggMetadata', 'metadata', 'event_calendar_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(330, 30, 'ElggMetadata', 'metadata', 'file_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(331, 31, 'ElggMetadata', 'metadata', 'file_tools_structure_management_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(332, 32, 'ElggMetadata', 'metadata', 'subgroups_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(333, 33, 'ElggMetadata', 'metadata', 'subgroups_members_create_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(334, 34, 'ElggMetadata', 'metadata', 'ideas_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(335, 35, 'ElggMetadata', 'metadata', 'pages_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(336, 36, 'ElggMetadata', 'metadata', 'polls_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(337, 37, 'ElggMetadata', 'metadata', 'tasks_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(338, 38, 'ElggMetadata', 'metadata', 'photos_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(339, 39, 'ElggMetadata', 'metadata', 'tp_images_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(340, 40, 'ElggMetadata', 'metadata', 'etherpad_enable', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(341, 41, 'ElggMetadata', 'metadata', 'membership', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(342, 42, 'ElggMetadata', 'metadata', 'group_acl', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(343, 117, 'ElggGroup', 'group', '', 'create', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(344, 117, 'ElggGroup', 'group', '', 'update', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(345, 117, 'ElggGroup', 'group', '', 'update:after', 97, 97, 2, 'yes', 1448026781, '192.226.236.47'),
(346, 86, 'ElggRelationship', 'relationship', 'member', 'create', 97, 0, 2, 'yes', 1448026781, '192.226.236.47'),
(347, 43, 'ElggMetadata', 'metadata', 'icontime', 'create', 97, 97, 2, 'yes', 1448026784, '192.226.236.47'),
(348, 44, 'ElggMetadata', 'metadata', 'content_access_mode', 'create', 97, 97, 2, 'yes', 1448026784, '192.226.236.47'),
(349, 45, 'ElggMetadata', 'metadata', 'tags', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(350, 46, 'ElggMetadata', 'metadata', 'tags', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(351, 47, 'ElggMetadata', 'metadata', 'filename', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(352, 48, 'ElggMetadata', 'metadata', 'originalfilename', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(353, 49, 'ElggMetadata', 'metadata', 'mimetype', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(354, 50, 'ElggMetadata', 'metadata', 'simpletype', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(355, 118, 'FilePluginFile', 'object', 'file', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(356, 51, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(357, 52, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448026970, '192.226.236.47'),
(358, 53, 'ElggMetadata', 'metadata', 'url', 'create', 97, 97, 1, 'yes', 1448027155, '192.226.236.47'),
(359, 54, 'ElggMetadata', 'metadata', 'objetive', 'create', 97, 97, 1, 'yes', 1448027155, '192.226.236.47'),
(360, 55, 'ElggMetadata', 'metadata', 'group_guid', 'create', 97, 97, 1, 'yes', 1448027155, '192.226.236.47'),
(361, 119, 'ElggObject', 'object', 'etherpad', 'create', 97, 97, 1, 'yes', 1448027155, '192.226.236.47'),
(362, 119, 'ElggObject', 'object', 'etherpad', 'delete', 97, 97, 1, 'yes', 1448027508, '192.226.236.47'),
(363, 53, 'ElggMetadata', 'metadata', 'url', 'delete', 97, 97, 1, 'yes', 1448027508, '192.226.236.47'),
(364, 54, 'ElggMetadata', 'metadata', 'objetive', 'delete', 97, 97, 1, 'yes', 1448027508, '192.226.236.47'),
(365, 55, 'ElggMetadata', 'metadata', 'group_guid', 'delete', 97, 97, 1, 'yes', 1448027508, '192.226.236.47'),
(366, 56, 'ElggMetadata', 'metadata', 'url', 'create', 97, 97, 1, 'yes', 1448027536, '192.226.236.47'),
(367, 57, 'ElggMetadata', 'metadata', 'objetive', 'create', 97, 97, 1, 'yes', 1448027536, '192.226.236.47'),
(368, 58, 'ElggMetadata', 'metadata', 'group_guid', 'create', 97, 97, 1, 'yes', 1448027536, '192.226.236.47'),
(369, 120, 'ElggObject', 'object', 'etherpad', 'create', 97, 97, 1, 'yes', 1448027536, '192.226.236.47'),
(370, 121, 'ElggComment', 'object', 'comment', 'create', 97, 97, 1, 'yes', 1448027630, '192.226.236.47'),
(371, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448028075, '192.226.236.47'),
(372, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448028075, '192.226.236.47'),
(373, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448028075, '192.226.236.47'),
(374, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448033720, '142.169.78.229'),
(375, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448033720, '142.169.78.229'),
(376, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448033720, '142.169.78.229'),
(377, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448046568, '192.226.236.47'),
(378, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448046568, '192.226.236.47'),
(379, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448046568, '192.226.236.47'),
(380, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448046788, '192.226.236.47'),
(381, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448046788, '192.226.236.47'),
(382, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448046788, '192.226.236.47'),
(383, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448047868, '192.226.236.47'),
(384, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448047868, '192.226.236.47'),
(385, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448047868, '192.226.236.47'),
(386, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448378528, '198.103.196.150'),
(387, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448378528, '198.103.196.150'),
(388, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448378528, '198.103.196.150'),
(389, 87, 'ElggRelationship', 'relationship', 'member_of_site', 'create', 97, 0, 2, 'yes', 1448389666, '198.103.196.150'),
(390, 122, 'ElggUser', 'user', '', 'create', 97, 0, 2, 'yes', 1448389666, '198.103.196.150'),
(391, 59, 'ElggMetadata', 'metadata', 'notification:method:email', 'create', 97, 122, 2, 'yes', 1448389666, '198.103.196.150'),
(392, 122, 'ElggUser', 'user', '', 'update', 97, 0, 2, 'yes', 1448389666, '198.103.196.150'),
(393, 122, 'ElggUser', 'user', '', 'update:after', 97, 0, 2, 'yes', 1448389666, '198.103.196.150'),
(394, 123, 'ElggWidget', 'object', 'widget', 'create', 97, 122, 1, 'yes', 1448389666, '198.103.196.150'),
(395, 124, 'ElggWidget', 'object', 'widget', 'create', 97, 122, 1, 'yes', 1448389666, '198.103.196.150'),
(396, 125, 'ElggWidget', 'object', 'widget', 'create', 97, 122, 1, 'yes', 1448389666, '198.103.196.150'),
(397, 126, 'ElggWidget', 'object', 'widget', 'create', 97, 122, 1, 'yes', 1448389666, '198.103.196.150'),
(398, 127, 'ElggWidget', 'object', 'widget', 'create', 97, 122, 1, 'yes', 1448389666, '198.103.196.150'),
(399, 60, 'ElggMetadata', 'metadata', 'validated', 'create', 97, 97, 2, 'yes', 1448389666, '198.103.196.150'),
(400, 61, 'ElggMetadata', 'metadata', 'validated_method', 'create', 97, 97, 2, 'yes', 1448389666, '198.103.196.150'),
(401, 122, 'ElggUser', 'user', '', 'make_admin', 97, 0, 2, 'yes', 1448389666, '198.103.196.150'),
(402, 62, 'ElggMetadata', 'metadata', 'admin_created', 'create', 97, 122, 2, 'yes', 1448389666, '198.103.196.150'),
(403, 63, 'ElggMetadata', 'metadata', 'created_by_guid', 'create', 97, 122, 2, 'yes', 1448389666, '198.103.196.150'),
(404, 88, 'ElggRelationship', 'relationship', 'member_of_site', 'create', 97, 0, 2, 'yes', 1448389719, '198.103.196.150'),
(405, 128, 'ElggUser', 'user', '', 'create', 97, 0, 2, 'yes', 1448389719, '198.103.196.150'),
(406, 64, 'ElggMetadata', 'metadata', 'notification:method:email', 'create', 97, 128, 2, 'yes', 1448389719, '198.103.196.150'),
(407, 128, 'ElggUser', 'user', '', 'update', 97, 0, 2, 'yes', 1448389719, '198.103.196.150'),
(408, 128, 'ElggUser', 'user', '', 'update:after', 97, 0, 2, 'yes', 1448389719, '198.103.196.150'),
(409, 129, 'ElggWidget', 'object', 'widget', 'create', 97, 128, 1, 'yes', 1448389719, '198.103.196.150'),
(410, 130, 'ElggWidget', 'object', 'widget', 'create', 97, 128, 1, 'yes', 1448389719, '198.103.196.150'),
(411, 131, 'ElggWidget', 'object', 'widget', 'create', 97, 128, 1, 'yes', 1448389719, '198.103.196.150'),
(412, 132, 'ElggWidget', 'object', 'widget', 'create', 97, 128, 1, 'yes', 1448389719, '198.103.196.150'),
(413, 133, 'ElggWidget', 'object', 'widget', 'create', 97, 128, 1, 'yes', 1448389719, '198.103.196.150'),
(414, 65, 'ElggMetadata', 'metadata', 'validated', 'create', 97, 97, 2, 'yes', 1448389719, '198.103.196.150'),
(415, 66, 'ElggMetadata', 'metadata', 'validated_method', 'create', 97, 97, 2, 'yes', 1448389719, '198.103.196.150'),
(416, 128, 'ElggUser', 'user', '', 'make_admin', 97, 0, 2, 'yes', 1448389719, '198.103.196.150'),
(417, 67, 'ElggMetadata', 'metadata', 'admin_created', 'create', 97, 128, 2, 'yes', 1448389719, '198.103.196.150'),
(418, 68, 'ElggMetadata', 'metadata', 'created_by_guid', 'create', 97, 128, 2, 'yes', 1448389719, '198.103.196.150'),
(419, 89, 'ElggRelationship', 'relationship', 'friendrequest', 'create', 97, 0, 2, 'yes', 1448389769, '198.103.196.150'),
(420, 90, 'ElggRelationship', 'relationship', 'friendrequest', 'create', 97, 0, 2, 'yes', 1448389778, '198.103.196.150'),
(421, 128, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448390049, '198.103.196.150'),
(422, 128, 'ElggUser', 'user', '', 'login', 128, 0, 2, 'yes', 1448390049, '198.103.196.150'),
(423, 128, 'ElggUser', 'user', '', 'login:after', 128, 0, 2, 'yes', 1448390049, '198.103.196.150'),
(424, 90, 'ElggRelationship', 'relationship', 'friendrequest', 'delete', 128, 0, 2, 'yes', 1448390200, '198.103.196.150'),
(425, 91, 'ElggRelationship', 'relationship', 'friend', 'create', 128, 0, 2, 'yes', 1448390200, '198.103.196.150'),
(426, 92, 'ElggRelationship', 'relationship', 'friend', 'create', 128, 0, 2, 'yes', 1448390200, '198.103.196.150'),
(427, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448393765, '198.103.196.150'),
(428, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448393765, '198.103.196.150'),
(429, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448393765, '198.103.196.150'),
(430, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448541856, '198.103.196.150'),
(431, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448541856, '198.103.196.150'),
(432, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448541856, '198.103.196.150'),
(433, 69, 'ElggMetadata', 'metadata', 'x1', 'create', 97, 97, 2, 'yes', 1448542249, '198.103.196.150'),
(434, 70, 'ElggMetadata', 'metadata', 'x2', 'create', 97, 97, 2, 'yes', 1448542249, '198.103.196.150'),
(435, 71, 'ElggMetadata', 'metadata', 'y1', 'create', 97, 97, 2, 'yes', 1448542249, '198.103.196.150'),
(436, 72, 'ElggMetadata', 'metadata', 'y2', 'create', 97, 97, 2, 'yes', 1448542249, '198.103.196.150'),
(437, 73, 'ElggMetadata', 'metadata', 'icontime', 'create', 97, 97, 2, 'yes', 1448542249, '198.103.196.150'),
(438, 97, 'ElggUser', 'user', '', 'profileiconupdate', 97, 0, 2, 'yes', 1448542249, '198.103.196.150'),
(439, 74, 'ElggMetadata', 'metadata', 'active_badge', 'create', 97, 97, 2, 'yes', 1448542324, '198.103.196.150'),
(440, 73, 'ElggMetadata', 'metadata', 'icontime', 'delete', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(441, 75, 'ElggMetadata', 'metadata', 'icontime', 'create', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(442, 69, 'ElggMetadata', 'metadata', 'x1', 'delete', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(443, 76, 'ElggMetadata', 'metadata', 'x1', 'create', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(444, 70, 'ElggMetadata', 'metadata', 'x2', 'delete', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(445, 77, 'ElggMetadata', 'metadata', 'x2', 'create', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(446, 71, 'ElggMetadata', 'metadata', 'y1', 'delete', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(447, 78, 'ElggMetadata', 'metadata', 'y1', 'create', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(448, 72, 'ElggMetadata', 'metadata', 'y2', 'delete', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(449, 79, 'ElggMetadata', 'metadata', 'y2', 'create', 97, 97, 2, 'yes', 1448542325, '198.103.196.150'),
(450, 120, 'ElggObject', 'object', 'etherpad', 'delete', 97, 97, 1, 'yes', 1448545387, '198.103.196.150'),
(451, 56, 'ElggMetadata', 'metadata', 'url', 'delete', 97, 97, 1, 'yes', 1448545387, '198.103.196.150'),
(452, 57, 'ElggMetadata', 'metadata', 'objetive', 'delete', 97, 97, 1, 'yes', 1448545387, '198.103.196.150'),
(453, 58, 'ElggMetadata', 'metadata', 'group_guid', 'delete', 97, 97, 1, 'yes', 1448545387, '198.103.196.150'),
(454, 80, 'ElggMetadata', 'metadata', 'url', 'create', 97, 97, 1, 'yes', 1448545438, '198.103.196.150'),
(455, 81, 'ElggMetadata', 'metadata', 'objetive', 'create', 97, 97, 1, 'yes', 1448545438, '198.103.196.150'),
(456, 82, 'ElggMetadata', 'metadata', 'group_guid', 'create', 97, 97, 1, 'yes', 1448545438, '198.103.196.150'),
(457, 134, 'ElggObject', 'object', 'etherpad', 'create', 97, 97, 1, 'yes', 1448545438, '198.103.196.150'),
(458, 29, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448546364, '198.103.196.150'),
(459, 134, 'ElggObject', 'object', 'etherpad', 'update', 97, 97, 2, 'yes', 1448549276, '198.103.196.150'),
(460, 134, 'ElggObject', 'object', 'etherpad', 'update:after', 97, 97, 2, 'yes', 1448549276, '198.103.196.150'),
(461, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448549434, '198.103.196.150'),
(462, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448549434, '198.103.196.150'),
(463, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448549434, '198.103.196.150'),
(464, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448550375, '198.103.196.150'),
(465, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448550375, '198.103.196.150'),
(466, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448550375, '198.103.196.150'),
(467, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448562032, '198.103.196.150'),
(468, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448562032, '198.103.196.150'),
(469, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448562032, '198.103.196.150'),
(470, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448581153, '192.226.231.162'),
(471, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448581154, '192.226.231.162'),
(472, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448581154, '192.226.231.162');
INSERT INTO `elgg_system_log` (`id`, `object_id`, `object_class`, `object_type`, `object_subtype`, `event`, `performed_by_guid`, `owner_guid`, `access_id`, `enabled`, `time_created`, `ip_address`) VALUES
(473, 69, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448587710, '192.226.231.162'),
(474, 85, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448589302, '192.226.231.162'),
(475, 83, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1448589302, '192.226.231.162'),
(476, 135, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1448589302, '192.226.231.162'),
(477, 136, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448589816, '192.226.231.162'),
(478, 137, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448589816, '192.226.231.162'),
(479, 112, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1448589816, '192.226.231.162'),
(480, 112, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1448589816, '192.226.231.162'),
(481, 93, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448590126, '192.226.231.162'),
(482, 94, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448590276, '192.226.231.162'),
(483, 95, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448590332, '192.226.231.162'),
(484, 135, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1448590371, '192.226.231.162'),
(485, 83, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1448590371, '192.226.231.162'),
(486, 31, 'ElggMetadata', 'metadata', 'file_tools_structure_management_enable', 'delete', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(487, 84, 'ElggMetadata', 'metadata', 'file_tools_structure_management_enable', 'create', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(488, 33, 'ElggMetadata', 'metadata', 'subgroups_members_create_enable', 'delete', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(489, 85, 'ElggMetadata', 'metadata', 'subgroups_members_create_enable', 'create', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(490, 117, 'ElggGroup', 'group', '', 'update', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(491, 117, 'ElggGroup', 'group', '', 'update:after', 97, 97, 2, 'yes', 1448590898, '192.226.231.162'),
(492, 86, 'ElggMetadata', 'metadata', 'status', 'create', 97, 97, 0, 'yes', 1448590999, '192.226.231.162'),
(493, 87, 'ElggMetadata', 'metadata', 'comments_on', 'create', 97, 97, 0, 'yes', 1448590999, '192.226.231.162'),
(494, 88, 'ElggMetadata', 'metadata', 'excerpt', 'create', 97, 97, 0, 'yes', 1448590999, '192.226.231.162'),
(495, 89, 'ElggMetadata', 'metadata', 'future_access', 'create', 97, 97, 0, 'yes', 1448590999, '192.226.231.162'),
(496, 138, 'ElggBlog', 'object', 'blog', 'create', 97, 97, 0, 'yes', 1448590999, '192.226.231.162'),
(497, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1448591040, '192.226.231.162'),
(498, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1448591040, '192.226.231.162'),
(499, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1448591040, '192.226.231.162'),
(500, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448628224, '198.103.196.150'),
(501, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448628224, '198.103.196.150'),
(502, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448628224, '198.103.196.150'),
(503, 96, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448629773, '198.103.196.150'),
(504, 90, 'ElggMetadata', 'metadata', 'status', 'create', 97, 97, 0, 'yes', 1448631001, '198.103.196.150'),
(505, 91, 'ElggMetadata', 'metadata', 'comments_on', 'create', 97, 97, 0, 'yes', 1448631001, '198.103.196.150'),
(506, 92, 'ElggMetadata', 'metadata', 'excerpt', 'create', 97, 97, 0, 'yes', 1448631001, '198.103.196.150'),
(507, 93, 'ElggMetadata', 'metadata', 'future_access', 'create', 97, 97, 0, 'yes', 1448631001, '198.103.196.150'),
(508, 139, 'ElggBlog', 'object', 'blog', 'create', 97, 97, 0, 'yes', 1448631001, '198.103.196.150'),
(509, 139, 'ElggBlog', 'object', 'blog', 'update', 97, 97, 0, 'yes', 1448631109, '198.103.196.150'),
(510, 139, 'ElggBlog', 'object', 'blog', 'update:after', 97, 97, 0, 'yes', 1448631109, '198.103.196.150'),
(511, 139, 'ElggBlog', 'object', 'blog', 'annotate', 97, 97, 0, 'yes', 1448631109, '198.103.196.150'),
(512, 1, 'ElggAnnotation', 'annotation', 'blog_revision', 'create', 97, 97, 0, 'yes', 1448631109, '198.103.196.150'),
(513, 90, 'ElggMetadata', 'metadata', 'status', 'delete', 97, 97, 0, 'yes', 1448631734, '198.103.196.150'),
(514, 94, 'ElggMetadata', 'metadata', 'status', 'create', 97, 97, 0, 'yes', 1448631734, '198.103.196.150'),
(515, 92, 'ElggMetadata', 'metadata', 'excerpt', 'delete', 97, 97, 0, 'yes', 1448631734, '198.103.196.150'),
(516, 95, 'ElggMetadata', 'metadata', 'excerpt', 'create', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(517, 96, 'ElggMetadata', 'metadata', 'tags', 'create', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(518, 97, 'ElggMetadata', 'metadata', 'tags', 'create', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(519, 98, 'ElggMetadata', 'metadata', 'tags', 'create', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(520, 139, 'ElggBlog', 'object', 'blog', 'update', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(521, 139, 'ElggBlog', 'object', 'blog', 'update:after', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(522, 139, 'ElggBlog', 'object', 'blog', 'annotate', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(523, 2, 'ElggAnnotation', 'annotation', 'blog_revision', 'create', 97, 97, 0, 'yes', 1448631734, '198.103.196.150'),
(524, 139, 'ElggBlog', 'object', 'blog', 'publish', 97, 97, 2, 'yes', 1448631734, '198.103.196.150'),
(525, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448643489, '192.226.231.162'),
(526, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448643489, '192.226.231.162'),
(527, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448643489, '192.226.231.162'),
(528, 97, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448643575, '192.226.231.162'),
(529, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448972678, '192.226.231.162'),
(530, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448972678, '192.226.231.162'),
(531, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448972678, '192.226.231.162'),
(532, 140, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1448972706, '192.226.231.162'),
(533, 95, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1448972763, '192.226.231.162'),
(534, 98, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1448972855, '192.226.231.162'),
(535, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1448972991, '192.226.231.162'),
(536, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1448972992, '192.226.231.162'),
(537, 51, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1448972992, '192.226.231.162'),
(538, 99, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448972992, '192.226.231.162'),
(539, 52, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1448972992, '192.226.231.162'),
(540, 100, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448972992, '192.226.231.162'),
(541, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(542, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(543, 99, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(544, 101, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(545, 100, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(546, 102, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448973016, '192.226.231.162'),
(547, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(548, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(549, 101, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(550, 103, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(551, 102, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(552, 104, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448973027, '192.226.231.162'),
(553, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(554, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(555, 103, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(556, 105, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(557, 104, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(558, 106, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448973289, '192.226.231.162'),
(559, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(560, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(561, 105, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(562, 107, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(563, 106, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(564, 108, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1448973315, '192.226.231.162'),
(565, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1448979644, '198.103.196.150'),
(566, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1448979644, '198.103.196.150'),
(567, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1448979644, '198.103.196.150'),
(568, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449493482, '198.103.196.150'),
(569, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449493482, '198.103.196.150'),
(570, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449493482, '198.103.196.150'),
(571, 99, 'ElggRelationship', 'relationship', 'member_of_site', 'create', 97, 0, 2, 'yes', 1449493835, '198.103.196.150'),
(572, 141, 'ElggUser', 'user', '', 'create', 97, 0, 2, 'yes', 1449493835, '198.103.196.150'),
(573, 109, 'ElggMetadata', 'metadata', 'notification:method:email', 'create', 97, 141, 2, 'yes', 1449493835, '198.103.196.150'),
(574, 141, 'ElggUser', 'user', '', 'update', 97, 0, 2, 'yes', 1449493835, '198.103.196.150'),
(575, 141, 'ElggUser', 'user', '', 'update:after', 97, 0, 2, 'yes', 1449493835, '198.103.196.150'),
(576, 110, 'ElggMetadata', 'metadata', 'admin_created', 'create', 97, 141, 2, 'yes', 1449493835, '198.103.196.150'),
(577, 111, 'ElggMetadata', 'metadata', 'created_by_guid', 'create', 97, 141, 2, 'yes', 1449493835, '198.103.196.150'),
(578, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(579, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(580, 107, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(581, 112, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(582, 108, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(583, 113, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449494049, '198.103.196.150'),
(584, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(585, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(586, 112, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(587, 114, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(588, 113, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(589, 115, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449494188, '198.103.196.150'),
(590, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449497001, '198.103.196.150'),
(591, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449497001, '198.103.196.150'),
(592, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449497001, '198.103.196.150'),
(593, 46, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449497075, '198.103.196.150'),
(594, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(595, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(596, 114, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(597, 116, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(598, 115, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(599, 117, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449497268, '198.103.196.150'),
(600, 100, 'ElggRelationship', 'relationship', 'active_plugin', 'create', 97, 0, 2, 'yes', 1449497317, '198.103.196.150'),
(601, 141, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449501840, '198.103.180.1'),
(602, 141, 'ElggUser', 'user', '', 'login', 141, 0, 2, 'yes', 1449501840, '198.103.180.1'),
(603, 141, 'ElggUser', 'user', '', 'login:after', 141, 0, 2, 'yes', 1449501840, '198.103.180.1'),
(604, 118, 'ElggMetadata', 'metadata', 'tags', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(605, 119, 'ElggMetadata', 'metadata', 'tags', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(606, 120, 'ElggMetadata', 'metadata', 'tags', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(607, 121, 'ElggMetadata', 'metadata', 'tags', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(608, 122, 'ElggMetadata', 'metadata', 'filename', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(609, 123, 'ElggMetadata', 'metadata', 'originalfilename', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(610, 124, 'ElggMetadata', 'metadata', 'mimetype', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(611, 125, 'ElggMetadata', 'metadata', 'simpletype', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(612, 142, 'FilePluginFile', 'object', 'file', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(613, 126, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(614, 127, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 141, 141, 1, 'yes', 1449502517, '198.103.180.1'),
(615, 142, 'ElggFile', 'object', 'file', 'update', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(616, 142, 'ElggFile', 'object', 'file', 'update:after', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(617, 126, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(618, 128, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(619, 127, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(620, 129, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 141, 141, 1, 'yes', 1449502675, '198.103.180.1'),
(621, 142, 'ElggFile', 'object', 'file', 'update', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(622, 142, 'ElggFile', 'object', 'file', 'update:after', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(623, 128, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(624, 130, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(625, 129, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(626, 131, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 141, 141, 1, 'yes', 1449502819, '198.103.180.1'),
(627, 142, 'ElggFile', 'object', 'file', 'update', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(628, 142, 'ElggFile', 'object', 'file', 'update:after', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(629, 130, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(630, 132, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(631, 131, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(632, 133, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 141, 141, 1, 'yes', 1449516217, '198.103.180.1'),
(633, 141, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449516395, '198.103.180.1'),
(634, 141, 'ElggUser', 'user', '', 'login', 141, 0, 2, 'yes', 1449516395, '198.103.180.1'),
(635, 141, 'ElggUser', 'user', '', 'login:after', 141, 0, 2, 'yes', 1449516395, '198.103.180.1'),
(636, 142, 'ElggFile', 'object', 'file', 'update', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(637, 142, 'ElggFile', 'object', 'file', 'update:after', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(638, 132, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(639, 134, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(640, 133, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(641, 135, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 141, 141, 1, 'yes', 1449516408, '198.103.180.1'),
(642, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449538844, '192.226.231.162'),
(643, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449538844, '192.226.231.162'),
(644, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449538844, '192.226.231.162'),
(645, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(646, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(647, 116, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(648, 136, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(649, 117, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(650, 137, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449538877, '192.226.231.162'),
(651, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449538955, '192.226.231.162'),
(652, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449538955, '192.226.231.162'),
(653, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449538955, '192.226.231.162'),
(654, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(655, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(656, 136, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(657, 138, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(658, 137, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(659, 139, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449538957, '192.226.231.162'),
(660, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(661, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(662, 138, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(663, 140, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(664, 139, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(665, 141, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449539060, '192.226.231.162'),
(666, 52, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449540147, '192.226.231.162'),
(667, 52, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449540148, '192.226.231.162'),
(668, 51, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449540318, '192.226.231.162'),
(669, 50, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449540392, '192.226.231.162'),
(670, 41, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449540484, '192.226.231.162'),
(671, 40, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449541363, '192.226.231.162'),
(672, 142, 'ElggMetadata', 'metadata', 'admin_notice_id', 'create', 97, 97, 0, 'yes', 1449541364, '192.226.231.162'),
(673, 143, 'ElggObject', 'object', 'admin_notice', 'create', 97, 97, 0, 'yes', 1449541364, '192.226.231.162'),
(674, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449541364, '192.226.231.162'),
(675, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449541364, '192.226.231.162'),
(676, 140, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449541364, '192.226.231.162'),
(677, 141, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449541364, '192.226.231.162'),
(678, 144, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449541364, '192.226.231.162'),
(679, 144, 'ElggPlugin', 'object', 'plugin', 'create', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(680, 27, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(681, 27, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(682, 37, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(683, 37, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(684, 40, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(685, 40, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(686, 64, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(687, 64, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(688, 65, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(689, 65, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(690, 66, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(691, 66, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(692, 67, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(693, 67, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(694, 68, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(695, 68, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(696, 19, 'ElggPlugin', 'object', 'plugin', 'disable', 97, 1, 2, 'yes', 1449541380, '192.226.231.162'),
(697, 19, 'ElggPlugin', 'object', 'plugin', 'disable:after', 97, 1, 2, 'no', 1449541380, '192.226.231.162'),
(698, 143, 'ElggObject', 'object', 'admin_notice', 'delete', 97, 97, 0, 'yes', 1449541413, '192.226.231.162'),
(699, 142, 'ElggMetadata', 'metadata', 'admin_notice_id', 'delete', 97, 97, 0, 'yes', 1449541413, '192.226.231.162'),
(700, 142, 'ElggFile', 'object', 'file', 'annotate', 97, 141, 1, 'yes', 1449541522, '192.226.231.162'),
(701, 3, 'ElggAnnotation', 'annotation', 'likes', 'create', 97, 97, 1, 'yes', 1449541522, '192.226.231.162'),
(702, 142, 'ElggFile', 'object', 'file', 'update', 97, 141, 1, 'yes', 1449541548, '192.226.231.162'),
(703, 142, 'ElggFile', 'object', 'file', 'update:after', 97, 141, 1, 'yes', 1449541548, '192.226.231.162'),
(704, 134, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 141, 1, 'yes', 1449541548, '192.226.231.162'),
(705, 145, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 141, 1, 'yes', 1449541548, '192.226.231.162'),
(706, 135, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 141, 1, 'yes', 1449541548, '192.226.231.162'),
(707, 146, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 141, 1, 'yes', 1449541549, '192.226.231.162'),
(708, 97, 'ElggUser', 'user', '', 'logout:before', 97, 0, 2, 'yes', 1449541918, '192.226.231.162'),
(709, 97, 'ElggUser', 'user', '', 'logout', 97, 0, 2, 'yes', 1449541918, '192.226.231.162'),
(710, 97, 'ElggUser', 'user', '', 'logout:after', 0, 0, 2, 'yes', 1449541918, '192.226.231.162'),
(711, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449581768, '198.103.196.150'),
(712, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449581768, '198.103.196.150'),
(713, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449581768, '198.103.196.150'),
(714, 97, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449582099, '198.103.196.150'),
(715, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(716, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(717, 143, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(718, 147, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(719, 144, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(720, 148, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449582521, '198.103.196.150'),
(721, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(722, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(723, 147, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(724, 149, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(725, 148, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(726, 150, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449582557, '198.103.196.150'),
(727, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(728, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(729, 149, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(730, 151, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(731, 150, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(732, 152, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449582567, '198.103.196.150'),
(733, 118, 'ElggFile', 'object', 'file', 'update', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(734, 118, 'ElggFile', 'object', 'file', 'update:after', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(735, 151, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'delete', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(736, 153, 'ElggMetadata', 'metadata', 'filestore::dir_root', 'create', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(737, 152, 'ElggMetadata', 'metadata', 'filestore::filestore', 'delete', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(738, 154, 'ElggMetadata', 'metadata', 'filestore::filestore', 'create', 97, 97, 1, 'yes', 1449582596, '198.103.196.150'),
(739, 72, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449591556, '198.103.196.150'),
(740, 70, 'ElggRelationship', 'relationship', 'active_plugin', 'delete', 97, 0, 2, 'yes', 1449591713, '198.103.196.150'),
(741, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449602645, '70.53.197.81'),
(742, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449602645, '70.53.197.81'),
(743, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449602645, '70.53.197.81'),
(744, 97, 'ElggUser', 'user', '', 'login:before', 0, 0, 2, 'yes', 1449625247, '127.0.0.1'),
(745, 97, 'ElggUser', 'user', '', 'login', 97, 0, 2, 'yes', 1449625247, '127.0.0.1'),
(746, 97, 'ElggUser', 'user', '', 'login:after', 97, 0, 2, 'yes', 1449625247, '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `elgg_users_apisessions`
--

DROP TABLE IF EXISTS `elgg_users_apisessions`;
CREATE TABLE IF NOT EXISTS `elgg_users_apisessions` (
  `id` int(11) NOT NULL,
  `user_guid` bigint(20) unsigned NOT NULL,
  `site_guid` bigint(20) unsigned NOT NULL,
  `token` varchar(40) DEFAULT NULL,
  `expires` int(11) NOT NULL
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elgg_users_entity`
--

DROP TABLE IF EXISTS `elgg_users_entity`;
CREATE TABLE IF NOT EXISTS `elgg_users_entity` (
  `guid` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `username` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT 'Legacy password hashes',
  `salt` varchar(8) NOT NULL DEFAULT '' COMMENT 'Legacy password salts',
  `password_hash` varchar(255) NOT NULL DEFAULT '',
  `email` text NOT NULL,
  `language` varchar(6) NOT NULL DEFAULT '',
  `banned` enum('yes','no') NOT NULL DEFAULT 'no',
  `admin` enum('yes','no') NOT NULL DEFAULT 'no',
  `last_action` int(11) NOT NULL DEFAULT '0',
  `prev_last_action` int(11) NOT NULL DEFAULT '0',
  `last_login` int(11) NOT NULL DEFAULT '0',
  `prev_last_login` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_users_entity`
--

INSERT INTO `elgg_users_entity` (`guid`, `name`, `username`, `password`, `salt`, `password_hash`, `email`, `language`, `banned`, `admin`, `last_action`, `prev_last_action`, `last_login`, `prev_last_login`) VALUES
(97, 'Sébastien Lemay', 'smellems', '', '', '$2y$10$wRZF5PlhbHKWPctDaPlMA.mxoopDShJdFmxphtnqStNVh/fS7d7HG', 'smellems@gmail.com', 'en', 'no', 'yes', 1449625348, 1449625347, 1449625247, 1449602645),
(128, 'Louis-Philippe Fillion', 'louis-philippe.fillion', '', '', '$2y$10$sdQmd6PspTA0Ea3PuSErR..DV1qS1H69nNis9W1w6DGW62fa.dhs2', 'louis-philippe.fillion@canada.ca', 'en', 'no', 'yes', 1448398059, 1448395662, 1448390049, 0),
(122, 'Martin Lortie', 'martin.lortie', '', '', '$2y$10$Xm0Wxal/mSRAhS9Sq7yCGeMWtWB/RrU85OMHRrd2/sAX./yUs.3UG', 'martin.lortie@canada.ca', 'en', 'no', 'yes', 0, 0, 0, 0),
(141, 'Sahben Souissi', 'sahben.souissi', '', '', '$2y$10$sPOQqMyFpdgv7l7IAuflGetu2PeFcB8rec5DbPHmuW757E4yMUWwa', 'sahben.souissi@canada.ca', 'en', 'no', 'no', 1449516612, 1449516510, 1449516395, 1449501840);

-- --------------------------------------------------------

--
-- Table structure for table `elgg_users_remember_me_cookies`
--

DROP TABLE IF EXISTS `elgg_users_remember_me_cookies`;
CREATE TABLE IF NOT EXISTS `elgg_users_remember_me_cookies` (
  `code` varchar(32) NOT NULL,
  `guid` bigint(20) unsigned NOT NULL,
  `timestamp` int(11) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `elgg_users_sessions`
--

DROP TABLE IF EXISTS `elgg_users_sessions`;
CREATE TABLE IF NOT EXISTS `elgg_users_sessions` (
  `session` varchar(255) NOT NULL,
  `ts` int(11) unsigned NOT NULL DEFAULT '0',
  `data` mediumblob
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `elgg_users_sessions`
--

INSERT INTO `elgg_users_sessions` (`session`, `ts`, `data`) VALUES
('7a6c8942abc429cc814d38e24328da02', 1449602623, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a226361643665353137383334386663613434626666393033386136396661623638223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630323631383b733a313a2263223b693a313434393630323630333b733a313a226c223b733a313a2230223b7d),
('ba66b57fb8694f1ff4e928564373450d', 1449603886, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a226531313664633734633137323533393831333130316433396437616433643734223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333838313b733a313a2263223b693a313434393630333838313b733a313a226c223b733a313a2230223b7d),
('4e30f94c5f3d5ea6b250fdcf843ab05d', 1449603886, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223530326263646332373761316230663564316137353137343938656164343738223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333838313b733a313a2263223b693a313434393630333838313b733a313a226c223b733a313a2230223b7d),
('129861be2abb5c646e495d240dd6bf4b', 1449623462, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223638383961396535303961323264623838646435353530663131343234306533223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393632333436303b733a313a2263223b693a313434393631333636323b733a313a226c223b733a313a2230223b7d),
('975013156d41ac7fc15de2a4395cc7d2', 1449623702, 0x5f7366325f617474726962757465737c613a353a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223237656434303239313862656566326134643061303965333730633965313063223b733a383a226c616e6775616765223b733a323a22656e223b733a343a2267756964223b693a39373b733a333a226d7367223b613a303a7b7d733a31323a22737469636b795f666f726d73223b613a303a7b7d7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393632333639383b733a313a2263223b693a313434393538313733333b733a313a226c223b733a313a2230223b7d),
('91f172ab077c7e5d8764ee3b413dffac', 1449603879, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223531363533306432326630653933383762393334396234393638393062613531223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333837313b733a313a2263223b693a313434393630333837313b733a313a226c223b733a313a2230223b7d),
('2210456b8316f57eb458a491d4d3896e', 1449603879, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a226263323930313432653966646366356537323065666465383334353638386432223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333837323b733a313a2263223b693a313434393630333837323b733a313a226c223b733a313a2230223b7d),
('f25fe33b63f738d531e1ead4127d9bb2', 1449605067, 0x5f7366325f617474726962757465737c613a343a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a226361643665353137383334386663613434626666393033386136396661623638223b733a383a226c616e6775616765223b733a323a22656e223b733a343a2267756964223b693a39373b733a333a226d7367223b613a303a7b7d7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630353036343b733a313a2263223b693a313434393630323630333b733a313a226c223b733a313a2230223b7d),
('59683b9fbc38ec6163f36be216114953', 1449603869, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223261323332316137356664653063373931346137323834393664376363356634223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333836343b733a313a2263223b693a313434393630333836343b733a313a226c223b733a313a2230223b7d),
('3255c4c023ea297b39315c7d276300a9', 1449603879, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223634633665643337346639643630613934386264653635666631666130643630223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393630333837313b733a313a2263223b693a313434393630333837313b733a313a226c223b733a313a2230223b7d),
('3kcj0b1k0sg3ccvi8db1927v31', 1449625230, 0x5f7366325f617474726962757465737c613a323a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223031336161313438353739666231643063386433616564316266386165626330223b733a383a226c616e6775616765223b733a323a22656e223b7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393632353233303b733a313a2263223b693a313434393632353033323b733a313a226c223b733a313a2230223b7d),
('s9k26ce3hbvih6qosfej1rc6o0', 1449625348, 0x5f7366325f617474726962757465737c613a343a7b733a31343a225f5f656c67675f73657373696f6e223b733a33323a223031336161313438353739666231643063386433616564316266386165626330223b733a383a226c616e6775616765223b733a323a22656e223b733a343a2267756964223b693a39373b733a333a226d7367223b613a303a7b7d7d5f7366325f666c61736865737c613a303a7b7d5f7366325f6d6574617c613a333a7b733a313a2275223b693a313434393632353334383b733a313a2263223b693a313434393632353033323b733a313a226c223b733a313a2230223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `email_extensions`
--

DROP TABLE IF EXISTS `email_extensions`;
CREATE TABLE IF NOT EXISTS `email_extensions` (
  `id` int(11) NOT NULL,
  `ext` char(30) DEFAULT NULL,
  `dept` char(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_extensions`
--

INSERT INTO `email_extensions` (`id`, `ext`, `dept`) VALUES
(1, 'canada.ca', 'GC'),
(2, 'smellems.com', 'smellems');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `elgg_access_collections`
--
ALTER TABLE `elgg_access_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_guid` (`owner_guid`),
  ADD KEY `site_guid` (`site_guid`);

--
-- Indexes for table `elgg_access_collection_membership`
--
ALTER TABLE `elgg_access_collection_membership`
  ADD PRIMARY KEY (`user_guid`,`access_collection_id`);

--
-- Indexes for table `elgg_annotations`
--
ALTER TABLE `elgg_annotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_guid` (`entity_guid`),
  ADD KEY `name_id` (`name_id`),
  ADD KEY `value_id` (`value_id`),
  ADD KEY `owner_guid` (`owner_guid`),
  ADD KEY `access_id` (`access_id`);

--
-- Indexes for table `elgg_api_users`
--
ALTER TABLE `elgg_api_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `api_key` (`api_key`);

--
-- Indexes for table `elgg_config`
--
ALTER TABLE `elgg_config`
  ADD PRIMARY KEY (`name`,`site_guid`);

--
-- Indexes for table `elgg_datalists`
--
ALTER TABLE `elgg_datalists`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `elgg_entities`
--
ALTER TABLE `elgg_entities`
  ADD PRIMARY KEY (`guid`),
  ADD KEY `type` (`type`),
  ADD KEY `subtype` (`subtype`),
  ADD KEY `owner_guid` (`owner_guid`),
  ADD KEY `site_guid` (`site_guid`),
  ADD KEY `container_guid` (`container_guid`),
  ADD KEY `access_id` (`access_id`),
  ADD KEY `time_created` (`time_created`),
  ADD KEY `time_updated` (`time_updated`);

--
-- Indexes for table `elgg_entity_relationships`
--
ALTER TABLE `elgg_entity_relationships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guid_one` (`guid_one`,`relationship`,`guid_two`),
  ADD KEY `relationship` (`relationship`),
  ADD KEY `guid_two` (`guid_two`);

--
-- Indexes for table `elgg_entity_subtypes`
--
ALTER TABLE `elgg_entity_subtypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type` (`type`,`subtype`);

--
-- Indexes for table `elgg_geocode_cache`
--
ALTER TABLE `elgg_geocode_cache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `location` (`location`);

--
-- Indexes for table `elgg_groups_entity`
--
ALTER TABLE `elgg_groups_entity`
  ADD PRIMARY KEY (`guid`),
  ADD KEY `name` (`name`(50)),
  ADD KEY `description` (`description`(50)),
  ADD FULLTEXT KEY `name_2` (`name`,`description`);

--
-- Indexes for table `elgg_hmac_cache`
--
ALTER TABLE `elgg_hmac_cache`
  ADD PRIMARY KEY (`hmac`),
  ADD KEY `ts` (`ts`);

--
-- Indexes for table `elgg_metadata`
--
ALTER TABLE `elgg_metadata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_guid` (`entity_guid`),
  ADD KEY `name_id` (`name_id`),
  ADD KEY `value_id` (`value_id`),
  ADD KEY `owner_guid` (`owner_guid`),
  ADD KEY `access_id` (`access_id`);

--
-- Indexes for table `elgg_metastrings`
--
ALTER TABLE `elgg_metastrings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `string` (`string`(50));

--
-- Indexes for table `elgg_objects_entity`
--
ALTER TABLE `elgg_objects_entity`
  ADD PRIMARY KEY (`guid`),
  ADD FULLTEXT KEY `title` (`title`,`description`);

--
-- Indexes for table `elgg_private_settings`
--
ALTER TABLE `elgg_private_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `entity_guid` (`entity_guid`,`name`),
  ADD KEY `name` (`name`),
  ADD KEY `value` (`value`(50));

--
-- Indexes for table `elgg_queue`
--
ALTER TABLE `elgg_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `retrieve` (`timestamp`,`worker`);

--
-- Indexes for table `elgg_river`
--
ALTER TABLE `elgg_river`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `action_type` (`action_type`),
  ADD KEY `access_id` (`access_id`),
  ADD KEY `subject_guid` (`subject_guid`),
  ADD KEY `object_guid` (`object_guid`),
  ADD KEY `target_guid` (`target_guid`),
  ADD KEY `annotation_id` (`annotation_id`),
  ADD KEY `posted` (`posted`);

--
-- Indexes for table `elgg_sites_entity`
--
ALTER TABLE `elgg_sites_entity`
  ADD PRIMARY KEY (`guid`),
  ADD UNIQUE KEY `url` (`url`),
  ADD FULLTEXT KEY `name` (`name`,`description`,`url`);

--
-- Indexes for table `elgg_system_log`
--
ALTER TABLE `elgg_system_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `object_id` (`object_id`),
  ADD KEY `object_class` (`object_class`),
  ADD KEY `object_type` (`object_type`),
  ADD KEY `object_subtype` (`object_subtype`),
  ADD KEY `event` (`event`),
  ADD KEY `performed_by_guid` (`performed_by_guid`),
  ADD KEY `access_id` (`access_id`),
  ADD KEY `time_created` (`time_created`),
  ADD KEY `river_key` (`object_type`,`object_subtype`,`event`);

--
-- Indexes for table `elgg_users_apisessions`
--
ALTER TABLE `elgg_users_apisessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_guid` (`user_guid`,`site_guid`),
  ADD KEY `token` (`token`);

--
-- Indexes for table `elgg_users_entity`
--
ALTER TABLE `elgg_users_entity`
  ADD PRIMARY KEY (`guid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `password` (`password`),
  ADD KEY `email` (`email`(50)),
  ADD KEY `last_action` (`last_action`),
  ADD KEY `last_login` (`last_login`),
  ADD KEY `admin` (`admin`),
  ADD FULLTEXT KEY `name` (`name`);
ALTER TABLE `elgg_users_entity`
  ADD FULLTEXT KEY `name_2` (`name`,`username`);

--
-- Indexes for table `elgg_users_remember_me_cookies`
--
ALTER TABLE `elgg_users_remember_me_cookies`
  ADD PRIMARY KEY (`code`),
  ADD KEY `timestamp` (`timestamp`);

--
-- Indexes for table `elgg_users_sessions`
--
ALTER TABLE `elgg_users_sessions`
  ADD PRIMARY KEY (`session`),
  ADD KEY `ts` (`ts`);

--
-- Indexes for table `email_extensions`
--
ALTER TABLE `email_extensions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `elgg_access_collections`
--
ALTER TABLE `elgg_access_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `elgg_annotations`
--
ALTER TABLE `elgg_annotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `elgg_api_users`
--
ALTER TABLE `elgg_api_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `elgg_entities`
--
ALTER TABLE `elgg_entities`
  MODIFY `guid` bigint(20) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=145;
--
-- AUTO_INCREMENT for table `elgg_entity_relationships`
--
ALTER TABLE `elgg_entity_relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `elgg_entity_subtypes`
--
ALTER TABLE `elgg_entity_subtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `elgg_geocode_cache`
--
ALTER TABLE `elgg_geocode_cache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `elgg_metadata`
--
ALTER TABLE `elgg_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=155;
--
-- AUTO_INCREMENT for table `elgg_metastrings`
--
ALTER TABLE `elgg_metastrings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=125;
--
-- AUTO_INCREMENT for table `elgg_private_settings`
--
ALTER TABLE `elgg_private_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=562;
--
-- AUTO_INCREMENT for table `elgg_queue`
--
ALTER TABLE `elgg_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `elgg_river`
--
ALTER TABLE `elgg_river`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `elgg_system_log`
--
ALTER TABLE `elgg_system_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=747;
--
-- AUTO_INCREMENT for table `elgg_users_apisessions`
--
ALTER TABLE `elgg_users_apisessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_extensions`
--
ALTER TABLE `email_extensions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
