_____________________________________________________
NOTAS PREVIAS
-Laravel mix es un sistema que define el paso a paso de compilacion de la tecnología webpack
Webpack es una aplicacion de node que ya viene incluida en laravel, es un sistema de agrupacion para preparar una aplicacion web antes de subir al servidor. Se trata de producir un solo archivo minificado que se va a usar desde nuestro html.
________________________________________
CREAR PROYECTO LARAVEL 5.4
-composer create-project --prefer-dist laravel/laravel laravel-vue-crud

/*=============================================
INSTALACION VUE.JS
=============================================*/
https://unpkg.com/vue@2.5.13/dist/vue.js
-copiar codigo
-borrar estos archivos del proyecto laravel:
	resources/assets/js/components
	resources/assets/js/app.js
	resources/assets/js/bootstrap.js
-crear resources/assets/js/vue.js pegar contenido copiado de la pagina de vue.js

-AXIOS
copiar codigo de axios del repositorio dist
https://raw.githubusercontent.com/axios/axios/master/dist/axios.js
	-crear archivo  resources/assets/js/axios.js
	-pegar codigo
-crear archivo personalizado  resources/assets/js/app.js


/*=============================================
INSTALACION DE LARAVEL MIX
=============================================*/
__________Instalacion de Node_____________________________
https://nodejs.org/en/download/

__________Instalacion de Npm(Node packages Manager)___________________________
ingresar en la consola al proyecto laravel y ejecutar el siguiente instalador:
-npm install
//npm es como un composer para el frontend
_______________________________________________________
-instalar node.js


_____________webpack.mix.js____________________

-//Se requiere tomar todos los archivos que tenemos en resources/assets/js/ agruparlos y llevarlos a public/js y remplazar el app.js que esta por defecto

-eliminamos esta linea de webpack.mix.js debido a que no compilaremos en este caso ningun archivo .sass en este proyecto
.sass('resources/assets/sass/app.scss', 'public/css');
-vamos a mezclar los siguientes scripts, de forma jerarquica
mix.scripts([
	'resources/assets/js/vue.js',
	'resources/assets/js/axios.js',
	'resources/assets/js/app.js',
	], 'public/js/app.js');//aqui es donde compilará
*1
Laravel mix es un sistema que instalamos en laravel para definir el paso a paso de compilacion de web pack utilizando un metodo de encadenamiento.
En este caso todo termina en un archivo llamado app.js

-ejecutamos en consola: 
npm run dev //cada vez que percibe un cambio npm dev vuelve y compila



_______________________app.blade.php____________________
-eliminamos style de app.blade.php y contenido de body
-poner ruta de bootstrap en app.blade.php
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

-generar esta linea para enlazar con el archivo que se creo con mix: <script src="{{asset('js/app.js')}}"></script>

-npm run dev para compilar

_______________________app.blade.php____________________
*1 es necesario poner un @ para no generar conflictos entre Vue y laravel

_________________________BASE DE DATOS____________________-
-Crear base con nombre: laravel_vue 

_________________MIGRACION Y MODELO__________________________
php artisan make:model Task -m //task modelo de tareas
esto genera el archivo database/migrations/create_tasks_table.php y crea el modelo para "Tarea"

___________________CONFIGURAR VISTAS_________________________
-renombro archivo welcome.blade.php ->app.blade.php

__________app.blade.php_______________-
*1 espacio para incrustar contenido
-------------------------------------

-crea plantilla resources/views/dashboard.blade.php //sera un panel administrativo


__________________dashboard.blade.php____________________-

*1 se extiende de la plantilla app
*2 seccion donde crearemos el contenido para app

-voy a routes/web.php y llamo a dashboard en la ruta raiz /

_________________BASE DE DATOS___________________
-No trabajare usuarios asi que elimino la migracion de users_table solo dejo create_tasks_table
----------------.env-------------------
DB_DATABASE=laravel_vue
DB_USERNAME=root
DB_PASSWORD=
-----------------app/providers/AppServiceProvider.php-------------------
*1AppServiceProvider: esta libreria me permite configurar cosas predeterminadas en la base de datos
*2AppServiceProvider: tamaño por defecto para los campos string de la base de datos. 120 caracteres
-elimino modelo usuario User.php


_____________2018_01_19_091806_create_tasks_table________________

*1create_tasks_table: campo keep o el contenido de la nota que estoy guardando


________________migracion____________________-
Ejecuto migracion con
php artisan migrate:refresh

_____________CONTROLADOR_______________
php artisan make:controller TaskController --resource //controlador con todos los metodos para crud

___________ROUTES/WEB.PHP____________
*1routesweb: al ejecutar la ruta / se ejecutara la vista dashboard, dashboard a su vez contendra la aplicacion VUEjs que será la que se conectara al TaskController y cada uno de sus metodos.
__________TaskController.php______________
*1 elimino el metodo 'show' debido a que no lo voy a usar en este proyecto

_____________routes/web.php____________________

*2routesweb: es una ruta de tipo resource , quiere decir que no se puede acceder a esta ruta por medio del navegador, solo lo puedo hacer internamente cuando algo me lo solicita por una accion interna.
'task' = nombre de la ruta
'TaskController' = controlador al que invocará

-con php artisan route:list solicito la lista de rutas para determinar si existe alguna que me sobre
-como elimine el metodo show del TaskController, tambien debo eliminar la ruta tasks.show
-----------Eliminar una ruta------------
['except'=> 'show'] *2routesweb: agregar este parametro a la ruta para omitir la ruta show la cual no usaremos.
_______________________________________________________

_______________________________________________________
___________________INICIO DE API_______________________
--------------------------------------------------------
______________CREACION DE SEEDER_______________
 php artisan make:seeder TasksTableSeeder - database/seeds/TasksTableSeeder.php

_______________DatabaseSeeder.php__________________
*1DatabaseSeeder invoco el seeder para los Tasks creado en el paso anterior

_______TasksTableSeeder.php__________
*1TasksTableSeeder: invocamos el modelo Task
*2TasksTableSeeder: invocamos el metodo factory para pedirle que cree 5 instancias a partir del modelo Task.

_____________HACER FACTORY en 5.4__________
__________________database/factories/ModelFactory.php____________________
-Usamos el factory que existe por defecto para la creación de usuarios y lo editamos para crear un factory de otra entidad.
*1ModelFactory: Editamos el nombre de la clase App\Task:
*2ModelFactory: nos devolvera una oracion aleatoria en el campo 'keep'

php artisan migrate:refresh --seed pedimos que se creen los seeds que existan

_____________HACER FACTORY en 5.5__________
php artisan make:factory Task //crear un modelo de factory especifico para mis task
____________factories/Task.php_____________
*1 solicito el campo a crear ' keep'

-php artisan tinker
factory('App\Task',10)->create();
_________________________________________________________________
CONFIGURAR TASKCONTROLLER
Alistaremos los metodos para que VUEjs se pueda comunicar con ellos
________________taskcontroller.php________________
*1TaskController: llamamos al modelo Task
*2TaskController: traemos informacion con el metodo get del modelo Task y se guarda en la variable $task
*3TaskController: devolvemos el contenido de esa variable
*4TaskController: llamamos al modelo Task, ejecutamos el metodo de busqueda find, le damos el id del item, nos guarda los resultados en la variable $task     $variable= entidad Task::metododeBusqueda('parametro')
*5TaskController: Guarda en la variable $task una instancia del modelo Task con los resultados del metodo findOrFail($id) que nos trae de la base de datos el item que coincide con el id 
*6TaskController: ejecuta el metodo eliminar sobre esa instancia, lo cual elimina directamente de la base de datos.
______________dashboard.blade.php__________________

*1 &nbsp; Entidad html para crear un espacio
th columna
tr fila resaltada
td fila normal
*2dashboard.blade.php: se agrega un @ a las variables de vue.js, con esta variable estamos imprimiendo el arreglo que contiene vuejs para esa variable
*3dashboard.blade.php: aqui se aprecia que la cantidad de columnas de la rejilla de bootstrap que ocupamos es 7 del maximo de 12 columnas que podemos usar
*4dashboard.blade.php:  ocupamos solo 5 columnas para sumar a las 7 anteriores un total de 12
______________resources/assets/js/app.js_______________
*7app.js este identificador corresponde al elemento html->*5dashboard.blade.php , pueden existir varios componentes de vuejs en una sola pagina html

*1app.js se inicializa la llave donde se encapsulan todos los datos (tareas o keeps)

*2app.js guarda la URI de la ruta task.index, mirar en php artisan route:list que coincida task con la uri

*3app.js usamos axios.get, sabemos si se usa metodo get yendo a php artisan route:list e identificando el metodo para la ruta actual

*3app.js this.keeps me guarda el contenido en *1app.js

*4app.js: este metodo se activa en la etapa de creacion(existen varias etapas en el ciclo de vida de un objeto vue) y ejecuta el metodo getKeeps()*5app.js el metodo getkeeps me hace la coneccion y me guarda todos los keeps que estan en la base de datos y *6app.js me los pasa a el arreglo keeps[]*1app.js response.data tenemos que entrar hasta data porque alli se encuentra la información que necesitamos del arreglo

-npm run dev para ajustar cambios en el app.js

______________dashboard.blade.php__________________
*7dashboard.blade.php: v-for ejecuta un ciclo for, keep es una variable donde me ira almacenando cada una de las vueltas del ciclo, keeps es ese arreglo que contiene las tareas desde la base de datos.

*8dashboard.blade.php: keep la variable resultante del ciclo en su posicion actual, id uno de los campos del arreglo

*9dashboard.blade.php: keep la variable resultante del ciclo en su posicion actual, keep uno de los campos del arreglo, se usa un @ para diferenciar los {{}} de las entidades blade

__________/js/app.js___________________
-creamos el metodo deleteKeep para eliminar tareas:

*8app.js: metodo para eliminar tareas.

-npm run dev  cada vez que se hace un cambio en app.js

	
________dashboard.blade.php___________________

*10dashboard.blade.php:  la directiva v-on:click detecta el evento click y ejecuta el metodo deleteKeep(), el parametro prevent evita que el navegador ejecute acciones adicionales despues de ejecutar el metodo deleteKeep, por ejemplo evita refrescar la pagina.
deleteKeep(keep) le damos al metodo deletekeep el parametro keep que corresponde a la variable de la linea *7dashboard.blade.php
y que contiene la información del elemento consultado por el ciclo for en su posicion actual
__________/js/app.js___________________
*9app.js: el parametro keep corresponde a la variable proveniente del ciclo v-for donde tendremos guardada la información del elemento que queremos eliminar
 -npm run dev
 *10app.js: guardamos en la variable url la ruta para pedirle a laravel que elimine un elemento. Esta ruta la sabemos gracias a ejecutar el comando php artisan route:list donde encontramos el formato de la ruta y el metodo que se debe usar. A la ruta concatenamos el id del elemento que queremos eliminar, el cual traemos en la variable keep. 
*11app.js: le damos a axios el metodo delete y le pasamos como parametro la variable url que contiene la ruta que le pide a laravel la eliminacion del elemento. Luego axios nos devuelve una respuesta:
*12app.js: En la respuesta llamamos de nuevo al metodo getKeeps(); con el fin de que refresque y renderize de nuevo todos los elementos de acuerdo al estado actual que cambió porque se hiso una eliminacion de un elemento. Al cargar el metodo getkeeps basicamente le estamos pidiendo que cargue de nuevo el arreglo keeps[]*1app.js para que quede de acuerdo al nuevo estado de la base de datos.

__________PREPARAR ENTORNO PAR NOTIFICACIONES DESPUES DE ELIMINAR_____________________
----------------------------------------------------------------------
https://github.com/twbs/bootstrap/tree/v3.3.7/dist/js
____________INSTALAR BOOTSTRAP_________________
-Generar resources/assets/js/bootstrap.js
https://raw.githubusercontent.com/twbs/bootstrap/v3.3.7/dist/js/bootstrap.js

-Generar resources/assets/css/bootstrap.css
https://raw.githubusercontent.com/twbs/bootstrap/v3.3.7/dist/css/bootstrap.css

_____________INSTALAR JQUERY__________________
-Generar resources/assets/js/jquery-3.3.1.js
https://jquery.com/download/  ---->Download the uncompressed, development jQuery 3.3.1

___________INSTALAR TOASTR_________________
-Generar resources/assets/js/toastr.js
https://raw.githubusercontent.com/CodeSeven/toastr/master/toastr.js

-Generar resources/assets/css/toastr.css
https://raw.githubusercontent.com/CodeSeven/toastr/master/build/toastr.css


________________ACTUALIZAR WEBPACK______
-Agregar las nuevas librerias a webpack en mix.scripts
*1webpack.mix: jquery tiene mayor jerarquia entonces ira de primero
*2webpack.mix: bootstrap depende de jquery por lo tanto ira de segundo
*3webpack.mix: toastr depende de jquery por lo tanto ira por debajo
*4webpack.mix: axios depende de VUE.js por lo tanto va por debajo

____________________WEBPACK CSS___________
Agregar estas lineas en mix:
.styles([
	'resources/assets/css/bootstrap.css',
	'resources/assets/css/toastr.css',

	],'public/css/app.css')
*5webpack.mix: ruta de los archivos bootstrap que se mexclaran
*6webpack.mix: ruta final donde se mexclaran todos los archivos de estilo

____________app.blade.php___________________
*2app.blade.php: el helper asset busca a partir de public, hacemos llamado del archivo css/app.css debido a que laravel mix a hecho la mezcla de todos los archivos correspondientes a estilo css dentro de este archivo, incluido bootstrap y el css para toastr

- npm run dev
------------------------------------------------------------------------------
______FIN PREPARACION DE ENTORNO PARA NOTIFICACIONES DESPUES DE ELIMINAR____________

_____________resources/js/app.js___________________
*13app.js: llamamos a toastr con el metodo success que invocara un anuncio de exito y le mandamos como parametro un mensaje de exito. Esto lo ponemos despues de ejecutar el metodo getKeeps que provocara que se recargue la pagina con los elementos actuales
*14app.js: confirm() para determinar si quiero eliminar 

--------------------------------------------------------------------
_______________________CREATE___________________________________
--------------------------------------------------------------------
_____________dashboard.blade.php___________________
*11dashboard.blade.php: data-toggle="modal"-> activa la tecnología de ventanas modales
data-target="#create"-> apunta al div create
-Creamos la vista create.blade.php
*12dashboard.blade.php: incluimos la vista create
_______________create.blade.php____________________
*1create.blade.php: class="modal fade" la clase bootstrap modal hace que solo aparezca el div en forma de ventana cuando se lo llame con un boton data-target y la clase fade hace que halla un pequeño efecto de desvanecido
*2create.blade.php: modal-dialog clase de bottstrap que llama al tipo de modal que queremos
*3create.blade.php: modal-content clase de bootstrap que  determina el contenido del modal
*4create.blade.php: clase de bootstrap modal-header determina el encabezado del modal
*5create.blade.php: clase de bootsatrap que da el cuerpo del modal

__________________Task.php________________________
-Habilitar los campos para guardar en el modelo
*1Task.php: se agrega dentro del arreglo los campos que son autorizados para ser llenados por medio de formulario en la base de datos.

______web.php___________
*3routesweb: agregamos al except la ruta edit y create

_____________TaskController.php___________________ 
*7TaskController: elimino el metodo create() debido a que en este caso estamos usando un campo modal por medio de bootstrap como formulario de creacion.
- Ir a rutas y agregar la exepcion de este metodo
*8TaskController: elimino el metodo edit()

*9TaskController: este metodo recibe todos los datos del formulario de creacion y los guarda en la variable $request

*10TaskController: validamos que dentro de la variable request vengan los campos requeridos con contenido.

*11TaskController: pasamos los campos requeridos como obligatorios

*12TaskController: solicitamos que se cree una instancia nueva a partir del modelo Task y en el parametro le pasamos los campos para crear la nueva instancia de Task en el metodo all() hacemos que traiga todos los campos que estan en request pero el sistema solo tomara en cuenta los campos que esten calificados como fillable en el Modelo Task *1Task.php

*6create.blade.php: El campo for="keep" se refiere al name del input
*7create.blade.php: name="keep" nombre html del input 
class="form-control" clase de bootstrap para determinar que hace parte de un formulario
v-model="newKeep" : el nombre del modelo que usaremos para extraer la información que hay dentro del input o para actualizarla si es el caso desde el app de vue *16app.js
****You can use the v-model directive to create two-way data bindings on form input and textarea elements. It automatically picks the correct way to update the element based on the input type. 
**

*15app.js: guardamos la url laravel de (route:list) para ejecutar el guardado de datos (store), usamos el metodo axios.post porque es el que nos muestra route:list para poder ejecutar el metodo store del controlador(*9TaskController) y el contenido "tasks" equivale a la url que muestra el route:list para el metodo store.

*16app.js: llamamos a axios.post y le damos dos parametros, el primero es la url con el contenido de la ruta laravel.

*17app.js:  el segundo parametro es la variable keep: y le pasamos el contenido de v-model="newKeep" que es la caja de texto (*7create.blade.php)

_______________ejemplo de sintaxis axio.post___________
axios.post('/user', {
    firstName: 'Fred',
    lastName: 'Flintstone'
  })
  .then(function (response) {
    console.log(response);
  })
  .catch(function (error) {
    console.log(error);
  });
  _____________________________
*18app.js: declaramos la variable que usamos en el metodo create Keep
*19app.js: ejecutamos el metodo getKeeps con el fin de actualizar el contenido de la lista con el nuevo elemento que se creo.
*20app.js: Vaciamos la caja de texto
*21app.js: vaciamos el arreglo de errores para que no siga apareciendo aun despues de que ya cumplimos las reglas
*22app.js: llamamos el id del div "create" que vamos a desaparecer. ejecutamos el metodo modal('hide') que da la orden de esconder a un ventana con tecnología modal.
*23app.js: llamamos a toastr.success que llamara una notificacion exitosa con el contenido del parametro
*24app.js: de haber errores se llena el arreglo errors con el contenido de error.response.data que contiene todos los errores que nos devuelva laravel en la validacion del formulario.
*8create.blade.php: con v-for hacemos un ciclo for para recorrer el arreglor de errores y los vamos captando en cada vuelta como la variable erro, la cual imprimimos en @{{error}}
*9create.blade.php: v-on:submit.prevent="createKeep" al ser un formulario detecta la subida mediante el boton submit y ejecuta el metodo  createKeep
prevent se usa para evitar que se recargue la pagina por si misma y deja que sea vue el que refresque los datos

-------------------------------------------------
--------------------------------------------------------------------
_______________________EDIT___________________________________
--------------------------------------------------------------------
-Creamos nuevo formulario para editar
*1edit.blade.php: v-on:submit.prevent="updateKeep(fillKeep.id)" al detectar la accion de submit del formulario ejecuta el metodo updateKeep(fillKeep.id) en el parametro se pasara el id, contenido en el arreglo fillKeep:*25app.js  

*13dashboard.blade.php: inclusion de la plantilla edit para que incluya el formulario de edicion
*14dashboard.blade.php: v-on:click.prevent="editKeep(keep)": detectamos el click, y llamamos al metodo editKeep(keep) pasandolela variable keep correpondiente a *7dashboard.blade.php y que contiene toda la información del keep en la posicion actual del ciclo, dentro del metodo en el app.js usaremos esa variable para extraer el id o el keep actual
*25app.js: variable usada en el metodo editKeep()
*26app.js: el parametro keep es la variable que viene de *14dashboard.blade.php y trae todo el contenido del keep que esta devolviendo el ciclo for.

*27app.js: llamamos dentro de la misma app con this. a la variable fillKeep y al campo id y le ponemos el valor del campo id de la variable keep que llego por el parametro de la funcion

*39app.js: limpiamos el arreglo de errores por si en la edicion anterior quedo cargada con un error
*28app.js: llenamos el valor del campo keep de la variabl fillKeep, que es un arreglo, con el contenido de keep.keep que proviene del ciclo for de la vista y nos llego por medio del parametro de la funcion editKeep
USO DE JQUERY PARA HACER APARECER EL FORMULARIO EN PANTALLA
*29app.js: jQuery llama al div con el id #edit y le dice al modal que se muestre mediante el comando show
*2edit.blade.php: v-model="fillKeep.keep" la directiva v-model nos conecta con el arreglo  fillKeep*25app.js y el campo keep y pone la información actual del arreglo en el input para que podamos editarla

*30app.js: determinamos la url apropiada para ejecutar el metodo update a traves de php artisan route:list que seria tasks/{task} 
*31app.js: axios.put: el put lo determinamos con rout:list porque queremos ejecutar el metodo update del controlador y esto nos solicita el metodo put
(url, this.fillKeep) como primer parametro pasamos la url que sirve para ejecutar el metodo update del controlador, como segundo parametro enviamos el arreglo que contiene los datos del campo de texto y el id, estos datos se actualizan en el arreglo fillKeep en tiempo real asi que mientras digitamos y modificamos un input la información esta al mismo tiempo conservandose en el arreglo, cuando ejecutamos axios.put(url,this.fillKeep) en ese momento se da la orden al controlador para que ejecute el metodo update y se lo alimenta con los parametros.
.then(response =>{ si todo sale bien y no nos devuelve errores el controlador entonces continua el resto de la operacion
*32app.js: ejecutamos el metodo getkeeps() para actualizar  y obtener todos los datos actualizados
*33app.js: ponemos en blanco el arreglo 
*34app.js: limpiamos el arreglo de errores
*35app.js: escondemos el div edit que es un modal por medio de jQuery
*36app.js: notificacion de actualizacion con toastr
*37app.js: si el controlador en su metodo update no logra actualizar nos devolvera un error aqui lo capturamos
*38app.js: llenamos el arreglo errors con la información que nos da el api de error de laravel, luego de que se llene ese arreglo aparecera visible el div de errores al ejecutarse este ciclo for *3edit.blade.php

*13TaskController: los parametros para la actualizacion son entregados por axios.put  en *31app.js:
*14TaskController: realizamos la validacion de los datos guardados en la variable $request
*15TaskController: determinamos que el campo keep es obligatorio y no debe ir en blanco
*16TaskController: CUando ya validamos llamamos a la clase Task le pedimos con find que busque el $id que traemos en el parametro del metodo y ejecutamos el metodo update al cual le pasamos los datos contenidos en la variable $request, esta variable trae todos los datos por el all() pero cuando pasa por el modelo Task*1Task.php se especifica que solo pasaran los campos que esten en calidad de fillable
asi que solo se guardara o actualizara la información que este especificada alli en el modelo.
------------ fin de EDIT-----------------------


------------------//PAGINACION-------------------------
PRIMERO PROGRAMAMOS EL LISTADO DE LOS ELEMENTOS

*17TaskController: realiza la consulta de toda la tabla tasks y los pagina de a 4 registros
*18TaskController: Array que contendra otros array con la información de la paginación
*19TaskController: Controlara los registros que hay en pantalla, devuelve la consulta hecha en *17TaskController:

*20TaskController: llama al total() que es un metodo que nos provee laravel al ejecutar el metodo paginate() al igual con el resto de metodos de paginacion

*40app.js: this.keeps= llena el arreglo keeps[] con lo que alla consultado axios, si ponemos response.data entrara solo hasta el arreglo data que nos contendra todos los arreglos que nos devuelve el metodo index del controlador, pero como queremos solo lo que esta paginado entramos hasta el data del arreglo tasks que solo contiene la información ya paginada
response.data.tasks.data

A CONTINUACION SE REALIZA LA PROGRAMACIÓN PARA LA PAGINACION

*41app.js: array con las variables que contendran los valores de paginación
*42app.js: llenamos el array pagination con la respuesta de axios entrando hasta el arreglo pagination(*18TaskController) lo hacemos para poder usar esa información con vue a la hora de dirigir los elementos de la vista hacia cada pagina

*43app.js: devuelve el valor del arreglo pagination(*41app.js) y la variable current_page para determinar en que pagina estamos actualmente y comparar con los botones para saber si los alumbramos o no

*44app.js: Si el valor de .pagination.to es 0 osea si la pagina hasta la que se esta paginando esta en 0 entonces no se imprimira nada en pantalla

*45app.js: para determinar el numero desde el que empieza la numeracion (from) se le asigna primero a la var from el numero de pagina actual y se le resta un offset para determinar unos cuantos puestos que queden comodos a la numeracion nueva 

*50app.js: si al hacer la resta anterior se genera un numero negativo, es decir si el numero es suficientemente pequeño como para que de negativo entonces se deduce que se va a arrancar en 1

*46app.js: numero hasta el que va a  llegar la numeracion (to) 

*51app.js: con este if determinamos que la numeracion no se pase del numero máximo de paginas, en caso tal de que ocurra entonces cuadramos hasta la ultima pagina

*47app.js: variable array para guardar el total de paginas

*21TaskController: agregamos el parametro Request al metodo para poderle pasar información mediante el metodo GET 


*52app.js:mientras que el numero (desde) sea igual o inferior al numero (hasta) 
*53app.js: se va guardando en el array numero por numero de pagina para poder luego colocar la secuencia en pantalla

*48app.js:  el parametro resive la pagina hacia la cual se quiere ir a continuación.

*49app.js alteramos el valor de la pagina actual con el de la pagina hacia la que se va para que quede actualizado el valor

*50app.js: mandamos a la funcion getkeeps la pagina nueva en el parametro

*54app.js: devuelve un array con cada uno de los numeros de pagina generados por (*53app.js)

*15dashboard.blade.php: la clase  pagination es de bootstrap


*16 dashboard.blade.php: como este boton solo debe aparecer cuando la pagina actual sea mayor a 1 entonces se condiciona para que solo se renderice cuando el valor de (*41app.js:) el arreglo pagination en su valor current_page se mayor a 1. o mejor dicho cuando la pagina actual sea 1.

*17 dashboard.blade.php: si la pagina actual es la ultima no debe renderizars el boton de pasar pagina,
se condiciona la renderizción para que solo imprima si el valor de pagina actual es menor el de la ultima pagina

*18 dashboard.blade.php: para devolver llamamos al evento click de vue y prevent previene que la pagina se refresque, se llama al metodo changePage (*48app.js:) que espera un parametro dentro del cual mandamos el calculo de la pagina actual - 1 para determinar cual es la pagina anterior

*19 dashboard.blade.php: para avanzar llamamos al evento click de vue y prevent previene que la pagina se refresque, se llama al metodo changePage (*48app.js:) que espera un parametro dentro del cual mandamos el calculo de la pagina actual + 1 para determinar cual es la pagina siguiente


*20 dashboard.blade.php: con v-for="page in pagesNumber se imprime tantas veces se encuentren posiciones en el array devuelto por *54app.js la funcion computada pagesNumber 
v-bind:class nos asigna una propiedad a la etiqueta,  imprimimos el resultado de una condicion ternaria, esta condicion pregunta si la variable page del for osea la pagina actual coincide con el valor devuelto por la funcion computada isActived (*43app.js) osea si el numero del boton y la pagina actual coinciden entonces imprimir dentro de la etiqueta esto 'active' que es una propiedad de bootstrap y si no es asi entonces poner '' para que no altere nada

