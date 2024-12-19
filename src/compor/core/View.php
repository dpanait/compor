<?php

namespace Core;

class View {
	private static $cssFiles = [];
	private static $jsFiles = [];
	public static $droot = "";
	public static $base_path = "";

	/**
	 * Renderiza una vista con datos, usando un layout
	 *
	 * @param string $view Ruta de la vista (sin la extensión .php)
	 * @param array $data Datos a pasar a la vista
	 * @param string $layout Nombre del layout (por defecto "main")
	 */
	public static function render($view, $data = [], $layout = 'index') {
		// Ruta absoluta al archivo de la vista
		$viewPath = dirname(__DIR__) . '/app/Views/' . $view . '.php';

		// Verificar si la vista existe
		if (!file_exists($viewPath)) {
			throw new \Exception("La vista '{$view}' no se encontró en '{$viewPath}'");
		}

		// Obtener el contenido de la vista
		$content = self::getViewContent($view, $data);

		// Cargar el layout
		self::loadLayout($layout, $data, $content);
	}

	/**
	 * Obtiene el contenido de una vista
	 *
	 * @param string $view Ruta de la vista
	 * @param array $data Datos a pasar a la vista
	 * @return string Contenido generado de la vista
	 */
	private static function getViewContent($view, $data) {
		ob_start();
		extract($data); // Convierte el array $data en variables
		require dirname(__DIR__) . '/app/Views/' . $view . '.php';
		return ob_get_clean(); // Devuelve el contenido generado
	}

	/**
	 * Carga el layout y pasa el contenido de la vista a la estructura del layout
	 *
	 * @param string $layout Nombre del layout
	 * @param array $data Datos a pasar al layout
	 * @param string $content Contenido generado por la vista
	 */
	private static function loadLayout($layout, $data, $content) {
		// Ruta del layout
		$layoutPath = dirname(__DIR__) . '/app/Views/layouts/' . $layout . '.php';

		// Verificar si el layout existe
		if (file_exists($layoutPath)) {
			// Pasar los datos al layout
			extract($data);

			// Incluir el layout
			require $layoutPath;
		} else {
			// Si no se encuentra el layout, solo mostrar el contenido
			echo $content;
		}
	}

	/**
	 * Agrega un archivo CSS a la lista de archivos a cargar
	 *
	 * @param string $file Ruta del archivo CSS
	 */
	public static function addCss($file) {
		self::$cssFiles[] = $file;
	}

	/**
	 * Agrega un archivo JS a la lista de archivos a cargar
	 *
	 * @param string $file Ruta del archivo JS
	 */
	public static function addJs($file) {
		self::$jsFiles[] = $file;
	}

	/**
	 * Devuelve los archivos CSS a incluir
	 *
	 * @return array Archivos CSS a incluir
	 */
	public static function getCssFiles() {
		return self::$cssFiles;
	}

	/**
	 * Devuelve los archivos JS a incluir
	 *
	 * @return array Archivos JS a incluir
	 */
	public static function getJsFiles() {
		return self::$jsFiles;
	}
}