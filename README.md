# nicosmaker

a little script to create automatically symfony service and stimulus controller

place this file in your symfony project root

type
`php nicosmaker.php -h`
to get help

## hint

You could update your .bash_aliases file in your ~ directory with :

`alias nico='php nicosmaker.php'`

so, you could type :

`nico make:service load`

to create a LoadService class

With GrumPHP/phpcs :
add nicosmaker.php to gitignore because i want only one file and it launch
 script after the class body
