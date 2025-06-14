<?php

namespace App\UI\Controls;

use Nette\Application\UI\Control;
use Nette\Utils\ArrayHash;
use Nette\Application\UI\Form;
use App\Model\Books;
use App\Model\Authors;

class BookForm extends Control {

	/** @var Books */
	private $books;
    
    /** @var Authors */
    private $authors;

	/** @var int|null */
    private $bookId = null;
    

	public function __construct(Books $books, \App\Model\Authors $authors) {
		$this->books = $books;
        $this->authors = $authors;
	}

	public function render(int $bookId = null): void {
		$this->bookId = $bookId;
		$this->template->setFile(__DIR__ . '/templates/bookForm.latte');
		$this->template->render();
	}

	protected function createComponentBookForm(): Form {

		$form = new Form;

		$form->addText(Books::COL_CATALOG_ID, 'Katalogové ID');

        $authors = $this->authors->getNames();
        $form->addSelect(Books::COL_AUTHOR_ID, '*Author:', $authors)
                ->setPrompt('Vyberte autora')
                ->setRequired('Zadejte autora.');

		$form->addText(Books::COL_TITLE, '*Název knihy:')
				->setRequired('Zadejte název knihy..');

		$form->addText(Books::COL_GENRE, '*Žánr:')
				->setRequired('Zadejte žánr.');

		$form->addFloat(Books::COL_PRICE, '*Cena:')
				->setRequired('Zadejte cenu.')
				->addRule($form::FLOAT, 'Cena musí být číslo!');

		$form->addDate(Books::COL_PUBLISH_DATE, '*Datum vydání:')
				->setRequired('Zadejte datum vydání.')
				->setFormat('Y-m-d');

		$form->addTextArea(Books::COL_DESCRIPTION, '*Popis knihy')
				->addRule($form::MaxLength, 'Popis je příliš dlouhý', 65534);

		if ($this->bookId) {
            $book = $this->books->get([Books::COL_ID => $this->bookId]);
            if (count($book) > 0) {
                $form->setDefaults($book[$this->bookId]);
            }
        }

		$form->addSubmit('send', 'Uložit');
		$form->onSuccess[] = [$this, 'bookFormSucceeded'];

		return $form;
	}

	public function bookFormSucceeded(Form $form, ArrayHash $values): void {

		$books = [
			[
				Books::COL_CATALOG_ID => $values['catalog_id'],
				Books::COL_AUTHOR_ID => $values['author'],
				Books::COL_TITLE => $values['title'],
				Books::COL_GENRE => $values['genre'],
				Books::COL_PRICE => $values['price'],
				Books::COL_PUBLISH_DATE => $values['publish_date'],
				Books::COL_DESCRIPTION => $values['description'],
			]
		];

		$exists = $this->books->get([Books::COL_CATALOG_ID => $values['catalog_id']]);

		if (count($exists) > 0 && $values['catalog_id'] !== '') {
			$this->books->put($books);
			$this->presenter->flashMessage('Kniha byla aktualizována!', 'success');
		} else {
			$this->books->create($books);
			$this->presenter->flashMessage('Kniha ' . $values->title . ' přidána!', 'success');
		}

		$this->presenter->redirect('this');
	}

}
