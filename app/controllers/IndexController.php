<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\MessageBag;
use Kotta\Parser\Parser;
use Tmont\Midi\Parsing\ParseException;

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
            $fileName = substr($file->getRealPath(), 5);
            $file->move(Config::get('app.uploader.location'));

            // Todo: cooler processing stuff
            return Redirect::route('tracks', array($fileName))->with(array('success' => new MessageBag(array('success' => 'validation.uploader.success'))));
        }

        return Redirect::route('index')->withErrors($validator);
    }

    public function getTracks($file)
    {
        //create a new file parser
        $parser = new Parser();
        $fileLocation = Config::get('app.uploader.location');
        $file = Config::get('app.uploader.location') . '/' . $file;

        $parser->load($file);

        try {
            $midi = $parser->parseToMidiClass();
        }
        catch (ParseException $e)
        {
            return Response::json(array('status' => 'failed'), 417);
        }

        return Response::json($midi->getTrackNames());
    }

    public function getMusicSheets($file)
    {
        return View::make('index.music');
    }
}
