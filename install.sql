
-- Не забываем добавлять к имени таблицы префикс своего проекта

-- v1.1.0.0
CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('new','complete','cancel','fail') NOT NULL DEFAULT 'new',
  `to_email` varchar(500) NOT NULL,
  `to_username` varchar(500) NOT NULL,
  `updated_at` double NOT NULL,
  `send_at` double DEFAULT NULL,
  `settings` text,
  `type` enum('raw_text','raw_html','html_template') NOT NULL DEFAULT 'html_template',
  `template` varchar(100) DEFAULT NULL,
  `created_at` double NOT NULL,
  `min_sending_time` double NOT NULL,
  `replace_data` text,
  `raw_body` text,
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`min_sending_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- v1.1.0.2
-- Add status "sending"
ALTER TABLE `emails`
  CHANGE `status` `status` ENUM('new','sending','complete','cancel','fail') CHARSET utf8 COLLATE utf8_general_ci DEFAULT 'new' NOT NULL;
