<?php

namespace Imugalimov\Testwork;

class Helpers {

    public static function getAvgIncomeRating ($array) {

        usort($array, function($a,$b){
            return (($b['income'] / $b['population']) <=> ($a['income'] / $a['population']));
        });

        return ($array);

    }

    public static function getAvgExpensesRating ($array) {

        usort($array, function($a,$b){
            return (($b['expenses'] / $b['population']) <=> ($a['expenses'] / $a['population']));
        });

        return ($array);

    }

    public static function getPopulationRating ($array) {

        usort($array, function($a,$b){
            return ($b['population'] <=> $a['population']);
        });

        return ($array);

    }

} 
