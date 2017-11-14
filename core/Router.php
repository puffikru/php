<?php
/**
 * Created by PhpStorm.
 * User: igorbulakh
 * Date: 12.11.2017
 * Time: 8:42
 */

namespace core;

class Router
{
    private  $routes = [
        'GET' => [
            '/post' => [
                'callback' => 'Closure',
                'params' => 1
            ],
            '/post/edit' => [
                'callback' => 'Closure',
                'params' => 1
            ],
            '/post/add' => [
                'callback' => ''
            ],
            '/post/delete' => [
                'callback' => 'Closure',
                'params' => 1
            ],
            '/user/login' => [
                'callback' => 'Closure'
            ],
            '/user/logout' => [
                'callback' => 'Closure'
            ],
            '/user/sign-up' => [
                'callback' => 'Closure'
            ],
            '/texts/' => [
                'callback' => 'Closure'
            ],
            '/texts/add' => [
                'callback' => 'Closure',
                'params' => 1
            ],
            '/texts/edit' => [
                'callback' => 'Closure',
                'params' => 1
            ],
            '/texts/delete' => [
                'callback' => 'Closure',
                'params' => 1
            ]
        ],
        'POST' => [
            '/post/add' => [
                'callback' => 'Closure',
                'params' => 2
            ],
            '/post/edit' => [
                'callback' => 'Closure',
                'params' => 2
            ],
            '/texts/add' => [
                'callback' => 'Closure',
                'params' => 2
            ],
            '/texts/edit' => [
                'callback' => 'Closure',
                'params' => 2
            ],
            '/user/login' => [
                'callback' => 'Closure',
                'params' => 2
            ],
            '/user/sign-up' => [
                'callback' => 'Closure',
                'params' => 4
            ]
        ]
    ];

    public function get($uri, \Closure $closure){
        if($this->getMethod() !== 'GET'){
            return false;
        }

    }

    private function getMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }

    private function parseUri($uri){
        if(!isset($uri)){
            return false;
        }

        $uri_parts = explode('/', $uri);


    }

}
/*
$this->get('/post/edit/:id', function($id){
    // code
});

$this->post('/post/edit/:id', function($id){
    // code
});*/


$_SERVER['REQUEST_METHOD'];
$_SERVER['REQUEST_URI'];

$uri = 'post/edit/5';
$arr = explode('/', $uri);

[
    'post', 'edit', '5'
];