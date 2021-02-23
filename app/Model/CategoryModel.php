<?php

namespace App\Model;

use Nette\Database\Table\ActiveRow;

class CategoryModel extends BaseModel
{

	protected $table = 'categories';

	/**
	 * @param $category
	 * @return ActiveRow[]
	 */
	public function getNewsByCategory($category): array
	{
		return $this->getItemBy($category, 'name')->related('articles.category_id')->fetchAll();
	}

}
