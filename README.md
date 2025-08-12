<h1>Despliegue de la API REST de Tareas Personales</h1>
<p>Este documento contiene las instrucciones detalladas para la instalación, configuración y despliegue del proyecto de la API REST de gestión de tareas personales. Se asume que el despliegue se realizará en un entorno local de Windows utilizando XAMPP.</p>

📋 Requisitos del Sistema
<ul>
	<li>
		XAMPP: Entorno de desarrollo local.
		<ol>
			<li>
				Descarga: Ir al sitio web oficial de Apache Friends y descargar la versión de XAMPP que incluya PHP 8.1.
			</li>
			<li>
				Instalación: Ejecutar el instalador. Instalarlo en la raíz del disco C: para evitar problemas de permisos (por ejemplo, C:\xampp).
			</li>
			<li>
				Verificación: Una vez instalado, abrir el panel de control de XAMPP y hacer clic en "Start" para los módulos de Apache y MySQL. Si los módulos se vuelven verdes, significa que están funcionando correctamente.
			</li>
			<li>
				Prueba de PHP: Abrir el navegador y navegar a http://localhost/dashboard/. Se cargará la página de inicio de XAMPP, el servidor web está funcionando. Para verificar PHP, navegar a http://localhost/dashboard/phpinfo.php. Cargará una página con toda la información de PHP.
			</li>
		</ol>
	</li>
	<li>
		Composer: Gestor de dependencias de PHP.
		<ol>
			<li>
				Descarga: Ir al sitio web oficial de getcomposer.org y descargar el Composer-Setup.exe.
			</li>
			<li>
				Instalación: Ejecutar el instalador. Durante la instalación, pedirá que seleccione el ejecutable de PHP. Asegurarse que la ruta sea la de la instalación de PHP que viene con XAMPP, que generalmente se encuentra en C:\xampp\php\php.exe.
			</li>
			<li>
				Reiniciar el equipo para que se actualicen las variables de entorno.
			</li>
			<li>
				Verificación: Abrir una nueva terminal de Windows (CMD) y ejecutar el siguiente comando:
				composer --version
				Si se ve la versión de Composer, la instalación fue exitosa.
			</li>
		</ol>
	</li>
	<li>
		PHP: Versión 8.1.
		Instalado junto con Xampp
		Verificar la Ruta de PHP en Windows (PATH)
		Para poder ejecutar comandos de PHP desde cualquier lugar de tu terminal, debe existir la ruta de PHP en el PATH de Windows.
		<ol>
			<li>
				Acceder a las variables de entorno: En el menú de inicio de Windows, buscar "Editar las variables de entorno del sistema". Hacer clic en "Variables de entorno...".
			</li>
			<li>
				Ver la variable Path: En la sección "Variables del sistema", buscar la variable Path y hacer clic en "Editar...".
			</li>
			<li>
				Añadir la ruta de PHP si no existe: Hacer clic en "Nuevo" y agregar la ruta a la carpeta de PHP de XAMPP:
				C:\xampp\php
			</li>
			<li>
				Verificación: Cerrar y volver a abrir el terminal. Ejecutar el siguiente comando:
				php --version
				Si se visualiza la versión de PHP, la configuración del PATH ha sido exitosa.
			</li>
		</ol>
	</li>
	<li>
 		Git: Sistema de control de versiones.
	</li>
</ul>

📦 Instalación
Siga estos pasos para obtener el proyecto en su máquina:
<ol>
	<li>
		Clonar el repositorio:
		Abra una terminal (CMD o Git Bash) y navegue al directorio htdocs de su instalación de XAMPP. Luego, clone el repositorio con el siguiente comando:
        git clone https://github.com/andrespipe23/prueba_tecnica_php.git
	</li>
	<li>
		Instalar dependencias de PHP:
		Navegue al directorio del proyecto y ejecute Composer para instalar todas las dependencias de Laravel:
		cd prueba_tecnica_php
		composer install
	</li>
	<li>
		Configurar el archivo .env:
		Este archivo contiene todas las variables de entorno de la aplicación.
		Abra el archivo .env y configure las siguientes variables:
		DB_CONNECTION=mysql
		DB_HOST=127.0.0.1
		DB_PORT=3306
		DB_DATABASE=prueba_tecnica_php
		DB_USERNAME=root # Si no ha cambiado el usuario por defecto de XAMPP
		DB_PASSWORD= # Si no ha cambiado la contraseña por defecto de XAMPP
	</li>
</ol>

⚙️ Configuración de la Base de Datos
<ol>
	<li>
		Crear la base de datos en phpMyAdmin:
		<ul>
			<li>
				Inicie los servicios de Apache y MySQL desde el panel de control de XAMPP.
			</li>
			<li>
				Abra su navegador y navegue a http://localhost/phpmyadmin/.
			</li>
			<li>
				Haga clic en la pestaña "Nuevo" o en el enlace "Nueva" en el panel izquierdo.
			</li>
			<li>
				Introduzca el nombre de la base de datos 'prueba_tecnica_php' y haga clic en "Crear".
			</li>
		</ul>
	</li>
	<li>
		Ejecutar las migraciones:
		Desde la terminal, en el directorio del proyecto, ejecute el siguiente comando para crear las tablas de la base de datos, incluyendo la tabla de usuarios y la tabla para las tareas:
		php artisan migrate --seed
	</li>
</ol>

🔑 Configuración de Laravel Sanctum
Este proyecto utiliza Laravel Sanctum para la autenticación de usuarios mediante tokens Bearer.

🚀 Puesta en Marcha
Para iniciar el servidor de desarrollo de Laravel y comenzar a usar la API:
<ol>
	<li>
		Iniciar el servidor de desarrollo:
		Ejecute el siguiente comando en la terminal:
		php artisan serve
		La API estará disponible en la URL: http://127.0.0.1:8000.
	</li>
	<li>
	Uso de la API:
	<ul>
		<li>
			Las rutas de la API están definidas en el archivo routes/api.php.
		</li>
		<li>
			Para acceder a las rutas protegidas, debe primero autenticarse para obtener un Bearer Token.
		</li>
		<li>
			Utilice una herramienta como Postman o Insomnia para probar los endpoints.
		</li>
		<li>
			El token obtenido debe ser enviado en el encabezado de las solicitudes HTTP de la siguiente manera:
			Authorization: Bearer <your_token_here>
		</li>
	</ul>
	</li>
</ol>