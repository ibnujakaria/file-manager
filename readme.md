[![](https://img.shields.io/packagist/v/ibnujakaria/file-manager)](https://packagist.org/packages/ibnujakaria/file-manager)
[![](https://img.shields.io/packagist/dm/ibnujakaria/file-manager)](https://packagist.org/packages/ibnujakaria/file-manager/stats)
[![](https://img.shields.io/packagist/php-v/ibnujakaria/file-manager)](https://github.com/ibnujakaria/file-manager/blob/master/composer.json)
[![](https://img.shields.io/github/issues/ibnujakaria/file-manager)](https://github.com/ibnujakaria/file-manager/issues)
[![](https://img.shields.io/github/license/ibnujakaria/file-manager)](https://github.com/ibnujakaria/file-manager/blob/master/LICENSE)
[![](https://img.shields.io/github/stars/ibnujakaria/file-manager?style=social)](https://github.com/ibnujakaria/file-manager/)

# Instalation

```bash
composer require ibnujakaria/file-manager
```

### Publish Configuration and Assets

```bash
php artisan vendor:publish --provider="Ibnujakaria\FileManager\FileManagerServiceProvider"
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
