<?php

namespace cri2net\email\Install;

use Exception;
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

            switch (PDO_DB::getParams('type')) {
                case 'pgsql':
                    PDO_DB::query("CREATE TYPE emails_status_enum AS ENUM ('new', 'sending', 'complete', 'cancel', 'fail');");
                    PDO_DB::query("CREATE TYPE emails_type_enum AS ENUM ('raw_text', 'raw_html', 'html_template');");
                    PDO_DB::query("CREATE SEQUENCE {$prefix}emails_seq;");

                    PDO_DB::query(
                        "CREATE TABLE {$prefix}emails (
                            id int NOT NULL DEFAULT NEXTVAL ('{$prefix}emails_seq'),
                            status emails_status_enum NOT NULL DEFAULT 'new',
                            to_email character varying(500) NOT NULL,
                            to_username character varying(500) NOT NULL,
                            created_at double precision NOT NULL,
                            updated_at double precision NOT NULL,
                            send_at double precision,
                            settings text,
                            \"type\" emails_type_enum NOT NULL DEFAULT 'html_template',
                            template character varying(100) NOT NULL,
                            min_sending_time double precision NOT NULL,
                            replace_data text,
                            raw_body text,
                            processing_data text,
                            processing_status character varying(50),
                            additional text,
                            PRIMARY KEY (id)
                        )
                        WITH (
                            OIDS = FALSE
                        );"
                    );

                    PDO_DB::query("ALTER SEQUENCE {$prefix}emails_seq RESTART WITH 1;");
                    PDO_DB::query("CREATE INDEX {$prefix}emails_status_index ON {$prefix}emails (status, min_sending_time);");
                    break;

                case 'mysql':
                default:
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
            }

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

            switch (PDO_DB::getParams('type')) {
                case 'pgsql':

                    PDO_DB::query("DROP TABLE IF EXISTS {$prefix}emails;");
                    PDO_DB::query("DROP TYPE IF EXISTS emails_status_enum;");
                    PDO_DB::query("DROP TYPE IF EXISTS emails_type_enum;");
                    PDO_DB::query("DROP SEQUENCE IF EXISTS {$prefix}emails_seq;");
                    break;
                    
                case 'mysql':
                default:
                    $pdo->query("DROP TABLE IF EXISTS {$prefix}emails");
            }

            $pdo->commit();

        } catch (Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}
