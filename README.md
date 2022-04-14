# Foris Test

#### Explicandome

Opté por desarrollar una estructura desde cero para demostrar un poco más de mi conocimiento.
Empecé con la estructura default de los directorios y luego imaginé cómo sería la IoC para la llamada dinámica de los comandos. Qué me hizo elegir usar el archivo `boostrap.php` y `Kernel.php`.
Busqué paquetes que me ayudaran con la captura de argumentos de la línea de comando, También instalé phpunit para las pruebas automatizadas.
Empecé pelo desarrollo del Kernel.php, responsable del IoC y luego desarrollé mi primer comando, `File` en `Commands\DataFile.php`, lo que me llevó a registrar comandos en el `Kernel` y desarrollar `helpers.php`. 
Creé los 2 Traits, `FileManager` y `DataManager` para manipular los archivos y datos, para usarlos en los comandos de `Student` y `Presence`. Elegí el Trait porque contener funciones que varias clases podrían usar como herramienta.
Después de los comandos listos, trabajé en la clase `Validade` de validación de datos y reglas impuestas para guardar un registro.
Finalmente creé las pruebas unitarias de la aplicación. Opté por no hacerlo como TDD porque estaba construyendo una aplicación desde cero y quería entender mejor de antemano cuál sería la estructura definitiva de directorios y el ciclo de vida de la aplicación.

## Directory Structure

- Root directory
    - app
        - Commands
        - Contracts
        - Traits
    - config
    - storage
    - tests
        - mocks
        - Unit

##### The app directory
Contains all application logic files.
Including the `Kernel` file, responsible for starting the application classes.
The `Validate` file class, responsible for methods of validate data.
The `helpers.php`, a file that has global functions that help within the application.

##### The Commands directory
Directory that stores the classes that will be called for execution in the CLI

##### The Contracts directory
Directory that contains the application Interfaces class.

##### The Traits directory
Directory that contains the application Traits class.

##### The config directory
Contains global access files with custom settings that need to be fixed in the application, and the `bootstrap.php`, the file responsible for carrying out all the global loads of the application. 

##### The storage directory
Used to store the application's dynamic data files

##### The tests directory
Directory default for automated Test executions

##### The mocks directory
Directory to store mocks for test executions

##### The Unit directory
Directory to store the Unit Test

## Installation

The project requires:
- [Composer](https://getcomposer.org/) v2+ to run.
- [PHP](https://www.php.net/) v8+ to run.

Install the dependencies and devDependencies and start the server.

```sh
cd foris-test
composer install
```

After install the project dependencies, you must create a file to organize the command entries.
```sh
cd foris-test
php start.php File your_filename
```
example:
```sh
cd foris-test
php start.php File input.txt
```

## Execute Commands

For include new Students:
```sh
php start.php Student student_name
```
example:
```sh
php start.php Student John
```

For include new class Presence records:
```sh
php start.php Presence student_name day_of_week hour_start_class hour_end_class class_code
```
example:
```sh
php start.php Presence John 3 09:10 10:10 F100
```


## Execute automated Tests

```sh
cd foris-test
./vendor/bin/phpunit --testdox
```
