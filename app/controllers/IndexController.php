<?php

use Kotta\ValueObjects\Track;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\MessageBag;

use Tmont\Midi\Delta;
use Tmont\Midi\Event\EndOfTrackEvent;
use Tmont\Midi\Event\TrackNameEvent;
use Tmont\Midi\Parsing\FileParser;
use Tmont\Midi\Parsing\TrackParser;
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

        $track = null;

        do {
            $result = $parser->parse();

            if ($result instanceof TrackHeader) {
                $track = new Track();
                $track->setSize($result->getData()[0]);
            }

            if ($result instanceof TrackNameEvent) {
                $track->setName($result->getData()[2]);
            }

            if ($result instanceof Delta) {
                $track->addTickCount($result->getData()[0]);
            }


            if ($result instanceof EndOfTrackEvent) {
                if ($track->getTicks()) {
//                    $trackBag->add($track);
                } else {
                    // todo: If the track has a name, it should be a comment. Add the comments to the MidiFile
                }
            }

        } while ($result);
    }

}
