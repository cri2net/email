<?php

namespace cri2net\email\Install;

use \Exception;
use cri2net\php_pdo_db\PDO_DB;
use Placebook\Framework\Core\Install\MigrationInterface;

class Migration_1_2 implements MigrationInterface
{
    public static function up()
    {
        $prefix = (defined('TABLE_PREFIX')) ? TABLE_PREFIX : '';
        $pdo = PDO_DB::getPDO();

        try {
            $pdo->beginTransaction();
            
            $pdo->query(
                "CREATE TABLE IF NOT EXISTS {$prefix}emails (
                    id int(11) NOT NULL AUTO_INCREMENT,
                    `status` enum('new','sending','complete','cancel','fail') NOT NULL DEFAULT 'new',
                    to_email varchar(500) NOT NULL,
                    to_username varchar(500) NOT NULL,
                    updated_at double NOT NULL,
                    send_at double DEFAULT NULL,
                    `settings` text,
                    `type` enum('raw_text','raw_html','html_template') NOT NULL DEFAULT 'html_template',
                    `template` varchar(100) DEFAULT NULL,
                    created_at double NOT NULL,
                    min_sending_time double NOT NULL,
                    replace_data text,
                    raw_body text,
                    PRIMARY KEY (id),
                    KEY `status` (`status`,min_sending_time)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
            );

            $pdo->commit();

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public static function down()
    {
        $prefix = (defined('TABLE_PREFIX')) ? TABLE_PREFIX : '';
        $pdo = PDO_DB::getPDO();

        try {

            $pdo->beginTransaction();
            $pdo->query("DROP TABLE IF EXISTS {$prefix}emails");
            $pdo->commit();

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
