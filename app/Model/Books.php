<?php

namespace App\Model;

class Books extends BaseModel {

    /** DB table name. */
    const TABLE_NAME = 'book';

    /** DB column ID of book. Auto increment. */
    const COL_ID = 'id';

    /** DB column ID of book from import file. */
    const COL_CATALOG_ID = 'catalog_id';

    /** DB column name of author. */
    const COL_AUTHOR_ID = 'author_id';

    /** DB column name of book. */
    const COL_TITLE = 'title';

    /** DB column genre. */
    const COL_GENRE = 'genre';

    /** DB column price of book. */
    const COL_PRICE = 'price';

    /** DB column published date. */
    const COL_PUBLISH_DATE = 'publish_date';

    /** DB column descriptions of book. */
    const COL_DESCRIPTION = 'description';

    protected static function getTableName(): string {
        return self::TABLE_NAME;
    }

    protected static function getPrimaryKey(): string {
        return self::COL_ID;
    }

    /**
     * Creates book or updates it if exists.
     * @param array<array<string, mixed>> $books List of books to create.
     * E.g.: [[Books::COL_TITLE => Book Name, Books::COL_PRICE => 5.35, ...], [...]]
     * @return int Number of updated books.
     */
    public function put(array $books): int {

        $updated = 0;

        foreach ($books as $book) {

            // This logic was part of description of this work, although it could create a duplicates over time.
            if (isset($book[Books::COL_CATALOG_ID]) === false) {
                $this->create([$book]);
                continue;
            }

            $catalogId = $book[Books::COL_CATALOG_ID];

            $existingBook = $this->database->table(self::TABLE_NAME)
                    ->where(Books::COL_CATALOG_ID, $catalogId)
                    ->fetch();

            if ($existingBook === null) {
                $this->create([$book]);
                continue;
            }

            $this->database->table(self::TABLE_NAME)
                    ->where(Books::COL_CATALOG_ID, $catalogId)
                    ->update($book);

            $updated++;
        }

        return $updated;
    }
}
