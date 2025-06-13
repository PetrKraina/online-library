<?php

declare(strict_types=1);

namespace App\UI\Home;

use Nette;
use App\Model\Books;
use App\Model\Authors;

final class HomePresenter extends \App\UI\Base\BasePresenter {

    /** @var int<1, max> $itemsPerPage */
    public int $itemsPerPage = 10;

    /** @var Books */
    private $books;

    /** @var Authors */
    private $authors;

    public function __construct(Books $books, Authors $authors) {
        $this->books = $books;
        $this->authors = $authors;
    }

    public function handleDeleteBook(int $id): void {
        $this->books->delete($id);
    }

    public function renderDefault(int $page = 1): void {

        $page = max(1, $page);

        $this->template->books = $this->books->getByPage($page, $this->itemsPerPage);
        $booksCount = $this->books->count();

        $paginator = new Nette\Utils\Paginator;
        $paginator->setItemCount($booksCount);
        $paginator->setItemsPerPage($this->itemsPerPage);
        $paginator->setPage($page);
        $this->template->paginator = $paginator;
    }

    public function renderEdit(int $id): void {
        $this->template->bookId = $id;
    }
}
