<?php
use yii\db\Migration;

class m170119_013459_init extends Migration
{
    const CREATE_SQL = "
CREATE TABLE `apache_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `host` varchar(255) NOT NULL,
  `method` enum('GET','POST','DELETE','PUT','HEAD') NOT NULL,
  `url` varchar(255) NOT NULL,
  `referer` varchar(255) DEFAULT NULL,
  `code` int(10) unsigned NOT NULL,
  `identity` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `bytes` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `apache_log_lastpos` (
  `path` tinytext NOT NULL,
  `pos` int(10) unsigned NOT NULL,
  PRIMARY KEY (`path`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

    public function up()
    {
        \Yii::$app->db->createCommand(self::CREATE_SQL)->execute();
    }

    public function down()
    {
        echo "m170119_013459_init cannot be reverted.\n";

        return false;
    }
}
