<?php

namespace App\UI\Controls;

use Nette\Application\UI\Control;
use Nette\Utils\ArrayHash;
use Nette\Application\UI\Form;
use App\Model\Books;

class UploadBooksForm extends Control
{
	/** @var Books */
	private $books;

	public function __construct(Books $books,) {
		$this->books = $books;
	}

	public function render(): void {
		$this->template->setFile(__DIR__ . '/templates/uploadBooksForm.latte');
        $this->template->render();
	}

	public function uploadBooksFormSucceeded(Form $form, ArrayHash $values): void
	{
		try {
			/* Load XML with XXE protection. */
			$dom = new \DOMDocument();
			$dom->loadXML($values['import_file']->getContents(), LIBXML_NOCDATA | LIBXML_NONET);
			$dom->substituteEntities = false;
			$dom->resolveExternals = false;
			$booksXml = simplexml_import_dom($dom);

			if ($booksXml === null) {
				throw new \Exception("Načtení XML selhalo.");
			}

			$books = [];

			foreach ($booksXml->book as $bookXml) {
				$books[] = [
					Books::COL_AUTHOR => (string) $bookXml->author,
					Books::COL_CATALOG_ID => (string) $bookXml['id'],
					Books::COL_TITLE => (string) $bookXml->title,
					Books::COL_GENRE => (string) $bookXml->genre,
					Books::COL_PRICE => (string) $bookXml->price,
					Books::COL_PUBLISH_DATE => (string) $bookXml->publish_date,
					Books::COL_DESCRIPTION =>  (string) $bookXml->description
				];
			}

			$updatedNum = $this->books->put($books);

			$this->presenter->flashMessage('Knihy nahrány!', 'success');
			$this->presenter->flashMessage($updatedNum . ' již existujících knih bylo aktializováno.', 'success');

		} catch (\Exception $ex) {
			\Tracy\Debugger::log($ex, 'error');
			$this->presenter->flashMessage('Prolém při nahrávání knih.', 'error');
		}

		$this->presenter->redirect('Home:default');
	}

	protected function createComponentUploadBooksForm(): Form
	{
		$form = new Form;

		$form->addUpload('import_file', 'Nahrát soubor:')
				->setRequired(true)
				->addRule(Form::MIME_TYPE, 'Soubor musí být typ .xml', 'text/xml');

		$form->addSubmit('upload', 'Nahrát');
		$form->onSuccess[] = [$this, 'uploadBooksFormSucceeded'];

		return $form;
	}

}