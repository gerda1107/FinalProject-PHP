<?php 

namespace core;

use app\controllers\Comments;
use app\controllers\Pages;
use app\controllers\Users;

class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];
    
    public function __construct()
    { 
        $url = $this->getUrl();

        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . ucfirst($url[0]) . '.php')) {
                $this->currentController = ucfirst($url[0]);
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->currentController . '.php';

        if ($this->currentController === "Pages") {
            $this->currentController = new Pages;
        } elseif ($this->currentController === "Users") {
            $this->currentController = new Users;
        } elseif ($this->currentController === "Comments") {
            $this->currentController = new Comments;
        }

        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        if (isset($url[2])) {
            $this->params = $url ? array_values($url) : [];
        }

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }
    
    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}