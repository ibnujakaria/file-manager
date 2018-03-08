<!DOCTYPE html>
<html>
<head>
  <title>File Manager</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style type="text/css">
    table.table.table-hover tbody tr {
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container-fluid" id="file-manager-app" style="margin-top: 20px">
    <div class="row">
      <div class="col-sm-2">
        <div>
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle btn-block" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 47px">
              New
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="min-width: 100%">
              <a class="dropdown-item" href="#" @click="openModal('modal-new-folder')"><i style="width: 20px" class="fa fa-folder"></i> Folder</a>
              <a class="dropdown-item" href="#"><i style="width: 20px" class="fa fa-upload"></i> File Upload</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-10">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#" @click="openDirectory('/')">Home</a>
            </li>
            <li class="breadcrumb-item" v-for="(p, key) of path.split('/')">
              <a href="#" @click="openDirectoryByIndex(key)">@{{p}}</a>
            </li>
          </ol>
        </nav>
      </div>
    </div>
    <div>
      <table class="table table-hover">
        <thead class="thead-dark">
          <th>Name</th>
          <th>Last Modified</th>
          <th>Size</th>
          <th>Action</th>
        </thead>
        <tbody>
          <tr v-for="directory in directories" @click="openDirectory(directory.path)">
            <td>
              <i class="fa fa-folder" style="width: 20px"></i> @{{directory.name}}
            </td>
            <td>@{{directory.last_modified}}</td>
            <td>@{{directory.size || '-'}}</td>
            <td>-</td>
          </tr>
          <tr class="table-primary" v-for="file in files" @click="selectFile(file.path)">
            <td>
              <i class="fa fa-file" style="width: 20px"></i> @{{file.name}}
            </td>
            <td>@{{file.last_modified}}</td>
            <td>@{{file.size || '-'}} KB</td>
            <td>-</td>
          </tr>
        </tbody>
      </table>
    </div>
    @include('file-manager::partials.modals.new-folder')
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.5.0/vue-resource.min.js"></script>
  
  @include('file-manager::partials.scripts.file-manager-vue')
</body>
</html>