<?php

Route::group(['namespace' => '\Ibnujakaria\FileManager'], function () {
  Route::get('file-manager', 'FileManagerController@index')->name('ibnujakaria.file-manager.index');
  Route::get('file-manager/list-all-files', 'FileManagerController@listAllFiles');
  Route::post('file-manager/add-directory', 'FileManagerController@addDirectory');
  Route::post('file-manager/upload-files', 'FileManagerController@uploadFiles');
  Route::delete('file-manager/delete-directories', 'FileManagerController@deleteDirectories');
  Route::delete('file-manager/delete-files', 'FileManagerController@deleteFiles');
});