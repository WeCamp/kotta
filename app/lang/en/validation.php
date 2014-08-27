<?php

return array(
	'uploader' => array(
	    'required' => 'You must upload a file for us to convert.',
	    'between'  => 'Your file must be between 0 and ' . Config::get('app.uploader.fileSize') . 'KB',
	    'success' => 'You have successfuly uploaded your file',
    ),
);