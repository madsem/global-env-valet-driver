# GlobalEnvValetDriver

Loads additional ENV vars from current parent working directory.
This way you can easily re-use ENV vars & make them available for all projects.

## Requirements
- Laravel Valet 2.3.*

## Installation
- Just drop the file in your `~/.config/valet/Drivers` directory.
- Create a new `.valet-env.php` in the parent working directory where you keep your projects.  
*Example: You have projects in `~/Sites`, then create the file in `~/Sites/.valet-env.php`.*
- Have it return an array, like this:
```php
<?php

return [

	'*' => [
		'Key_1' => 'Value',
		...
		...
	],

];
```

Now all these ENV vars will be available globally to all of your projects.

Note: If you have multiple registered paths, this should still make the ENV vars available in all of your projects, even in different paths. (But is untested)
