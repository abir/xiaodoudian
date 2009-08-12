<?php
if (!defined('IN_PHPBB')) exit;
$this->vars = array (
  'mysqli_version' => '5.1.33-community',
  'config' => 
  array (
    'active_sessions' => '0',
    'allow_attachments' => '1',
    'allow_autologin' => '1',
    'allow_avatar_local' => '0',
    'allow_avatar_remote' => '0',
    'allow_avatar_upload' => '0',
    'allow_bbcode' => '1',
    'allow_birthdays' => '1',
    'allow_bookmarks' => '1',
    'allow_emailreuse' => '0',
    'allow_forum_notify' => '1',
    'allow_mass_pm' => '1',
    'allow_name_chars' => 'USERNAME_CHARS_ANY',
    'allow_namechange' => '0',
    'allow_nocensors' => '0',
    'allow_pm_attach' => '0',
    'allow_post_flash' => '1',
    'allow_post_links' => '1',
    'allow_privmsg' => '1',
    'allow_sig' => '1',
    'allow_sig_bbcode' => '1',
    'allow_sig_flash' => '0',
    'allow_sig_img' => '1',
    'allow_sig_links' => '1',
    'allow_sig_pm' => '1',
    'allow_sig_smilies' => '1',
    'allow_smilies' => '1',
    'allow_topic_notify' => '1',
    'attachment_quota' => '52428800',
    'auth_bbcode_pm' => '1',
    'auth_flash_pm' => '0',
    'auth_img_pm' => '1',
    'auth_method' => 'db',
    'auth_smilies_pm' => '1',
    'avatar_filesize' => '6144',
    'avatar_gallery_path' => 'images/avatars/gallery',
    'avatar_max_height' => '90',
    'avatar_max_width' => '90',
    'avatar_min_height' => '20',
    'avatar_min_width' => '20',
    'avatar_path' => 'images/avatars/upload',
    'avatar_salt' => 'd40db9f7d7fb9e7cdea20d9c1b68e2b7',
    'board_contact' => 'wuts73@gmail.com',
    'board_disable' => '0',
    'board_disable_msg' => '',
    'board_dst' => '0',
    'board_email' => 'wuts73@gmail.com',
    'board_email_form' => '0',
    'board_email_sig' => '非常感谢, 论坛管理团队',
    'board_hide_emails' => '1',
    'board_timezone' => '0',
    'browser_check' => '1',
    'bump_interval' => '10',
    'bump_type' => 'd',
    'cache_gc' => '7200',
    'captcha_gd' => '1',
    'captcha_gd_foreground_noise' => '0',
    'captcha_gd_x_grid' => '25',
    'captcha_gd_y_grid' => '25',
    'captcha_gd_wave' => '0',
    'captcha_gd_3d_noise' => '1',
    'captcha_gd_fonts' => '1',
    'confirm_refresh' => '1',
    'check_attachment_content' => '1',
    'check_dnsbl' => '0',
    'chg_passforce' => '0',
    'cookie_domain' => 'localhost',
    'cookie_name' => 'phpbb3_57vqn',
    'cookie_path' => '/',
    'cookie_secure' => '0',
    'coppa_enable' => '0',
    'coppa_fax' => '',
    'coppa_mail' => '',
    'database_gc' => '604800',
    'dbms_version' => '5.1.33-community',
    'default_dateformat' => 'Y-m-d  G:i',
    'default_style' => '1',
    'display_last_edited' => '1',
    'display_order' => '0',
    'edit_time' => '0',
    'email_check_mx' => '1',
    'email_enable' => '1',
    'email_function_name' => 'mail',
    'email_package_size' => '50',
    'enable_confirm' => '1',
    'enable_pm_icons' => '1',
    'enable_post_confirm' => '1',
    'enable_queue_trigger' => '0',
    'flood_interval' => '15',
    'force_server_vars' => '0',
    'form_token_lifetime' => '7200',
    'form_token_mintime' => '0',
    'form_token_sid_guests' => '1',
    'forward_pm' => '1',
    'forwarded_for_check' => '0',
    'full_folder_action' => '2',
    'fulltext_mysql_max_word_len' => '254',
    'fulltext_mysql_min_word_len' => '4',
    'fulltext_native_common_thres' => '5',
    'fulltext_native_load_upd' => '1',
    'fulltext_native_max_chars' => '14',
    'fulltext_native_min_chars' => '3',
    'gzip_compress' => '0',
    'hot_threshold' => '25',
    'icons_path' => 'images/icons',
    'img_create_thumbnail' => '0',
    'img_display_inlined' => '1',
    'img_imagick' => '',
    'img_link_height' => '0',
    'img_link_width' => '0',
    'img_max_height' => '0',
    'img_max_thumb_width' => '400',
    'img_max_width' => '0',
    'img_min_thumb_filesize' => '12000',
    'ip_check' => '3',
    'jab_enable' => '0',
    'jab_host' => '',
    'jab_password' => '',
    'jab_package_size' => '20',
    'jab_port' => '5222',
    'jab_use_ssl' => '0',
    'jab_username' => '',
    'ldap_base_dn' => '',
    'ldap_email' => '',
    'ldap_password' => '',
    'ldap_port' => '',
    'ldap_server' => '',
    'ldap_uid' => '',
    'ldap_user' => '',
    'ldap_user_filter' => '',
    'limit_load' => '0',
    'limit_search_load' => '0',
    'load_anon_lastread' => '0',
    'load_birthdays' => '1',
    'load_cpf_memberlist' => '0',
    'load_cpf_viewprofile' => '1',
    'load_cpf_viewtopic' => '0',
    'load_db_lastread' => '1',
    'load_db_track' => '1',
    'load_jumpbox' => '1',
    'load_moderators' => '1',
    'load_online' => '1',
    'load_online_guests' => '1',
    'load_online_time' => '5',
    'load_onlinetrack' => '1',
    'load_search' => '1',
    'load_tplcompile' => '0',
    'load_user_activity' => '1',
    'max_attachments' => '3',
    'max_attachments_pm' => '1',
    'max_autologin_time' => '0',
    'max_filesize' => '262144',
    'max_filesize_pm' => '262144',
    'max_login_attempts' => '3',
    'max_name_chars' => '20',
    'max_num_search_keywords' => '10',
    'max_pass_chars' => '30',
    'max_poll_options' => '10',
    'max_post_chars' => '60000',
    'max_post_font_size' => '200',
    'max_post_img_height' => '0',
    'max_post_img_width' => '0',
    'max_post_smilies' => '0',
    'max_post_urls' => '0',
    'max_quote_depth' => '3',
    'max_reg_attempts' => '5',
    'max_sig_chars' => '255',
    'max_sig_font_size' => '200',
    'max_sig_img_height' => '0',
    'max_sig_img_width' => '0',
    'max_sig_smilies' => '0',
    'max_sig_urls' => '5',
    'min_name_chars' => '3',
    'min_pass_chars' => '6',
    'min_search_author_chars' => '3',
    'mime_triggers' => 'body|head|html|img|plaintext|a href|pre|script|table|title',
    'override_user_style' => '0',
    'pass_complex' => 'PASS_TYPE_ANY',
    'pm_edit_time' => '0',
    'pm_max_boxes' => '4',
    'pm_max_msgs' => '50',
    'pm_max_recipients' => '0',
    'posts_per_page' => '10',
    'print_pm' => '1',
    'queue_interval' => '600',
    'queue_trigger_posts' => '3',
    'ranks_path' => 'images/ranks',
    'require_activation' => '0',
    'referer_validation' => '1',
    'script_path' => '/xiaodoudian.com/forum',
    'search_block_size' => '250',
    'search_gc' => '7200',
    'search_interval' => '0',
    'search_anonymous_interval' => '0',
    'search_type' => 'fulltext_native',
    'search_store_results' => '1800',
    'secure_allow_deny' => '1',
    'secure_allow_empty_referer' => '1',
    'secure_downloads' => '0',
    'server_name' => 'localhost',
    'server_port' => '80',
    'server_protocol' => 'http://',
    'session_gc' => '3600',
    'session_length' => '3600',
    'site_desc' => '用于描述您的论坛的一小段文字',
    'sitename' => 'phpBB论坛',
    'smilies_path' => 'images/smilies',
    'smtp_auth_method' => 'PLAIN',
    'smtp_delivery' => '0',
    'smtp_host' => '',
    'smtp_password' => '',
    'smtp_port' => '25',
    'smtp_username' => '',
    'topics_per_page' => '25',
    'tpl_allow_php' => '0',
    'upload_icons_path' => 'images/upload_icons',
    'upload_path' => 'files',
    'version' => '3.0.5',
    'warnings_expire_days' => '90',
    'warnings_gc' => '14400',
    'board_startdate' => '1250091057',
    'default_lang' => 'zh_cmn_hans',
  ),
);

$this->var_expires = array (
  'mysqli_version' => 1281627064,
  'config' => 1281627064,
)
?>