<?php

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\MessageBag;

use Tmont\Midi\Parsing\FileParser;
use Tmont\Midi\Parsing\TrackParser;
use Tmont\Midi\Reporting\TextFormatter;
use Tmont\Midi\Reporting\Printer;
use Tmont\Midi\Reporting\HtmlFormatter;

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

    public function splitTracks()
    {
        $fileLocation = Config::get('app.uploader.location');

        $file = $fileLocation . '/name.midi';
        $file = __DIR__ . '/../../vendor/tmont/midiparser/sample/And_We_Die_Young.mid';

        //create a new file parser
        $parser = new FileParser();
        $parser->load($file);

//        var_dump($parser->getTracksExpected(), $parser->getTracksParsed(), $parser->getState());
        $result = $parser->parse();
        var_dump($result);

//        $test = $parser->parseFileHeader($result);
//        var_dump($test);


//        $parser = new TrackParser();
//        $parser->load($file);
//
//        $result = $parser->parse();
//        var_dump($result);

//        var_dump($parser->getExpectedTrackLength(), $parser->getParsedTrackLength());

//        $test = $parser->parseFileHeader();

//        $parser->

//        var_dump($parser);

//        create a Printer object
//        $printer = new Printer(new TextFormatter(), $parser);

        //output the parse result
//        $printer->printAll();
    }

}
