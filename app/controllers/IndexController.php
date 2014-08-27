<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\MessageBag;

class IndexController extends Controller
{
    public function getIndex()
    {
        return View::make('index.index');
    }

    public function postMidiFile()
    {
        /* @var $file UploadedFile */
        $file          = Input::file('midi_file');
        $rules         = array(
            'midi_file' => array(
                'required',
                'between:0,' . Config::get('app.uploader.fileSize'),
            ),
        );
        $errorMessages = array(
            'required' => 'validation.uploader.required',
            'between'  => 'validation.uploader.between',
        );

        $validator = Validator::make(array('midi_file' => $file), $rules, $errorMessages);

        if ($validator->passes()) {
            $file->move(Config::get('app.uploader.location'));
            // Todo: cooler processing stuff

            return Redirect::to('/')->with(array('success' => new MessageBag(array('success' => 'validation.uploader.success'))));
        }

        return Redirect::to('/')->withErrors($validator);
    }

}
