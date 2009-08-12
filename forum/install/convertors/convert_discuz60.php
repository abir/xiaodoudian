<?php
/** 
*
* @package install
* @version $Id: convert_phpbb20.php,v 1.43 2007/07/28 15:06:16 acydburn Exp $
* @copyright (c) 2006 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* NOTE to potential convertor authors. Please use this file to get
* familiar with the structure since we added some bare explanations here.
*
* Since this file gets included more than once on one page you are not able to add functions to it.
* Instead use a functions_ file.
*
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

include($phpbb_root_path . 'config.' . $phpEx);
unset($dbpasswd);

/**
* $convertor_data provides some basic information about this convertor which is
* used on the initial list of convertors and to populate the default settings
*
* $convertor_data �ṩ�����ת�������һЩ������Ϣ, ����ת�����б��ʼ���ͳ�ʼֵ����
*/
$convertor_data = array(
	'forum_name'	=> 'Discuz! 6.0.x',
	'version'		=> '1.0.RC2',
	'phpbb_version'	=> '3.0.2',
	'author'		=> '<a href="http://www.phpbbchina.com/">phpBB China Group</a>',
	'dbms'			=> $dbms,
	'dbhost'		=> $dbhost,
	'dbport'		=> $dbport,
	'dbuser'		=> $dbuser,
	'dbpasswd'		=> '',
	'dbname'		=> $dbname,
	'table_prefix'	=> 'cdb_',
	'forum_path'	=> '../forum',
	'author_notes'	=> '',
);

/**
* $tables is a list of the tables (minus prefix) which we expect to find in the
* source forum. It is used to guess the prefix if the specified prefix is incorrect
*
* $tables ������Ԥ����Դ��̳���ݿ������ҵ��ı������б�(����ǰ׺). ͬʱҲ������ָ����ǰ׺����ȷʱ��ת�������ܹ��Զ����
*/
$tables = array(
	'access',
	'activities',
	'activityapplies',
	'adminactions',
	'attachments',
	'forums',
	'members',
	'posts', 
	'projects', 
	'settings', 
	'polls',
	'ranks',
	'smilies',
	'threads',
	'pms',
	'usergroups',
	'plugins',
	'videos',
	'moderators',
	'favorites',
	'words' 
);

/**
* $config_schema details how the board configuration information is stored in the source forum.
*
* 'table_format' can take the value 'file' to indicate a config file. In this case array_name
* is set to indicate the name of the array the config values are stored in
* 'table_format' can be an array if the values are stored in a table which is an assosciative array
* (as per phpBB 2.0.x)
* If left empty, values are assumed to be stored in a table where each config setting is
* a column (as per phpBB 1.x)
*
* In either of the latter cases 'table_name' indicates the name of the table in the database
*
* 'settings' is an array which maps the name of the config directive in the source forum
* to the config directive in phpBB3. It can either be a direct mapping or use a function.
* Please note that the contents of the old config value are passed to the function, therefore
* an in-built function requiring the variable passed by reference is not able to be used. Since
* empty() is such a function we created the function is_empty() to be used instead.
*
* $config_schema ��ϸ˵��Դ��̳�е���̳������Ϣ
* 'table_format' ����ʹ��'file'��˵��������Դ���ļ����������ݿ�. �������������ı�������ʾ���ô洢������,
* ������ô洢��ʽ��phpbb2һ���Լ�¼����ʽ���ڱ���, 'table_format'��������һ������, ������յĻ�, ����
* ����Ϊ�����Ա������ʽ�洢.
* ���ڷ��ļ���ʽ�洢������, 'table_name'����ʾ���ݿ��еı���
* 'settings'��һ������, ���ڽ�Դ��̳������ӳ�䵽phpBB3. ������ֱ��ӳ��, Ҳ����ʹ�ú�������󴫵�.
* ��ע��ɵ�����ֵ�ᴫ�ݸ�����, ���PHP�ڽ��ĺ����޷�ʹ��ͨ�����ô��ݵĲ���. ����empty(), ������д��һ��
* is_empty()���������ʹ��
*/
$config_schema = array(
	'table_name'	=>	'settings',
	'table_format'	=>	array('variable' => 'value'),
	'settings'		=>	array(
		//'allow_bbcode'			=> '1',
		//'allow_smilies'			=> '1',
		//'allow_sig'				=> '1',
		//'allow_namechange'		=> '0',
		'allow_avatar_local'	=> '1',
		'allow_avatar_remote'	=> '1',
		'allow_avatar_upload'	=> '1',
		'board_disable'			=> '0',
		'sitename'				=> 'dz_set_encoding(bbname)',
		//'site_desc'				=> '',
		'session_length'		=> 'passport_expire',
		'board_email_sig'		=> 'dz_set_encoding(bbname)',
		'posts_per_page'		=> 'postperpage',
		'topics_per_page'		=> 'topicperpage',
		'enable_confirm'		=> '1',
		//'board_email_form'		=> '0',
		//'override_user_style'	=> '0',
		'hot_threshold'			=> 'hottopic',
		'max_poll_options'		=> 'maxpolloptions',
		'max_sig_chars'			=> '255',
		'pm_max_msgs'			=> '500',
		//'smtp_delivery'			=> '0',
		//'smtp_host'				=> '',
		//'smtp_username'			=> '',
		//'smtp_password'			=> '',
		//'require_activation'	=> '0',
		'flood_interval'		=> 'floodctrl',
		'avatar_filesize'		=> 'maxavatarsize',
		'avatar_max_width'		=> 'maxavatarpixel',
		'avatar_max_height'		=> 'maxavatarpixel',
		//'default_dateformat'	=> 'Y-m-j H:i',
		'board_timezone'		=> 'timeoffset',
		//'allow_privmsg'			=> '1',
		'gzip_compress'			=> 'gzipcompress',
		//'coppa_enable'			=> '0',
		//'coppa_fax'				=> '',
		//'coppa_mail'			=> '',
		'record_online_users'	=> 'dz_online_count(onlinerecord)', // ��dz���ݿ���ȡ������������¼
		'record_online_date'	=> 'dz_online_date(onlinerecord)', // ��dz���ݿ���ȡ������������¼������ʱ��, ��Ϊdz��������¼����һ���ַ�����, ������Ҫ�ú����ֿ�
		'board_startdate'		=> '0', 
	)
);

/**
* $test_file is the name of a file which is present on the source
* forum which can be used to check that the path specified by the 
* user was correct
* $test_file��Դ��̳��һ�����ڵ�һ���ļ�, �������ָ����·���Ƿ���ȷ
*/
$test_file = 'modcp.php';

/**
* If this is set then we are not generating the first page of information but getting the conversion information.
* ����������������, ���ǾͲ���������ҳ��Ϣ���ǻ�ȡת����Ϣ
*/
if (!$get_info)
{
	define('MOD_BIRTHDAY', true);

	// Test to see if the attachment MOD is installed on the source forum
	// If it is, we will convert this data as well
	//���attachment MOD�Ƿ��а�װ��Դ��̳��, �����, ���ǽ�ת���ⲿ�ֵ�����
	$src_db->sql_return_on_error(true);

	$sql = "SELECT config_value
		FROM {$convert->src_table_prefix}settings
		WHERE config_name = 'attachdir'";
	$result = $src_db->sql_query($sql);

	if ($result && $row = $src_db->sql_fetchrow($result))
	{
		// Here the constant is defined
		define('MOD_ATTACHMENT', true);

		$src_db->sql_freeresult($result);
	}
	else if ($result)
	{
		$src_db->sql_freeresult($result);
	}

	/**
	* Tests for further MODs can be included here.
	* Please use constants for this, prefixing them with MOD_
	*����Ƿ��������Ŀ���ת����MOD, ��ʹ�ó���, ��MOD_Ϊǰ׺
	*
	*/

	$src_db->sql_return_on_error(false);

	// Now let us set a temporary config variable for user id incrementing
	// �������趨һ����ʱ�ı����������û�ID����
	$sql = "SELECT uid as user_id
		FROM {$convert->src_table_prefix}members
		WHERE uid = 1";
	$result = $src_db->sql_query($sql);
	$user_id = (int) $src_db->sql_fetchfield('user_id');
	$src_db->sql_freeresult($result);

	// If there is a user id 1, we need to increment user ids. :/
	// ���idΪ1���û�����, ������Ҫ�ƶ�����û���id
	if ($user_id === 1)
	{
		// Try to get the maximum user id possible...
		// ���Ի�ȡ�û������id
		$sql = "SELECT MAX(uid) AS max_user_id
			FROM {$convert->src_table_prefix}members";
		$result = $src_db->sql_query($sql);
		$user_id = (int) $src_db->sql_fetchfield('max_user_id');
		$src_db->sql_freeresult($result);

		set_config('increment_user_id', ($user_id + 1), true);
	}
	else
	{
		set_config('increment_user_id', 0, true);
	}

	// Overwrite maximum avatar width/height
	// ����ͷ�����󳤺Ϳ�
	@define('DEFAULT_AVATAR_X_CUSTOM', get_config_value('avatar_max_width'));
	@define('DEFAULT_AVATAR_Y_CUSTOM', get_config_value('avatar_max_height'));

/**
*	Description on how to use the convertor framework.
*	ת����ܵ�ʹ������
*
*	'schema' Syntax Description
*	'schema' ��ʽ������
*
*		-> 'target'			=> Ŀ���. ���û��ָ��, ��ʹ���б��е���һ����Target Table. If not specified the next table will be handled
*		-> 'primary'		=> ����. ���ָ��������, ����������������������� Primary Key. If this is specified then this table is processed in batches
*		-> 'query_first'	=> array('target' or 'src', ��Ҫ�ڴ���ǰִ�еĲ�ѯQuery to execute before beginning the process
*								(�������һ����ʹ������if more than one then specified as array))
*		-> 'function_first'	=> �ڴ���ǰҪִ�еĺ���, �������һ����ʹ������ָ�� Function to execute before beginning the process (if more than one then specified as array)
*								(����ת������ǰ��Ҫָ�������������ʹ�� This is mostly useful if variables need to be given to the converting process)
*		-> 'test_file'		=> ��ǰû��ʹ��, ����Ӧ��ָ��һ��Դ��̳���ļ�This is not used at the moment but should be filled with a file from the old installation
*
*		// DB Functions ���ݿ⺯��
*		'distinct'	=> ���DISTINCT��select��ѯ Add DISTINCT to the select query
*		'where'		=> ���WHERE��select��ѯ Add WHERE to the select query
*		'group_by'	=> ���GROUP BY��select��ѯ Add GROUP BY to the select query
*		'left_join'	=> ���LEFT JOIN��select��ѯ(�����Ҫ�����join����ʹ������) Add LEFT JOIN to the select query (if more than one joins specified as array)
*		'having'	=> ���HAVING��select��ѯ Add HAVING to the select query
*
*		// DB INSERT array ���ݿ�INSERT����
*		This one consist of three parameters �������������
*		First Parameter ��һ������: 
*							Ŀ�������Ҫ���ļ� The key need to be filled within the target table
*							���Ϊ��, ��Ŀ����ᱻָ��ֵ If this is empty, the target table gets not assigned the source value
*		Second Parameter �ڶ�������:
*							Դֵ. ����趨�˵�һ������, ������ָ��Ϊ���ֵ, Source value. If the first parameter is specified, it will be assigned this value.
*							�����һ������Ϊ��, ��ô��ֻ�ᱻд��select��ѯ If the first parameter is empty, this only gets added to the select query
*		Third Parameter ����������:
*							�Զ���ĺ���. ���ڴ���Դֵ�󱣴浽Ŀ����� Custom Function. Function to execute while storing source value into target table. 
*							����return��ֵ�����洢 The functions return value get stored.
*							�����Ĳ��������ڶ���������ֵ��ֵ The function parameter consist of the value of the second parameter.
*
*							���� types:
*								- empty string == execute nothing ���ַ��� == ʲô����ִ��
*								- string == function to execute �ַ��� == ִ�еĺ�����
*								- array == complex execution instructions ���� == ���ӵ�ִ��ָ��
*		
*		Complex execution instructions:
*		���ӵ�ִ��ָ��
*		@todo test complex execution instructions - in theory they will work fine
*		���Ը��ӵ�ִ��ָ�� - �������������кܺ�
*
*							By defining an array as the third parameter you are able to define some statements to be executed. The key
*							�趨����Ϊ����������, �����Զ���һЩ��Ҫִ�е����, �ؼ��Ƕ���ִ��ʲô, ����׷����ֵ
*							is defining what to execute, numbers can be appended...
*
*							'function' => execute functionִ�к���
*							'execute' => run code, whereby all occurrences of {VALUE} get replaced by the last returned value.
*										The result *must* be assigned/stored to {RESULT}.
*										���д���, ������е�{VALUE}���滻Ϊ��󷵻ص�ֵ, ������뱻ָ����{RESULT}
*							'typecast'	=> typecast value
*										����ת��ֵ
*
*							The returned variables will be made always available to the next function to continue to work with.
*							���صı�������Խ���ȥ���д���ĺ�������
*
*							example (variable inputted is an integer of 1)����(����ı���������1):
*
*							array(
*								'function1'		=> 'increment_by_one',		// returned variable is 2 ����ֵ2
*								'typecast'		=> 'string',				// typecast variable to be a string ת������Ϊ�ַ���
*								'execute'		=> '{RESULT} = {VALUE} . ' is good';', // returned variable is '2 is good' ����ֵΪ '2 is good'
*								'function2'		=> 'replace_good_with_bad',				// returned variable is '2 is bad' ����ֵΪ '2 is bad'
*							),
*
*/

	$convertor = array(
		'test_file'				=> 'viewthread.php',

		'avatar_path'			=> 'images/avatars/',
		'avatar_gallery_path'	=> 'images/avatars/',
		'avatar_custom_path'	=> 'customavatars/',
		'smilies_path'			=> 'images/smilies/',
		'upload_path'			=> 'attachments/',
		'thumbnails'			=> '',
		'ranks_path'			=> false, // phpBB 2.0.x had no config value for a ranks path

		// We empty some tables to have clean data available
		'query_first'			=> array(
			array('target', $convert->truncate_statement . SEARCH_RESULTS_TABLE),
			array('target', $convert->truncate_statement . SEARCH_WORDLIST_TABLE),
			array('target', $convert->truncate_statement . SEARCH_WORDMATCH_TABLE),
			array('target', $convert->truncate_statement . LOG_TABLE),
		),
		
		//	with this you are able to import all attachment files on the fly. For large boards this is not an option, therefore commented out by default.
		//	Instead every file gets copied while processing the corresponding attachment entry.
		//		if (defined("MOD_ATTACHMENT")) { import_attachment_files(); phpbb_copy_thumbnails(); }
		//	ʹ�������������ת��ʱ���븽���ļ�. ���ڴ����̳��˵�Ⲣ������, ����Ĭ��ע�͵�, ����һ����Ŀ���Ѿ�������Ϻ��ٽ��п���
		

		// phpBB2 allowed some similar usernames to coexist which would have the same
		// username_clean in phpBB3 which is not possible, so we'll give the admin a list
		// of user ids and usernames and let him deicde what he wants to do with them
		// phpBB2����һЩ���Ƶ��û���ͬʱ����, ��Щ�û�����phpbb3�н�������ͬ��username_clean
		// ���ǲ������. �������ǻ�����һ����ͻ���û����б�, ��ת���߾�����δ���
		//
		//
		'execute_first'	=> '
			dz_check_username_collisions(); //����û�����ͻ
			import_avatar_gallery(\'dz_avatars\');
			import_custom_avatar(\'dz_custom_avatars\');
			phpbb_insert_forums();
		',

		'execute_last'	=> array('
			add_bots();
		', '
			change_poll_option_id_type();
		', '
			update_folder_pm_count();
		', '
			update_unread_count();
		', '
			phpbb_convert_authentication(\'start\');
		', '
			phpbb_convert_authentication(\'first\');
		', '
			phpbb_convert_authentication(\'second\');
		', '
			phpbb_convert_authentication(\'third\');
		'),

		'schema' => array(

			array(
				'target'		=> ATTACHMENTS_TABLE,
				'primary'		=> 'attachments.aid',
				'query_first'	=> array('target', $convert->truncate_statement . ATTACHMENTS_TABLE),
				'autoincrement'	=> 'attach_id',

				array('attach_id',				'attachments.aid',				''),
				array('post_msg_id',			'attachments.pid',					''),
				array('topic_id',				'attachments.tid',						''),
				array('in_message',				0,										''),
				array('is_orphan',				0,										''),
				array('poster_id',				'attachments.uid AS poster_id',	'phpbb_user_id'),
				array('physical_filename',		'attachments.attachment',	'dz_import_attachment'),
				array('real_filename',			'attachments.filename',		'dz_set_encoding'),
				array('download_count',			'attachments.downloads',		''),
				array('attach_comment',			'attachments.description',				array('function1' => 'dz_set_encoding', 'function2' => 'utf8_htmlspecialchars')),
				array('extension',				'attachments.filename',			'dz_get_extension'), //��ȡ��չ��
				array('mimetype',				'attachments.filetype',			''),
				array('filesize',				'attachments.filesize',			''),
				array('filetime',				'attachments.dateline',			''),
				array('thumbnail',				'attachments.thumb',			''),

				'where'			=> ''
			),

			/*array(
				'target'		=> BANLIST_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . BANLIST_TABLE),

				array('ban_ip',					'banlist.ban_ip',					'decode_ban_ip'),
				array('ban_userid',				'banlist.ban_userid',				'phpbb_user_id'),
				array('ban_email',				'banlist.ban_email',				''),
				array('ban_reason',				'',									''),
				array('ban_give_reason',		'',									''),

				'where'			=> "banlist.ban_ip NOT LIKE '%.%'",
			),

			array(
				'target'		=> BANLIST_TABLE,

				array('ban_ip',					'banlist.ban_ip',	''),
				array('ban_userid',				0,					''),
				array('ban_email',				'',					''),
				array('ban_reason',				'',					''),
				array('ban_give_reason',		'',					''),

				'where'			=> "banlist.ban_ip LIKE '%.%'",
			),

			array(
				'target'		=> DISALLOW_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . DISALLOW_TABLE),

				array('disallow_username',		'disallow.disallow_username',				'phpbb_disallowed_username'),
			),*/

			array(
				'target'		=> RANKS_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . RANKS_TABLE),
				'autoincrement'	=> 'rank_id',

				array('rank_id',					'ranks.rankid',				''),
				array('rank_title',					'ranks.ranktitle',				array('function1' => 'phpbb_set_default_encoding', 'function2' => 'utf8_htmlspecialchars')),
				array('rank_min',					'ranks.postshigher',				array('typecast' => 'int', 'execute' => '{RESULT} = ({VALUE}[0] < 0) ? 0 : {VALUE}[0];')),
				array('rank_special',				'0',			''),
				array('rank_image',					'',				'import_rank'),
			),

			array(
				'target'		=> TOPICS_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . TOPICS_TABLE),
				'primary'		=> 'threads.tid',
				'autoincrement'	=> 'topic_id',

				array('topic_id',				'threads.tid',					''),
				array('forum_id',				'threads.fid',					''),
				array('icon_id',				0,									''),
				array('topic_poster',			'threads.authorid AS poster_id',	'phpbb_user_id'),
				array('topic_attachment',		'threads.attachment', ''),
				array('topic_title',			'threads.subject',				'dz_set_encoding'),
				array('topic_time',				'threads.dateline',				''),
				array('topic_views',			'threads.views',				''),
				array('topic_replies',			'threads.replies',				''),
				array('topic_replies_real',		'threads.replies',				''),
				array('topic_last_post_id',		'threads.tid',		'dz_get_last_pidbytid'), //ȡ��dz��������һƪ���ӵ�post id
				array('topic_status',			'threads.closed',				'nozerotoone'),
				array('topic_moved_id',			0,									''),
				array('topic_type',				'threads.displayorder',				'dz_convert_topic_type'), //��dz����������ת����phpbb3����������
				array('topic_first_post_id',	'threads.tid',		'dz_get_first_pidbytid'), //ȡ��dz����ĵ�һƪ���ӵ�post id

				array('poll_title',				'threads.subject',				array('function1' => 'null_to_str', 'function2' => 'dz_set_encoding', 'function3' => 'utf8_htmlspecialchars')),
				array('poll_start',				0,				'null_to_zero'),
				array('poll_length',			'polls.expiration',			'null_to_zero'),
				array('poll_max_options',		'polls.maxchoices',									'null_to_zero'),
				array('poll_vote_change',		0,									''),

				'left_join'		=> 'threads LEFT JOIN polls ON threads.tid = polls.tid',
				'where'			=> '',
			),

			array(
				'target'		=> SMILIES_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . SMILIES_TABLE),
				'autoincrement'	=> 'smiley_id',

				array('smiley_id',				'smilies.id',				''),
				array('code',					'smilies.code',						array('function1' => 'phpbb_smilie_html_decode', 'function2' => 'dz_set_encoding', 'function3' => 'utf8_htmlspecialchars')),
				array('emotion',				'',					'dz_set_encoding'),
				array('smiley_url',				'smilies.url',				'dz_import_smiley'), //�������ͼ��
				array('smiley_width',			'smilies.url',				'get_smiley_width'), // ͼ����
				array('smiley_height',			'smilies.url',				'get_smiley_height'), // ͼ��߶�
				array('smiley_order',			'smilies.displayorder',				''),
				array('display_on_posting',		1,				''),

				'where'			=> "smilies.type = 'smiley'",
				'order_by'		=> 'smilies.id ASC',
			),

			array(
				'target'		=> POLL_OPTIONS_TABLE,
				'primary'		=> 'polloptions.polloptionid',
				'query_first'	=> array('target', $convert->truncate_statement . POLL_OPTIONS_TABLE),

				array('poll_option_id',			'polloptions.polloptionid',		''),
				array('topic_id',				'polloptions.tid',				''),
				//array('',						'topics.topic_poster AS poster_id',	'phpbb_user_id'),
				array('poll_option_text',		'polloptions.polloption',	array('function1' => 'dz_set_encoding', 'function2' => 'utf8_htmlspecialchars')),
				array('poll_option_total',		'polloptions.votes',			''),

				'where'			=> '',
			),

			/*array(
				'target'		=> POLL_VOTES_TABLE,
				'query_first'	=> array('target', $convert->truncate_statement . POLL_VOTES_TABLE),

				array('poll_option_id',			'polloptions.polloptionid',									''),
				array('topic_id',				'polloptions.tid',				''),
				array('vote_user_id',			'polloptions.voterids',			'dz_user_id'),
				array('vote_user_ip',			'polloptions.voterids',			'decode_ip'),

				'where'			=> 'vote_voters.vote_id = vote_desc.vote_id',
			),*/

			array(
				'target'		=> WORDS_TABLE,
				'primary'		=> 'words.id',
				'query_first'	=> array('target', $convert->truncate_statement . WORDS_TABLE),
				'autoincrement'	=> 'word_id',

				array('word_id',				'words.id',					''),
				array('word',					'words.find',						'dz_set_encoding'),
				array('replacement',			'words.replacement',				'dz_set_encoding'),
			),

			array(
				'target'		=> POSTS_TABLE,
				'primary'		=> 'posts.pid',
				'autoincrement'	=> 'post_id',
				'query_first'	=> array('target', $convert->truncate_statement . POSTS_TABLE),
				'execute_first'	=> '
					$config["max_post_chars"] = -1;
					$config["max_quote_depth"] = 0;
				',

				array('post_id',				'posts.pid',					''),
				array('topic_id',				'posts.tid',					''),
				array('forum_id',				'posts.fid',					''),
				array('poster_id',				'posts.authorid AS poster_id',					'phpbb_user_id'),
				array('icon_id',				0,									''),
				array('poster_ip',				'posts.useip',					''),
				array('post_time',				'posts.dateline AS post_time',					''),
				array('enable_bbcode',			'posts.bbcodeoff',				'dz_negative'), //ȡ��
				//array('',						'posts.enable_html',				''),
				array('enable_smilies',			'posts.smileyoff',				'dz_negative'),
				array('enable_sig',				1,					''),//ȫ��ΪĬ������ edit by IOsetting
				array('enable_magic_url',			'posts.parseurloff',				'dz_negative'),
				array('post_username',			'posts.author',				'dz_set_encoding'),
				array('post_subject',			'posts.subject',			'dz_set_encoding'),
				array('post_attachment',		'posts.attachment', ''),
				array('post_edit_time',			'posts.dateline',				array('typecast' => 'int')),
				array('post_edit_count',			0,					''),
				array('post_edit_reason',		'',									''),
				array('post_edit_user',			'',									'phpbb_post_edit_user'),

				array('bbcode_uid',				'posts.dateline',					'make_uid'),
				array('post_text',				'posts.message',				'phpbb_prepare_message'),
				//array('',						'posts_text.bbcode_uid AS old_bbcode_uid',			''),
				array('bbcode_bitfield',		'',									'get_bbcode_bitfield'),
				array('post_checksum',			'',									''),

				// Commented out inline search indexing, this takes up a LOT of time. :D
				// @todo We either need to enable this or call the rebuild search functionality post convert
/*				array('',						'',									'search_indexing'),
				array('',						'posts_text.post_text AS message',	''),
				array('',						'posts_text.post_subject AS title',	''),*/

				'where'			=>	''
			),

			array(
				'target'		=> PRIVMSGS_TABLE,
				'primary'		=> 'pms.pmid',
				'autoincrement'	=> 'msg_id',
				'query_first'	=> array(
					array('target', $convert->truncate_statement . PRIVMSGS_TABLE),
					array('target', $convert->truncate_statement . PRIVMSGS_RULES_TABLE),
				),

				'execute_first'	=> '
					$config["max_post_chars"] = -1;
					$config["max_quote_depth"] = 0;
				',

				array('msg_id',					'pms.pmid',				''),
				array('root_level',				0,									''),
				array('author_id',				'pms.msgfromid AS poster_id',	'phpbb_user_id'),
				array('icon_id',				0,									''),
				array('author_ip',				'',				''),
				array('message_time',			'pms.dateline AS post_time',			''),
				array('enable_bbcode',			1,					''),
				//array('',						'pms.privmsgs_enable_html AS enable_html',	''),
				array('enable_smilies',			1,					''),
				array('enable_magic_url',			1,									''),
				array('enable_sig',				1,					''),
				array('message_subject',		'pms.subject',		'dz_set_encoding'), // Already specialchared in 2.0.x
				array('message_attachment',		0,					''),
				array('message_edit_reason',		'',									''),
				array('message_edit_user',		0,									''),
				array('message_edit_time',		0,									''),
				array('message_edit_count',		0,									''),

				array('bbcode_uid',				'pms.dateline AS post_time',	'make_uid'),
				array('message_text',			'pms.message',			'phpbb_prepare_message'),
				//array('',						'privmsgs_text.privmsgs_bbcode_uid AS old_bbcode_uid',			''),
				array('bbcode_bitfield',		'',										'get_bbcode_bitfield'),
				array('to_address',				'pms.msgtoid',			'phpbb_privmsgs_to_userid'),
				array('bcc_address',			'',										''),

				'where'			=>	''
			),

			/*array(
				'target'		=> PRIVMSGS_FOLDER_TABLE,
				'primary'		=> 'users.user_id',
				'query_first'	=> array('target', $convert->truncate_statement . PRIVMSGS_FOLDER_TABLE),

				array('user_id',				'users.user_id',						'phpbb_user_id'),
				array('folder_name',			$user->lang['CONV_SAVED_MESSAGES'],		''),
				array('pm_count',				0,										''),
			
				'where'			=> 'users.user_id <> -1',
			),*/

			// Inbox
			array(
				'target'		=> PRIVMSGS_TO_TABLE,
				'primary'		=> 'pms.pmid',
				'query_first'	=> array('target', $convert->truncate_statement . PRIVMSGS_TO_TABLE),

				array('msg_id',					'pms.pmid',					''),
				array('user_id',					'pms.msgtoid',			'phpbb_user_id'),
				array('author_id',				'pms.msgfromid',		'phpbb_user_id'),
				array('pm_deleted',				'pms.delstatus',										''),
				array('pm_new',					'pms.new',				''), //�жϴ�pm�Ƿ����µ�(δ�Ķ�,����ʱ�����û��ϴε�¼��
				array('pm_unread',				'pms.new',				''), //�жϴ�pm�Ƿ�δ�Ķ�
				array('pm_replied',				0,										''),
				array('pm_marked',				0,										''),
				array('pm_forwarded',			0,										''),
				array('folder_id',				PRIVMSGS_INBOX,							''),

				'where'			=> "pms.folder = 'inbox'",
			),
			
			// Outbox
			array(
				'target'		=> PRIVMSGS_TO_TABLE,
				'primary'		=> 'pms.pmid',

				array('msg_id',					'pms.pmid',					''),
				array('user_id',				'pms.msgtoid',		'phpbb_user_id'),
				array('author_id',				'pms.msgfromid',		'phpbb_user_id'),
				array('pm_deleted',				0,										''),
				array('pm_new',					0,										''),
				array('pm_unread',				0,										''),
				array('pm_replied',				0,										''),
				array('pm_marked',				0,										''),
				array('pm_forwarded',			0,										''),
				array('folder_id',				PRIVMSGS_OUTBOX,						''),

				'where'			=> "pms.folder = 'outbox'",
			),

			array(
				'target'		=> GROUPS_TABLE,
				'autoincrement'	=> 'group_id',
				'query_first'	=> array('target', $convert->truncate_statement . GROUPS_TABLE),

				array('group_id',				'usergroups.groupid',					''),
				array('group_type',				'usergroups.type',				'dz_convert_group_type'), // ת��������
				array('group_display',			0,									''),
				array('group_legend',			0,									''),
				array('group_name',				'usergroups.grouptitle',				'phpbb_convert_group_name'), // dz_set_encoding called in phpbb_convert_group_name
				array('group_desc',				'',			''),

				'where'			=> '',
			),

			array(
				'target'		=> USER_GROUP_TABLE,

				array('group_id',		'members.groupid',				''),
				array('user_id',		'members.uid',				'phpbb_user_id'),
				array('group_leader',	0,							''),
				array('user_pending',	0,							''),

				'where'			=> '',
			),

			array(
				'target'		=> USERS_TABLE,
				'primary'		=> 'members.uid',
				'autoincrement'	=> 'user_id',
				'query_first'	=> array(
					array('target', 'DELETE FROM ' . USERS_TABLE . ' WHERE user_id <> ' . ANONYMOUS),
					array('target', $convert->truncate_statement . BOTS_TABLE)
				),

				'execute_last'	=> '
					remove_invalid_users();
				',

				array('user_id',					'members.uid',							'phpbb_user_id'),
				array('',						'members.uid AS poster_id',			'phpbb_user_id'),
				array('user_type',				'members.adminid',					'dz_set_user_type'), //ת���û�����, ����ֻ�й���Ա�ͷǹ��������?
				array('group_id',				'members.groupid',					''),
				array('user_regdate',			'members.regdate AS post_time',					''),
				array('username',				'members.username',					'phpbb_set_default_encoding'), // recode to utf8 with default lang
				array('username_clean',			'members.username',					array('function1' => 'phpbb_set_default_encoding', 'function2' => 'utf8_clean_string')),
				array('user_password',			'members.password',				''),
				array('user_pass_convert',		1,								''),
				array('user_posts',				'members.posts',					''),
				array('user_email',				'members.email',					'strtolower'),
				array('user_email_hash',			'members.email',					'gen_email_hash'),
				array('user_birthday',			'members.bday',	''), //ת������
				array('user_lastvisit',			'members.lastvisit',				''),
				array('user_lastmark',			'members.lastactivity',				''),
				array('user_lang',				$config['default_lang'],			''),
				//array('',						'users.user_lang',					''),
				array('user_timezone',			'0',				''),
				array('user_dateformat',			'Y-M-j H:i',							array('function1' => 'dz_set_encoding')),
				array('user_inactive_reason',		0,									''),
				array('user_inactive_time',		0,									''),

				array('user_interests',			'',									array('function1' => 'dz_set_encoding')),
				array('user_occ',				'',									array('function1' => 'dz_set_encoding')),
				array('user_website',			'memberfields.site',						'validate_website'),
				array('user_jabber',				'',									''),
				array('user_msnm',				'memberfields.msn',						array('function1' => 'dz_set_encoding')),
				array('user_yim',				'memberfields.yahoo',					array('function1' => 'dz_set_encoding')),
				array('user_aim',				'',									array('function1' => 'dz_set_encoding')),
				array('user_icq',				'memberfields.icq',						array('function1' => 'dz_set_encoding')),
				array('user_from',				'memberfields.location',					array('function1' => 'dz_set_encoding')),
				array('user_rank',				0,									''),
				array('user_permissions',			'',									''),

				array('user_avatar',				'memberfields.avatar',					'dz_import_avatar'), //����ͷ��
				array('user_avatar_type',		'memberfields.avatar',									'dz_avatar_type'),
				array('user_avatar_width',		'memberfields.avatarwidth',				''),
				array('user_avatar_height',		'memberfields.avatarheight',				''),

				array('user_new_privmsg',		0,									''),
				array('user_unread_privmsg',		0,									''), //'users.user_unread_privmsg'
				array('user_last_privmsg',		0,									''),
				array('user_emailtime',			0,				'null_to_zero'),
				array('user_notify',				0,				''),
				array('user_notify_pm',			1,				''),
				array('user_notify_type',			NOTIFY_EMAIL,						''),
				array('user_allow_pm',			1,				''),
				array('user_allow_viewonline',	1,		''),
				array('user_allow_viewemail',		1,				''),
				array('user_actkey',				'',				''),
				array('user_newpasswd',		'',									''), // Users need to re-request their password...
				array('user_style',				$config['default_style'],			''),

				array('user_options',			'',									'set_user_options'),

				array('user_sig_bbcode_uid',		'members.regdate',							'make_uid'),
				array('user_sig',					'memberfields.sightml',								'phpbb_prepare_message'),
				//array('',							'users.user_sig_bbcode_uid AS old_bbcode_uid',	''),
				array('user_sig_bbcode_bitfield',	'',												'get_bbcode_bitfield'),
				array('',							'members.regdate AS post_time',				''),

				'left_join'		=> 'members LEFT JOIN memberfields ON members.uid = memberfields.uid',
				'where'			=> 'members.uid <> -1',
			),
		),
	);
}

?>
