<?php
class CajeroAutomático {
    private $saldo;

    public function __construct($saldoInicial) {
        $this->saldo = $saldoInicial;
    }

    public function verSaldo() {
        echo "Su saldo actual es: $" . $this->saldo . PHP_EOL;
    }

    public function depositar($cantidad) {
        if ($cantidad > 0) {
            $this->saldo += $cantidad;
            echo "Ha depositado: $" . $cantidad . PHP_EOL;
            $this->verSaldo();
        } else {
            echo "La cantidad a depositar debe ser positiva." . PHP_EOL;
        }
    }

    public function retirar($cantidad) {
        if ($cantidad > 0 && $cantidad <= $this->saldo) {
            $this->saldo -= $cantidad;
            echo "Ha retirado: $" . $cantidad . PHP_EOL;
            $this->verSaldo();
        } elseif ($cantidad > $this->saldo) {
            echo "Fondos insuficientes." . PHP_EOL;
        } else {
            echo "La cantidad a retirar debe ser positiva." . PHP_EOL;
        }
    }
}

function mostrarMenu() {
    echo "Seleccione una opción:" . PHP_EOL;
    echo "1. Ver saldo" . PHP_EOL;
    echo "2. Depositar dinero" . PHP_EOL;
    echo "3. Retirar dinero" . PHP_EOL;
    echo "4. Salir" . PHP_EOL;
}

$cajero = new CajeroAutomático(1000);

do {
    mostrarMenu();
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            $cajero->verSaldo();
            break;
        case 2:
            echo "Ingrese la cantidad a depositar: ";
            $cantidad = trim(fgets(STDIN));
            $cajero->depositar((float)$cantidad);
            break;
        case 3:
            echo "Ingrese la cantidad a retirar: ";
            $cantidad = trim(fgets(STDIN));
            $cajero->retirar((float)$cantidad);
            break;
        case 4:
            echo "Gracias por usar el cajero automático." . PHP_EOL;
            break;
        default:
            echo "Opción no válida, intente de nuevo." . PHP_EOL;
    }
} while ($opcion != 4);
?>
