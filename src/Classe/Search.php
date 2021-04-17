<?php

namespace App\Classe;

use App\Entity\Category;

class Search
{
    /**
     * @var string
     */

    //pour construire un input
    public $string = '';

    /**
     * @var Category
     */

    //pour choisir entre les #cat
    public $categories = [];
}