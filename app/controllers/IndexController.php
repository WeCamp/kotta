<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;

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
                'between:0,' . Config::get('app.fileSize'),
            ),
        );
        $errorMessages = array(
            'required' => 'validation.required',
            'between'  => 'validation.between',
        );

        $validator = Validator::make(array('midi_file' => $file), $rules, $errorMessages);

        if ($validator->passes()) {
//            $file->move()
        }

        return Redirect::to('/')->withErrors($validator);
    }

}
