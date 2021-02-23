<?php

namespace App\Model;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class ArticleModel extends BaseModel
{

	protected $table = 'articles';

	public function getNew($slug, $lang): ?ActiveRow
	{
		return $this->getTable()->where('public', 1)->where('lang', $lang)->where('slug', $slug)->fetch();
	}

	public function getPublicNews(string $lang): Selection
	{
		return $this->getTable()->where('public', 1)->where('lang', $lang)->order('created DESC')->order('id DESC');
	}

}
