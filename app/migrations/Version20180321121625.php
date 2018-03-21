<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180321121625 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE `rememberme_token` (
            `series` char(88) UNIQUE PRIMARY KEY NOT NULL,
            `value` char(88) NOT NULL,
            `lastUsed` datetime NOT NULL,
            `class` varchar(100) NOT NULL,
            `username` varchar(200) NOT NULL
        );');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE `rememberme_token`');
    }
}
