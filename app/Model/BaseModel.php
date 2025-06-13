<?php

namespace App\Model;

abstract class BaseModel {

    /** @var \Nette\Database\Explorer */
    protected $database;

    public function __construct(\Nette\Database\Explorer $database) {
        $this->database = $database;
    }

    /**
     *  Returns name of DB table.
     *  Must be implemented in child class.
     */
    abstract protected static function getTableName(): string;

    /**
     *  Returns name of primary key.
     *  Must be implemented in child class.
     */
    abstract protected static function getPrimaryKey(): string;

    /**
     * @param array<string, mixed> $conditions
     * @param string $orderBy
     * @param string $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array<int, \Nette\Database\Row>
     */
    public function get(array $conditions, string $orderBy = '', string $order = 'ASC', int $limit = null, int $offset = null): array {

        $tb = $this->database->table(static::getTableName())->select('*');

        foreach ($conditions as $column => $value) {
            if (is_array($value)) {
                 \Tracy\Debugger::barDump($value);
                $tb->where("$column IN (?)", $value);
            } else {
                $tb->where($column, $value);
            }
        }

        if ($orderBy) {
            $tb->order($orderBy . ' ' . $order);
        }

        if ($limit !== null) {
            $tb->limit($limit, $offset ?? 0);
        }

        return $tb->fetchPairs(static::getPrimaryKey());
    }

    /**
     * @param int<1, max> $page Page number.
     * @param int<1, max> $itemsPerPage Number of items per page.
     * @param string $orderBy
     * @param string $order
     * @return array<int, \Nette\Database\Row>
     */
    public function getByPage(int $page = 1, int $itemsPerPage = 10, string $orderBy = '', string $order = 'DESC'): array {

        if ($orderBy === '') {
            $orderBy = static::getPrimaryKey();
        }

        return $this->database->table(static::getTableName())->order($orderBy . ' ' . $order)->page($page, $itemsPerPage)->fetchPairs(static::getPrimaryKey());
    }

    /**
     * Get count table rows.
     * @return int
     */
    public function count(array $conditions = []): int {

        $tb = $this->database->table(static::getTableName());

        foreach ($conditions as $column => $value) {
            $tb->where($column, $value);
        }

        return $tb->count('*');
    }

    /**
     * @param array<array<string, mixed>> $rows List of rows to create.
     * E.g.: [[Books::COL_TITLE => Book Name, Books::COL_PRICE => 5.35, ...], [...]]
     * @return void
     */
    public function create(array $rows): void {
        $this->database->table(static::getTableName())->insert($rows);
    }

    /**
     * Updates a book row in database.
     * @param int $id ID of row to update.
     * @param array<string, mixed> $data Data to update. E.g. [self::COL_PRICE => 5.95]
     * @return void
     */
    public function update(int $id, array $data): void {
        $this->database->table(static::getTableName())->where(static::getPrimaryKey(), $id)->update($data);
    }

    /**
     * @param int $id ID of row to delete.
     * @return void
     */
    public function delete(int $id): void {
        $this->database->table(static::getTableName())->where(static::getPrimaryKey(), $id)->delete();
    }
}
