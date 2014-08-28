<?php

use Kotta\ValueObjects\Track;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\MessageBag;
use Kotta\Parser\Parser;

use Tmont\Midi\Delta;
use Tmont\Midi\Event\EndOfTrackEvent;
use Tmont\Midi\Event\TrackNameEvent;
use Tmont\Midi\Reporting\TextFormatter;
use Tmont\Midi\Reporting\Printer;
use Tmont\Midi\Reporting\HtmlFormatter;
use Tmont\Midi\TrackHeader;

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
        $fileLocation = Config::get('app.uploader.location');

        $file = Config::get('app.uploader.location') . '/' . $file;

        //create a new file parser
        $parser = new Parser();
        $parser->load($file);
        $midi = $parser->parseToMidiClass();
        dd($midi->getTrackNames()); 
    }

}
