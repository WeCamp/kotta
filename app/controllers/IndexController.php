<?php

use Tmont\Midi\Parsing\ParseException;

class IndexController extends Controller
{
    public function getIndex()
    {
        $conversions = array();
        if (Auth::check()) {
            $conversions = Auth::user()->conversions()->take(15)->orderBy('id', 'desc')->get();
        }

        $data = array(
            'midiFiles'   => MidiFile::all(array('id', 'name'))->toJson(),
            'conversions' => $conversions,
        );

        return View::make('index.index', $data);
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
            $fileTmpName = substr($file->getRealPath(), 5);
            Session::put('fileName', $file->getClientOriginalName());
            $file->move(Config::get('app.uploader.location') . '/uploads');

            return Redirect::route('tracks', array($fileTmpName));
        }

        return Redirect::route('index')->withErrors($validator);
    }

    public function getTracks($file)
    {
        $fileTmpName = $file;
        $file        = ConversionService::getFilePath($file);

        try {
            $tracks = ConversionService::getTracks($file);
        } catch (ParseException $e) {
            File::delete($file);

            return Redirect::route('index')->withErrors('validation.uploader.fileType');
        }

        $data = array(
            'fileTmpName' => $fileTmpName,
            'fileName'    => Session::get('fileName', ''),
            'tracks'      => $tracks,
        );

        return View::make('index.tracks', $data);
    }

    public function postTracks($file)
    {
        $fileTmpName = $file;
        $file        = ConversionService::getFilePath($file);
        if (Input::has('title')) {
            Session::put('title', Input::get('title'));
        } else {
            $tracks = ConversionService::getTracks($file);
            Session::put('title', $tracks[Input::get('track')]);
        }
        if (Auth::check()) {
            ConversionService::addConversion(
                $fileTmpName,
                Session::get('fileName'),
                Input::get('track'),
                Session::get('title')
            );
        }
        // Todo: cooler processing stuff

        return Redirect::route('musicSheets', array($fileTmpName, Input::get('track')));
    }

    public function getMusicSheets($fileName, $track)
    {
        $file        = ConversionService::getFilePath($fileName);
        if (!Session::has('title')) {
            $tracks = ConversionService::getTracks($file);
            $title  = $tracks[$track];
        } else {
            $title = Session::get('title');
        }

        $builder = new \Kotta\Builder();
        $imageResources = $builder->generateImages($file, 0);

        $chunks = array();
        foreach ($imageResources as $imageResource) {
            ob_start();
            imagepng($imageResource);
            // Capture the output
            $imagedata = ob_get_contents();
            // Clear the output buffer
            ob_end_clean();


            $chunks[] = base64_encode($imagedata);
        }

        $data = array(
            'title'       => $title,
            'fileTmpName' => $fileName,
            'track'       => $track,
            'chunks'      => $chunks
        );

        return View::make('index.music', $data);
    }

}
