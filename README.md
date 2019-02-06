Update repo:
- readme installation
- makefile env command
- update laravel.sh
- update aliases.sh
- update gitignore

# Installation process
1. Download ZIP or clone the repository
2. Run laravel.sh script
3. Open http://localhost:8080

##### For using aliases, apply source bash file
```
source aliases.sh
``` 

###### Artisan command available via artisan alias like this
```
artisan make:controller UserController
```
Artisan commands runs from current user and have no permissions problems

##### For using Laravel echo server, add the following sections 

- Install socket.io & laravel-echo
```
docker-compose exec node yarn add socket.io laravel-echo --save
 ```

```
// to layout.blade.php, before <script src="{{ asset('app.js') }}"></script>

<script>
  window.echoConfig = {
    host: {!! json_encode(env('ECHO_SERVER_HOST')) !!},
    port: {!! json_encode(env('ECHO_SERVER_PORT')) !!}
  };
</script>
```
```
// bootstrap.js

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.io = require('socket.io-client');

const host = window.echoConfig.port
  ? `${window.echoConfig.host}:${window.echoConfig.port}`
  : window.echoConfig.host;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    namespace: 'App.Events',
    host
});
``` 

### TODO:
- add eslint extension
- add code style extensions (cs-fixer)

-- add echo-server to supervisor conf

- figure it out with deployment
- add all extensions to supervisor container
