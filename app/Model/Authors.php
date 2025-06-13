<?php

namespace App\Model;

class Authors extends BaseModel {

    /** DB table name. */
    const TABLE_NAME = 'author';

    /** DB column ID of author. Auto incerement. */
    const COL_ID = 'id';
    
    /** DB column name of author. */
    const COL_PERSON_NAME = 'name';
    
    /** DB column age of author. */
    const COL_PERSON_AGE = 'age';
    
    protected static function getTableName(): string {
        return self::TABLE_NAME;
    }

    protected static function getPrimaryKey(): string {
        return self::COL_ID;
    }
    
    public function getNames(): array {
        return $this->database->table(self::TABLE_NAME)->select(self::COL_PERSON_NAME . ',' . self::COL_ID)->fetchPairs(self::COL_ID, self::COL_PERSON_NAME);
    }
}