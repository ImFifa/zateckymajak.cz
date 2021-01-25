<?php

namespace App\Grid;

use Nette;
use Nette\Database\Table\ActiveRow;
use Nette\Forms\Container;

class ServiceGrid extends BaseGrid
{

    protected function build(): void
    {
        $this->model = $this->repository->service;

        parent::build();

        $this->addColumn('name', 'Název');
        $this->addColumn('gallery_id', 'Galerie');
        $this->addColumn('public', 'Veřejný');
//		$this->setFilterFactory([$this, 'gridFilterFactory']);

        $this->addRowAction('edit', 'Upravit', static function () {});
        $this->addRowAction('delete', 'Smazat', static function (ActiveRow $record) {
            $record->delete();
        })
            ->setProtected(false)
            ->setConfirmation('Opravdu chcete smazat aktivitu/službu?');
    }

//	public function gridFilterFactory(Container $c): void
//	{
//		$c->addText('title');
//		$c->addSelect('category_id')
//			->setPrompt('---')
//			->setItems($this->categoryModel->getForSelect());
//		$c->addSelect('public')
//			->setPrompt('---')
//			->setItems([0 => 'Ne', 1 => 'Ano']);
//	}

//	public function processFilters(Nette\Database\Table\Selection $data, array $filters): void
//	{
//		foreach ($filters as $column => $value) {
//			if ($column === 'category_id') {
//				$data->where($column, $value);
//			}
//		}
//
//		unset($filters['category_id']);
//		parent::processFilters($data, $filters);
//	}

}
