<?php

use App\Http\Response;
use App\Controller\Pages;

//Rota Home
$obRouter->get('/', [
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

//Rota Sobre
$obRouter->get('/sobre', [
    function(){
        return new Response(200,Pages\About::getAbout());
    }
]);

//Rota get Depoimentos
$obRouter->get('/depoimentos', [
    function(){
        return new Response(200,Pages\Testimony::getTestimonies());
    }
]);

//Rota Depoimentos insert
$obRouter->post('/depoimentos', [
    function($request){
        return new Response(200,Pages\Testimony::getTestimonies());
    }
]);


