CREATE TABLE IF NOT EXISTS `xls_user_data` (
  `config_id` varchar(36) NOT NULL,
  `user_id` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fields_list` text NOT NULL,
  `module` varchar(50) NOT NULL,
  `all_visible` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `xls_user_data` ADD PRIMARY KEY(`config_id`);"
