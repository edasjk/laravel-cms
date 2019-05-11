<?php

Class Number 
{
    public function sum($x, $y) 
    {
        return $x + $y;
    }

    public function square($x)
    {
        return $x*$x;
    }

    public function numberSum($x, $y)
    {   
        $sum = [];
        //all sums to array
        for ($i = 1; $i <= $y; $i++) {

            if ($i === 1) {
                $sum[$i] = 1;
            } else {
                $sum[$i] = $sum[$i-1] + $i;
            }
        }

        //only range sums to array
        $rez = [];

        for ($i = $x; $i <= $y; $i++) {
            $rez[$i] = $sum[$i];
        }
        //return $sum[$i-1];
        return $rez;
    }

    //calculates fibo number
    public function fibo($x)
    {
        $fibo = [];
        $fibo[1] = 2;
        $fibo[2] = 3;
        for ($i=3; $i<=$x; $i++) {
            $fibo[$i] = $fibo[$i-1] + $fibo[$i-2];
        }
        return $fibo;
    }

    //returns fibo array
    public function fibo0()
    {
        $num = 0;
        $fibo = [];
        $fibo[$num] = 0;
        $num++;
        $fibo[$num] = 1;

        do  {
            $num++;
            $fibo[$num] =  $fibo[$num-1] + $fibo[$num-2];
        } while ($fibo[$num] < 1000000);

        return $fibo;
    }
}