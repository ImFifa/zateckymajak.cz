<?php

namespace App\AdminModule\Presenters;

use App\Grid\EventGrid;
use App\Grid\IEventGridFactory;
use DateTime;
use Nette\Application\UI\Form;
use App\Services\Helpers;
use Nette\Database\SqlLiteral;
use Nette\Database\Table\ActiveRow;
use Nette\Http\FileUpload;
use Nette\Utils\Strings;

class EventPresenter extends BaseScprorodinuPresenter
{

    /** @var IEventGridFactory @inject */
	public $eventGridFactory;

    public function renderEdit(?int $id): void
	{

        /** @var ActiveRow $event */
        if ($id !== null && $event = $this->repository->event->get($id)) {

            $event = $event->toArray();

            /** @var DateTime $date */
            $date = $event['date'];
            $event['date'] = $date->format('d.m.Y');

            /** @var Form $form */
            $form = $this['eventForm'];
            $form->setDefaults($event);

            $this->template->event = $event;
        } else {
            $this->template->event = null;
        }
	}

	public function renderParticipants(int $event_id): void
    {
        $this->template->event = $this->repository->event->get($event_id);
        $this->template->participants = $this->repository->participant->getParticipantsForEvent($event_id);

    }

    function handleDeleteParticipant($id)
    {
        $event_id = $this->repository->getParticipant($id)->event_id;
        $this->repository->participant->getTable()->where('id', $id)->delete();
        $this->repository->event->getTable()->where('id', $event_id)->update(['participants' => new SqlLiteral('participants - 1')]);
        $this->redirect('this');
    }

	protected function createComponentEventGrid(): EventGrid
	{
		return $this->eventGridFactory->create();
	}

	protected function createComponentEventForm(): Form
	{
		$form = new Form();

        $form->addHidden('id');

        $form->addText('name', 'Název')
            ->addRule(Form::MAX_LENGTH, 'Maximálné délka je %s znaků', 150)
            ->setRequired('Musíte uvést jméno události');

        $form->addText('date', 'Datum konání')
            ->setDefaultValue((new DateTime())->format('j.n.Y'))
            ->setRequired('Musíte uvést datum události');


        $form->addText('location', 'Místo konání')
            ->setRequired('Musíte uvést místo konání události');


        $form->addInteger('capacity', 'Kapacita')
            ->setDefaultValue(30)
            ->setRequired('Musíte uvést maximální kapacitu události');

        $form->addText('price', 'Cena (Kč)')
            ->setDefaultValue(0)
            ->setRequired('Musíte uvést cenu události');

        $form->addUpload('image', 'Nahrát náhledový obrázek události');

        $form->addCheckbox('public', 'Veřejný článek')
            ->setDefaultValue(true);

        $form->addSelect('gallery_id', 'Připojit galerii')
            ->setPrompt('Žádná')
            ->setItems($this->repository->gallery->getForSelect());

        $form->addSelect('category_id', 'Kategorie')
            ->setPrompt('Žádná')
            ->setItems($this->repository->getServicesForSelect());

        $form->addTextArea('content', 'Popis', 100, 25)
            ->setHtmlAttribute('class', 'form-wysiwyg');

        $form->addSubmit('save', 'Uložit');

        $form->onSubmit[] = function (Form $form) {
            $values = $form->getValues(true);
            $values['date'] = date_create_from_format('j.n.Y', $values['date'])->setTime(0, 0, 0);
            $values['slug'] = Strings::webalize($values['name']);
            if ($values['price'] === '0')
                $values['price'] = 'Zdarma';


            /** @var FileUpload $file */
            $file = $values['image'];
            unset($values['image']);

            if ($values['id'] === '') {
                unset($values['id']);
                $values['id'] = $this->repository->event->insert($values)->id;
                $this->flashMessage('Událost přidána', 'success');
            } else {
                $this->repository->event->get($values['id'])->update($values);
                $this->flashMessage('Událost upravena', 'success');
            }

            $link = WWW . '/upload/events/' . $values['id'] . '/';

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
                $this->repository->event->getTable()->where('id', $values['id'])->update(['cover' => $name]);

                $this->cropper('upload/events/' . $values['id'] . '/' . $name, $this->configuration->newAspectRatio, $this->link('this', ['id' => $values['id']]));
            }

            $this->redirect('this', ['id' => $values['id']]);
        };

		return $form;
	}

    public function handleDeleteImage($newId): void
    {
        /** @var ActiveRow $image */
        $event = $this->repository->event->get($newId);
        unlink(WWW . '/upload/events/' . $event->id . '/' . $event->cover);
        $event->update(['cover' => null]);
        $this->flashMessage('Náhledový obrázek byl smazán', 'success');
        $this->redirect('this');
    }
}
