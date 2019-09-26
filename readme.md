# Instalation

```bash
composer require ibnujakaria/file-manager
```

### Publish Configuration and Assets

```bash
php artisan vendor:publish --provider=\Ibnujakaria\FileManager\FileManagerServiceProvider
```

### Define routing:

```php
# routes/web.php

\FileManager::routes();

# or you can group it wherever you want
Route::prefix('admin')->group(function () {
  \FileManager::routes();
})->middleware('auth:admin');
```

# Basic Usage

### Load Assets

```html
<html>
  <!-- bootstrap css -->
  <link rel="stylesheet" href="dist/bootstrap.min.css">
  <!-- jquery -->
  <script src="dist/jquery.min.js"></script>
  <!-- bootstrap js -->
  <script src="dist/bootstrap.min.js"></script>

  <!-- File Manager js -->
  <script src="{{ asset('file-manager/file-manager.js') }}"></script>
</html>
```

### Run File Manager
```html
<!-- html -->
<div id="file-manager-app"></div>

<!-- script -->
<script>
  let fileManager = new FileManager('#file-manager-app')
  fileManager.show()
</script>
```

### Run File Manager in Modal and pick a file

```js
let fileManager = new FileManager()

fileManager.pickFile().then(file => {
  console.log(file.public_path)
})

// or using async/await
let fileManager = new FileManager()
let file = await fileManager.pickFile()
```

# License
The Multiple Select Js library is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).
