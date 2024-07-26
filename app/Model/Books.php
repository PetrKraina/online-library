<?php

namespace App\Model;

class Books {

	/** DB table name. */
	const TABLE_NAME = 'books';

	/** DB column ID of book. Auto incerement. */
	const COL_ID = 'id';

	/** DB column ID of book from import file.*/
	const COL_CATALOG_ID = 'catalog_id';

	/** DB column name of author. */
	const COL_AUTHOR = 'author';

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

	/** @var \Nette\Database\Explorer */
	private $database;

	public function __construct(\Nette\Database\Explorer $database) {
		$this->database = $database;
	}

	/**
	 * Gets books based on custom conditions.
	 * @param array<string, mixed> $conditions E.g. ['author %LIKE%' => 'Ralls', 'genre' => 'Fantasy']
	 * @param string $orderBy
	 * @param string $order
	 * @param int<0, max>|null $limit
	 * @param int<0, max>|null $offset
	 * @return array<int, \Nette\Database\Row>
	 */
	public function get(array $conditions, string $orderBy = self::COL_ID, string $order = 'ASC', int $limit = null, int $offset = null): array {

		$tb = $this->database->table(self::TABLE_NAME);

		foreach ($conditions as $column => $value) {
			$tb->where($column, $value);
		}

		$tb->order($orderBy . ' ' . $order);

		if ($limit) {
			$tb->limit($limit, $offset);
		}

		return $tb->fetchPairs(self::COL_ID);
	}

	/**
     * Returns books by page.
     * @param int<1, max> $page Page number.
     * @param int<1, max> $itemsPerPage Number of items per page.
	 * @param string $orderBy
	 * @param string $order
     * @return array<int, \Nette\Database\Row>
     */
    public function getByPage(int $page = 1, int $itemsPerPage = 10, string $orderBy = self::COL_ID, string $order = 'DESC'): array {

        return $this->database->table(self::TABLE_NAME)->page($page, $itemsPerPage)->order($orderBy . ' ' . $order)->fetchPairs(self::COL_ID);
    }

	/**
	 * Get count of books.
	 * @return int
	 */
	public function count(): int {
		return $this->database->table(self::TABLE_NAME)->count('*');
	}

	/**
	 * Creates book rows in database.
	 * @param array<array<string, mixed>> $books List of books to create.
	 * E.g.: [[Books::COL_TITLE => Book Name, Books::COL_PRICE => 5.35, ...], [...]]
	 * @return void
	 */
	public function create(array $books): void {

		$this->database->table(self::TABLE_NAME)->insert($books);
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

	/**
     * Updates a book row in database.
     * @param int $id ID of the book to update.
     * @param array<string, mixed> $data Data to update. E.g. [self::COL_PRICE => 5.95]
     * @return void
     */
    public function update(int $id, array $data): void {
        $this->database->table(self::TABLE_NAME)->where(self::COL_ID, $id)->update($data);
    }

	/**
     * Deletes a book row in database.
     * @param int $id ID of the book to delete.
     * @return void
     */
    public function delete(int $id): void {
        $this->database->table(self::TABLE_NAME)->where(self::COL_ID, $id)->delete();
    }

}
