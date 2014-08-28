<?php

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
            $fileTmpName = substr($file->getRealPath(), 5);
            Session::put('fileName', $file->getClientOriginalName());
            $file->move(Config::get('app.uploader.location'));

            return Redirect::route('tracks', array($fileTmpName));
        }

        return Redirect::route('index')->withErrors($validator);
    }

    public function getTracks($file)
    {
        try {
            $tracks = ConversionService::getTracks($file);
        }
        catch (ParseException $e)
        {
            File::delete($file);

            return Redirect::route('index')->withErrors('validation.uploader.fileType');
        }

        $data = array(
            'fileTmpName' => $file,
            'fileName' => Session::get('fileName', ''),
            'tracks' => $tracks,
        );

        return View::make('index.tracks', $data);
    }

    public function postTracks($file)
    {
        if (Input::has('title'))
        {
            Session::put('title', Input::get('title'));
        }
        else
        {
            $tracks = ConversionService::getTracks($file);
            Session::put('title', $tracks[Input::get('track')]);
        }
        // Todo: cooler processing stuff

        return Redirect::route('musicSheets', array($file));
    }

    public function getMusicSheets($file)
    {
        $data = array(
            'title' => Session::get('title'),
        );

        return View::make('index.music', $data);
    }

}
