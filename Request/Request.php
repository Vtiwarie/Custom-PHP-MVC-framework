<?php

class Request {

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    protected $url;
    protected $params = null;

    public function __construct($url=null) {
        $this->url = (isset($url)) ? $url : ($_SERVER['REQUEST_URI']);

        $query = explode('&', trim(parse_url($this->url, PHP_URL_QUERY)));
        if (!empty($query[0])) {
            foreach ($query AS $value) {
                $k = explode('=', $value);
                $key = $k[0];
                $val = $k[1];
                $this->params[$key] = $val;
            }
        }
    }

    public function isPost() {
        return ($_POST && ($_SERVER['REQUEST_METHOD'] === self::METHOD_POST));
    }

    public function getPost($key = null, $default = null) {
        if (null === $key) {
            return $_POST;
        }

        return (isset($_POST[$key])) ? $_POST[$key] : $default;
    }

    public function getParams() {
        return $this->params;
    }

    public function getParam($key = null) {
        if (!key_exists($key, $this->params))
            throw new Exception('invalid parameter given');
        return $this->params[$key];
    }

    public function getURL() {
        $pageURL = 'http';
        if (@$_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }

}

?>
