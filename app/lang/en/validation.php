<?php

return array(
	'uploader' => array(
	    'required' => 'You must upload a file for us to convert.',
	    'between'  => 'Your file must be between 0 and ' . Config::get('app.uploader.fileSize') . 'KB',
        'fileType' => 'Your file must be a midi file!',
	    'success' => 'You have successfuly uploaded your file',
        'searchResultError' => 'We could not find the midi file you wanted to convert',
    ),
);