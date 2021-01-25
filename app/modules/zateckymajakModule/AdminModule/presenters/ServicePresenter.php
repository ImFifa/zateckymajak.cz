<?php

namespace App\AdminModule\Presenters;

use App\Grid\ServiceGrid;
use App\Grid\IServiceGridFactory;
use DateTime;
use Nette\Application\UI\Form;
use App\Service\Helpers;
use Nette\Database\Table\ActiveRow;
use Nette\Http\FileUpload;
use Nette\Utils\Strings;

class ServicePresenter extends BaseScprorodinuPresenter
{

    /** @var IServiceGridFactory @inject */
    public $serviceGridFactory;

    public function renderEdit(?int $id): void
    {
        $service = $this->repository->service->get($id);


        /** @var Form $form */
        $form = $this['serviceForm'];
        $form->setDefaults($service);

        $this->template->service = $service;
    }

    protected function createComponentServiceGrid(): ServiceGrid
    {
        return $this->serviceGridFactory->create();
    }

    protected function createComponentServiceForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Název')
            ->addRule(Form::MAX_LENGTH, 'Maximálné délka je %s znaků', 150)
            ->setRequired('Musíte uvést jméno události');

        $form->addUpload('image', 'Nahrát náhledový obrázek aktivity/služby');

        $form->addCheckbox('public', 'Veřejný článek')
            ->setDefaultValue(true);

        $form->addSelect('gallery_id', 'Připojit galerii')
            ->setPrompt('Žádná')
            ->setItems($this->repository->gallery->getForSelect());

        $form->addTextArea('content', 'Popis', 100, 25)
            ->setHtmlAttribute('class', 'form-wysiwyg');

        $form->addSubmit('save', 'Uložit');

        $form->onSubmit[] = function (Form $form) {
            $values = $form->getValues(true);
            $values['slug'] = Strings::webalize($values['name']);


            /** @var FileUpload $file */
            $file = $values['image'];
            unset($values['image']);

            if ($values['id'] === '') {
                unset($values['id']);
                $values['id'] = $this->repository->service->insert($values)->id;
                $this->flashMessage('Aktivita/služba přidána', 'success');
            } else {
                $this->repository->service->get($values['id'])->update($values);
                $this->flashMessage('Aktivita/služba upravena', 'success');
            }

            $link = WWW . '/upload/services/' . $values['id'] . '/';

            if (Helpers::isValidImage($file)) {
                $name = 'image.' . Helpers::getFileType($file);

                if (!file_exists($link)) {
                    Helpers::mkdir($link);
                }
                $image = $file->toImage();

                if ($image->getHeight() > 1080 || $image->getWidth() > 1920) {
                    $image->resize(1920, 1080);
                }

                $image->save($link . $name);
                $this->repository->service->getTable()->where('id', $values['id'])->update(['cover' => $name]);

                $this->cropper('upload/services/' . $values['id'] . '/' . $name, $this->configuration->newAspectRatio, $this->link('this', ['id' => $values['id']]));
            }

            $this->redirect('this', ['id' => $values['id']]);
        };

        return $form;
    }

    public function handleDeleteImage($newId): void
    {
        /** @var ActiveRow $image */
        $service = $this->repository->service->get($newId);
        unlink(WWW . '/upload/services/' . $service->id . '/' . $service->cover);
        $service->update(['cover' => null]);
        $this->flashMessage('Náhledový obrázek byl smazán', 'success');
        $this->redirect('this');
    }
}
