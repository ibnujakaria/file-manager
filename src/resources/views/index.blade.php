<!DOCTYPE html>
<html>
<head>
  <title>File Manager</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    table.table.table-hover tbody tr {
      cursor: pointer;
    }
  </style>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
  <div class="container-fluid mt-2">

    <div style="border: 1px solid red;" class="p-2 m-2">
      <button onclick="showFileManager()">Show File Manager</button>
      <button onclick="pickFile()">Pick File Manager</button>
      <button onclick="pickFiles()">Pick Files Manager</button>
    </div>
    <div id="file-manager-app"></div>
  </div>
  {{-- @include('file-manager::partials.modals.new-folder')
  @include('file-manager::partials.modals.remove-file') --}}
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <script src="{{ asset('file-manager/file-manager.js') }}"></script>
  <script>
    function showFileManager () {
      let fileManager = new FileManager('#file-manager-app')
      fileManager.show()
    }
    
    function pickFile () {
      let fileManager = new FileManager()
      fileManager.pickFile().then(file => {
        console.log("Oke, sudah diterima dari index.blade.php")
        console.log(file.public_path)
      })
    }

    function pickFiles () {
      let fileManager = new FileManager()
      fileManager.pickFiles().then(files => {
        console.log("Oke, sudah diterima dari index.blade.php")
        files.forEach(file => {
          console.log(file.public_path)
        });
      })
    }
  </script>
</body>
</html>