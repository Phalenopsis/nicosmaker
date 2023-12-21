<?php

class NicosMaker
{
    private const POSSIBILITIES = ['-h', 'make:jscontroller', 'make:service'];
    private array $args;
    private string $order;
    private ?string $fileName;

    public function __construct(array $args)
    {
        $this->args = $args;
        $this->main();
    }

    private function main(): void
    {
        if (!$this->isRequestWellBuilt()) {
            $this->requestHelp();
            die;
        }
        $this->order = $this->args[1];
        // if ($this->order === '-h') {
        //     $this->launchHelp();
        //     die;
        // }
        $this->fileName = $this->args[2] ?? null;
        $action = match ($this->order) {
            '-h' => 'launchHelp',
            'make:service' => 'makeService',
            'make:jscontroller' => 'makeJsController',
            'make:coffee' => 'makeCoffee',
            default => 'showError'
        };
        $this->$action();
    }

    private function showError(string $str = "Command not recognized")
    {
        echo "\033[31m" . $str . "\033[0m" . PHP_EOL;
    }

    private function showSucces(string $str = "Succes!")
    {
        echo "\033[32m" . $str . "\033[0m" . PHP_EOL;
    }

    private function requestHelp(): void
    {
        echo 'use -h for help';
    }

    private function launchHelp(): void
    {
        echo 'please type :' . PHP_EOL;
        echo 'make:jscontroller name' . PHP_EOL;
        echo 'to create a clipboard_controller.js, type make:jscontroller clipboard' . PHP_EOL . PHP_EOL;
        echo 'make:service name' . PHP_EOL;
        echo 'to create a ClipboardService.php, type make:service clipboard' . PHP_EOL;
    }

    private function isRequestWellBuilt(): bool
    {
        return  count($this->args) >= 2;
    }

    private function createDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            if (mkdir($dir, 0777, true)) {
                $this->showSucces("directory " . $dir . " created");
            } else {
                $this->showError("Couldn't create directory " . $dir);
                die;
            }
        }
    }

    private function checkFile(string $file): void
    {
        if (is_file($file)) {
            $this->showError("file already exists");
            die;
        }
    }

    private function checkFileName(): void
    {
        if ($this->fileName === null) {
            $this->showError("you forgot the filename");
            die;
        }
    }

    private function makeService()
    {
        $this->checkFileName();
        $class = ucfirst($this->fileName);
        $dir = './src/Service';
        $this->createDirectory($dir);

        $file = $dir . '/' . $class . 'Service.php';
        $this->checkFile($file);

        $fileToWrite = fopen($file, 'w');
        fwrite($fileToWrite, '<?php' . PHP_EOL);
        fwrite($fileToWrite, PHP_EOL);
        fwrite($fileToWrite, 'namespace App\\Service;' . PHP_EOL);
        fwrite($fileToWrite, PHP_EOL);
        fwrite($fileToWrite, 'class ' . $class . PHP_EOL);
        fwrite($fileToWrite, '{' . PHP_EOL);
        fwrite($fileToWrite, '}' . PHP_EOL);
        fclose($fileToWrite);
        echo "\033[32mfile " . $file . " created\033[0m" . PHP_EOL;
    }

    private function makeJsController()
    {
        $this->checkFileName();
        $dir = './assets/controllers';
        $this->createDirectory($dir);

        $file = $dir . '/' . strtolower($this->fileName) . '_controller.js';
        $this->checkFile($file);

        $fileToWrite = fopen($file, 'w');
        fwrite($fileToWrite, "import { Controller } from '@hotwired/stimulus';" . PHP_EOL);
        fwrite($fileToWrite, PHP_EOL);
        fwrite($fileToWrite, "export default class extends Controller {" . PHP_EOL);
        fwrite($fileToWrite, "\tstatic targets =  ['target_name'];" . PHP_EOL);
        fwrite($fileToWrite, PHP_EOL);
        fwrite($fileToWrite, "\tconnect()" . PHP_EOL);
        fwrite($fileToWrite, "\t{" . PHP_EOL);
        fwrite($fileToWrite, "\t\tconsole.log('example connect');" . PHP_EOL);
        fwrite($fileToWrite, "\t}" . PHP_EOL);
        fwrite($fileToWrite, "}" . PHP_EOL);
        echo "\033[32mfile " . $file . " created\033[0m" . PHP_EOL;
    }

    private function makeCoffee(): void
    {
        $this->showSucces("I need one too !");
    }

    private function createAlias()
    {
        // in construct
        $dir = '~';
        var_dump(is_dir($dir));
    }
}

new NicosMaker($argv);
