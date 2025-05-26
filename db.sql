CREATE TABLE IF NOT EXISTS `remember_member` (
    `mb_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) NOT NULL default '',
    `mb_password` varchar(255) default NULL,
    `mb_email` varchar(255) default NULL,
    `mb_updated_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `mb_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `mb_ip` varchar(25) default NULL,
    `mb_agent` varchar(255) default NULL,
    `mb_level` tinyint(1) NOT NULL default '0',
    `mb_blacklist_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `mb_open_mailling` char(3) NOT NULL default '1|1',
    `mb_facebook` tinyint(1) NOT NULL default '0',
    `mb_login_cnt` int(11) NOT NULL default '0',
    `mb_nick` varchar(255) default NULL,
    `mb_profile` varchar(255) default NULL,
    `mb_thumbnail` varchar(255) default NULL,
    `mb_twitter_user` varchar(50) default NULL,
    `mb_lost_certify` varchar(255) default NULL,
    PRIMARY KEY  (`mb_id`),
    UNIQUE KEY (`mb_user`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*CREATE TABLE IF NOT EXISTS `remember_member_fb` (
  `mf_id` int(11) NOT NULL auto_increment,
  `mf_user` varchar(255) default NULL,
  `mf_name` varchar(255) default NULL,
  `mf_first_name` varchar(255) default NULL,
  `mf_last_name` varchar(255) default NULL,
  `mf_link` varchar(255) default NULL,
  `mf_username` varchar(255) default NULL,
  `mf_bio` varchar(255) default NULL,
  `mf_education` varchar(255) default NULL,
  `mf_gender` varchar(255) default NULL,
  `mf_timezone` varchar(255) default NULL,
  `mf_locale` varchar(255) default NULL,
  `mf_verified` varchar(255) default NULL,
  `mf_updated_time` varchar(255) default NULL,
  PRIMARY KEY  (`mf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;*/


CREATE TABLE IF NOT EXISTS `remember_boardset` (
    `bs_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `bs_subject` varchar(255) default NULL,
    `bs_setting` varchar(25) NOT NULL default '0|0|0|0|0|0|0|0|0|0|0|0|0',
    `bs_rows` varchar(5) NOT NULL default '10|7',
    `bs_skin` varchar(255) NOT NULL default 'default|default',
    `bs_user_url` varchar(50) default NULL,
    `bs_hit` int(11) NOT NULL default '0',
    `bs_openapikey` varchar(255) default NULL,
    `bs_openapisecret` varchar(255) default NULL,
    `bs_openapi_hit` int(11) NOT NULL default '0',
    PRIMARY KEY  (`bs_id`),
    UNIQUE KEY (`mb_user`),
    UNIQUE KEY (`bs_user_url`),
    UNIQUE KEY (`bs_openapikey`),
    UNIQUE KEY (`bs_openapisecret`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*CREATE TABLE IF NOT EXISTS `remember_board_{mb_user}` (
  `bo_id` int(11) NOT NULL auto_increment,
  `bo_public` tinyint(1) NOT NULL default '0',
  `su_short_url` varchar(20) NOT NULL default '',
  `ct_category_code` char(4) default NULL,
  `bo_content` longtext,
  `bo_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `bo_hit` int(11) NOT NULL default '0',
  `bo_ip` varchar(25) default NULL,
  `bo_good` int(11) NOT NULL default '0',
  `bo_nogood` int(11) NOT NULL default '0',
  `bo_option` varchar(25) NOT NULL default '0|0|0|0|1|0|0|0|0|0|0|0|0',
  `bo_security_pass` varchar(255) default NULL,
  `bo_recycle_bin` tinyint(1) NOT NULL default '0',
  `bo_recycle_bin_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`bo_id`),
  UNIQUE KEY (`su_short_url`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;*/


CREATE TABLE IF NOT EXISTS `remember_short_url` (
    `su_id` int(11) NOT NULL auto_increment,
    `su_short_url` varchar(20) default NULL,
    `mb_user` varchar(50) default NULL,
    `bo_id` int(11) default NULL,
    `su_hit` int(11) NOT NULL default '0',
    `su_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `su_blacklist_date` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`su_id`),
    UNIQUE KEY (`su_short_url`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_myfriends` (
    `fr_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `fr_target_user` varchar(50) default NULL,
    `fr_date` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`fr_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_memo` (
    `mm_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `mm_send_user` varchar(50) default NULL,
    `mm_notice` tinyint(1) NOT NULL default '0',
    `mm_memo` varchar(255) default NULL,
    `mm_send_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `mm_read_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `mm_ip` varchar(25) default NULL,
    PRIMARY KEY  (`mm_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_spam` (
    `sp_id` int(11) NOT NULL auto_increment,
    `sp_url` varchar(20) default NULL,
    `sp_url_user` varchar(50) default NULL,
    `sp_from_user` varchar(50) default NULL,
    `sp_reason` int(1) default NULL,
    `sp_andsoon` varchar(255) default NULL,
    `sp_ip` varchar(25) default NULL,
    `sp_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `sp_feedback` varchar(255) default NULL,
    `sp_feedback_date` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`sp_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_point` (
    `po_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `po_point` int(11) NOT NULL default '0',
    `po_content` varchar(255) default NULL,
    `po_date` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`po_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_scrap` (
    `sc_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `sc_table_user` varchar(50) default NULL,
    `bo_id` int(11) default NULL,
    `su_short_url` varchar(20) default NULL,
    `sc_date` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`sc_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_login` (
    `lo_ip` varchar(25) default NULL,
    `mb_user` varchar(50) default NULL,
    `lo_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `lo_location` varchar(255) default NULL,
    `lo_url` varchar(255) default NULL,
    PRIMARY KEY  (`lo_ip`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_login_history` (
    `lh_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `lh_ip` varchar(25) default NULL,
    `lh_agent` varchar(255) default NULL,
    `lh_datetime_login` datetime NOT NULL default '0000-00-00 00:00:00',
    `lh_datetime_logout` datetime NOT NULL default '0000-00-00 00:00:00',
    PRIMARY KEY  (`lh_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_search` (
    `se_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `se_word` varchar(50) default NULL,
    `se_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `se_ip` varchar(25) default NULL,
    `se_agent` varchar(255) default NULL,
    PRIMARY KEY  (`se_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_visit` (
    `vi_id` int(11) NOT NULL auto_increment,
    `vi_ip` varchar(25) default NULL,
    `vi_date` date default NULL,
    `vi_time` time default NULL,
    `vi_referer` text,
    `vi_agent` varchar(255) default NULL,
    PRIMARY KEY  (`vi_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_visit_sum` (
    `vs_date` date NOT NULL default '0000-00-00',
    `vs_count` int(11) NOT NULL default '0',
    `vs_visit` varchar(255) default NULL,
    PRIMARY KEY  (`vs_date`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `remember_advertisement` (
    `ad_id` int(11) NOT NULL auto_increment,
    `ad_name` varchar(255) default NULL,
    `ad_url` varchar(255) default NULL,
    `ad_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `ad_hit` int(11) NOT NULL default '0',
    PRIMARY KEY  (`ad_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


/*CREATE TABLE IF NOT EXISTS `remember_twitter_post` (
  `tp_id` int(11) NOT NULL auto_increment,
  `mb_user` varchar(50) default NULL,
  `tp_oauth_token` varchar(255) default NULL,
  `tp_oauth_token_secret` varchar(255) default NULL,
  `tp_user_id` varchar(255) default NULL,
  `tp_screen_name` varchar(255) default NULL,
  `tp_date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`tp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;*/


CREATE TABLE IF NOT EXISTS `remember_notice_board` (
    `nb_id` int(11) NOT NULL auto_increment,
    `mb_user` varchar(50) default NULL,
    `nb_subject` varchar(255) default NULL,
    `nb_content` text,
    `nb_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `nb_updated_date` datetime NOT NULL default '0000-00-00 00:00:00',
    `nb_file_name` varchar(255) default NULL,
    `nb_file_size` varchar(255) default NULL,
    `nb_link_1` varchar(255) default NULL,
    `nb_link_2` varchar(255) default NULL,
    `nb_link_hit_1` int(11) NOT NULL default '0',
    `nb_link_hit_2` int(11) NOT NULL default '0',
    `nb_ip` varchar(25) default NULL,
    `nb_hit` int(11) NOT NULL default '0',
    `nb_setting` varchar(9) NOT NULL default '0|0|0|0|0',
    `nb_recycle_bin` tinyint(1) NOT NULL DEFAULT '0',
    `nb_recycle_bin_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY  (`nb_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `remember_tmp_email_auth` (
    `ta_id` varchar(50) NOT NULL default '',
    `mb_user` varchar(50) NOT NULL default '',
    `ta_email` varchar(255) default NULL,
    `ta_date` varchar(255) default NULL,
    `ta_auth_key` varchar(255) default NULL,
    PRIMARY KEY  (`ta_id`),
    UNIQUE KEY (`mb_user`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;


