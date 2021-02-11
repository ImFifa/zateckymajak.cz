<?php

namespace App\Service;

use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

/**
 * @property-read \App\Model\NewModel $new
 * @property-read \App\Model\CategoryModel $category
 * @property-read \App\Model\GalleryModel $gallery
 * @property-read \App\Model\ImageModel $image
 * @property-read \App\Model\FileModel $file
 * * @property-read \App\Model\FolderModel $folder
 */
class ProjectModelRepository extends ModelRepository
{


	// FILE
	public function getFolder(int $folder_id): ActiveRow
	{
		return $this->folder->getTable('folder')->where('id', $folder_id)->fetch();
	}

	public function getFilesByFolderId(int $folder_id): array
	{
		return $this->file->getTable('file')->where('folder_id', $folder_id)->order('id DESC')->fetchAll();
	}

	// NEWS
	public function getNew($slug, $lang): ?ActiveRow
	{
		return $this->new->getTable()->where('public', 1)->where('lang', $lang)->where('slug', $slug)->fetch();
	}

	public function getPublicNews(string $lang): Selection
	{
		return $this->new->getTable()->where('public', 1)->where('lang', $lang)->order('created DESC')->order('id DESC');
	}

	public function getPublicNewsByCategoryCount(string $lang, int $category_id): int
	{
		return $this->new->getTable()
			->where('public', 1)
			->where('lang', $lang)
			->where('category_id', $category_id)
			->order('created DESC')
			->count();
	}

	public function getPublicNewsByCategory(string $lang, int $category_id, int $limit, int $offset): Selection
	{
		return $this->new->getTable()->where('public', 1)->where('lang', $lang)->where('category_id', $category_id)->order('created DESC')->limit($limit, $offset);
	}

	// CATEGORY
	public function getCategories(): array
	{
		return $this->category->getTable()->fetchAll();
	}

	public function getCategoryById($id): ActiveRow
	{
		return $this->category->getTable()->where('id', $id)->fetch();
	}

	public function getCategoryBySlug($slug): ActiveRow
	{
		return $this->category->getTable()->where('slug', $slug)->fetch();
	}

}
