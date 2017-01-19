<?php

return [
    # Ориентируемся на следующий формат лога:
    # LogFormat "%h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\"" combined
    'log_parse_reg' => '/\s*'
        . '(?P<host>\S+)\s+'
        . '(?P<identity>\S+)\s+'
        . '(?P<user>\S+)\s+'
        . '\[(?P<date>.+?)\]\s+'
        . '"(?P<method>.+?)\s+(?P<url>.+?)\s+(?P<protocol>.+?)"\s+'
        . '(?P<code>\d+)\s+'
        . '(?P<bytes>\d+)\s+'
        . '"(?P<referer>.+?)"\s+'
        . '"(?P<agent>.+?)"'
        . '\s*\r?/',

    # путь к логу
    'log_file' => __DIR__ . '/../../logs/access.log',
];