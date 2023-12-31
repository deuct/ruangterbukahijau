<?php

class Route
{

    private function simpleRoute($file, $route)
    {
        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if (!empty($_REQUEST['uri'])) {
            $route = preg_replace("/(^\/)|(\/$)/", "", $route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/", "", $_REQUEST['uri']);
        } else {
            $reqUri = "/";
        }

        if ($reqUri == $route) {
            $params = [];
            include($file);
            exit();
        }
    }

    function add($route, $file)
    {
        //will store all the parameters value in this array
        $params = [];

        //will store all the parameters names in this array
        $paramKey = [];

        //finding if there is any {?} parameter in $route
        preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);

        //if the route does not contain any param call simpleRoute();
        if (empty($paramMatches[0])) {
            $this->simpleRoute($file, $route);
            return;
        }

        //setting parameters names
        foreach ($paramMatches[0] as $key) {
            $paramKey[] = $key;
        }


        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if (!empty($_REQUEST['uri'])) {
            $route = preg_replace("/(^\/)|(\/$)/", "", $route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/", "", $_REQUEST['uri']);
        } else {
            $reqUri = "/";
        }

        //exploding route address
        $uri = explode("/", $route);

        //will store index number where {?} parameter is required in the $route 
        $indexNum = [];

        //storing index number, where {?} parameter is required with the help of regex
        foreach ($uri as $index => $param) {
            if (preg_match("/{.*}/", $param)) {
                $indexNum[] = $index;
            }
        }

        //exploding request uri string to array to get
        //the exact index number value of parameter from $_REQUEST['uri']
        $reqUri = explode("/", $reqUri);

        //running for each loop to set the exact index number with reg expression
        //this will help in matching route
        foreach ($indexNum as $key => $index) {

            //in case if req uri with param index is empty then return
            //because url is not valid for this route
            if (empty($reqUri[$index])) {
                return;
            }

            //setting params with params names
            $params[$paramKey[$key]] = $reqUri[$index];

            //this is to create a regex for comparing route address
            $reqUri[$index] = "{.*}";
        }

        //converting array to sting
        $reqUri = implode("/", $reqUri);

        //replace all / with \/ for reg expression
        //regex to match route is ready !
        $reqUri = str_replace("/", '\\/', $reqUri);

        //now matching route with regex
        if (preg_match("/$reqUri/", $route)) {
            include($file);
            exit();
        }
    }

    function notFound($file)
    {
        include($file);
        exit();
    }
}

$route = new Route();

// $route->add("/user/{id}", "listing.php");

// Frontend
$route->add("/login", "front-end/view/login/index.php");
$route->add("/register", "front-end/view/register/index.php");
$route->add("/list", "front-end/view/listing/index.php");
$route->add("/list-admin", "front-end/view/listing/admin/index.php");
$route->add("/detail", "front-end/view/detail/index.php");
$route->add("/detail/add", "front-end/view/detail/admin/add.php");
$route->add("/detail/edit", "front-end/view/detail/admin/edit.php");
$route->add("/detail/setmap", "front-end/view/detail/admin/setmap.php");
$route->add("/setting", "front-end/view/setting/index.php");
$route->add("/setting/masterdata", "front-end/view/setting/masterdata/index.php");
$route->add("/profile", "front-end/view/profile/index.php");
$route->add("/map-search", "front-end/view/mapsearch/index.php");

// Backend
$route->add("/api/register", "back-end/register/register.php");
$route->add("/api/authenticate", "back-end/login/authenticate.php");
$route->add("/api/masterdata", "back-end/setting/masterdata.php");
$route->add("/api/listing", "back-end/listing/listing.php");
$route->add("/api/detail", "back-end/detail/detail.php");
$route->add("/api/profile", "back-end/profile/profile.php");

//example route with multiple params
// $route->add("/download/{downID}/{filename}", "download.php");

$route->notFound("front-end/view/notfound/index.php");
