<?php

function sayHello(string $name, callable $filter)
{
  $finalName = call_user_func($filter, $name);
  echo "Hello $finalName" . PHP_EOL;
}

// sayHello("Eko", "strtoupper");

function factorial(int $n): int
{
  return ($n == 0) ? 1 : $n * factorial($n - 1);
}

// echo factorial(5);


$fruits = ["apple", "banana", "cherry"];
$lastFruit = array_pop($fruits);
// echo $lastFruit;

$fruits = ["apple", "banana", "cherry"];
$firstFruit = array_shift($fruits);
// echo $firstFruit;

$fruits = ["apple", "banana"];
array_push($fruits, "cherry", "date");
// print_r($fruits);


$fruits = ["banana", "cherry"];
array_unshift($fruits, "apple", "date");
// print_r($fruits);

$fruits1 = ["apple", "banana"];
$fruits2 = ["cherry", "date"];
$combined = array_merge($fruits1, $fruits2);
// print_r($combined);

$fruits = ["apple", "banana", "cherry"];
$reversed = array_reverse($fruits);
// print_r($reversed);

$fruits = ["apple", "banana", "cherry"];
$found = in_array("bansana", $fruits);
echo $found ? "Ditemukan" : "Tidak Ditemukan";
