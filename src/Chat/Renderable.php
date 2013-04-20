<?php
namespace Chat;

interface Renderable
{
    /*
     * Should render an object as a HTML associative array view and return it.
     */
     public function render();
}