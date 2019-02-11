<?php 

namespace App\View;

class View implements Renderable
{
	private $data = [];
	private $view;

	public function render()
	{
		$fileName = $this->getFileName();
		extract($this->data);
		require $fileName;
	}

    /**
     * View constructor.
     *
     * @param string $view
     * @param array $data
     */
	public function __construct(string $view, array $data = [])
	{
		$this->data = $data;
		$this->view = $view;
	}

    /**
     * @return string
     */
	private function getFileName() : string
    {
        $pathInView = str_replace('.', DIRECTORY_SEPARATOR, $this->view);
        $fileName = VIEW_DIR . $pathInView . '.php';
        return $fileName;
    }
}