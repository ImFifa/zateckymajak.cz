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

	public function getFolder(int $folder_id): ActiveRow
	{
		return $this->folder->getTable('folder')->where('id', $folder_id)->fetch();
	}

	public function getFilesByFolderId(int $folder_id): array
	{
		return $this->file->getTable('file')->where('folder_id', $folder_id)->order('id DESC')->fetchAll();
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


}
