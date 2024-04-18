<?php

namespace Rahpt\Commands\Classes;

/**
 * Description of Convert
 *
 * @author jose.proenca
 */
class Convert {

    static function DbTypeToPhpType($dbType): string {
        $intTypes = ['int', 'tinyint', 'smallint', 'mediumint', 'bigint'];
        $floatTypes = ['float', 'double', 'decimal'];
        $stringTypes = ['char', 'varchar', 'text', 'mediumtext', 'longtext', 'json'];
        $dateTypes = ['date', 'datetime', 'timestamp'];
        $stringOrBinaryTypes = ['binary', 'varbinary', 'blob', 'mediumblob', 'longblob'];

        if (in_array($dbType, $intTypes)) {
            return 'int';
        }
        if (in_array($dbType, $floatTypes)) {
            return 'float';
        }

        if (in_array($dbType, $stringTypes)) {
            return 'string';
        }

        if (in_array($dbType, $dateTypes)) {
            return '\DateTime';
        }

        if (in_array($dbType, $stringOrBinaryTypes)) {
            return 'string';
        }

        return 'mixed';
    }
}