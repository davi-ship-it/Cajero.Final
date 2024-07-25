<?php
// Clase que contiene todas las funciones necesarias para que el código funcione en su totalidad
class CajeroAutomático {
    private $tarjetas;

    public function __construct() {
        $this->tarjetas = [];
    }

    public function agregarTarjeta($numeroSerie, $contraseña, $saldoInicial) {
        $this->tarjetas[$numeroSerie] = [
            'contraseña' => $contraseña,
            'saldo' => $saldoInicial
        ];
        echo "Tarjeta con número de serie $numeroSerie agregada con éxito." . PHP_EOL;
    }

    public function autenticarTarjeta($numeroSerie, $contraseña) {
        if (isset($this->tarjetas[$numeroSerie]) && $this->tarjetas[$numeroSerie]['contraseña'] === $contraseña) {
            return true;
        }
        return false;
    }

    public function verSaldo($numeroSerie) {
        echo "Su saldo actual es: $" . $this->tarjetas[$numeroSerie]['saldo'] . PHP_EOL;
    }

    public function depositar($numeroSerie, $cantidad) {
        if ($cantidad > 0) {
            $this->tarjetas[$numeroSerie]['saldo'] += $cantidad;
            echo "Ha depositado: $" . $cantidad . PHP_EOL;
            $this->verSaldo($numeroSerie);
        } else {
            echo "La cantidad a depositar debe ser positiva." . PHP_EOL;
        }
    }

    public function retirar($numeroSerie, $cantidad) {
        if ($cantidad > 0 && $cantidad <= $this->tarjetas[$numeroSerie]['saldo']) {
            $this->tarjetas[$numeroSerie]['saldo'] -= $cantidad;
            echo "Ha retirado: $" . $cantidad . PHP_EOL;
            $this->verSaldo($numeroSerie);
        } elseif ($cantidad > $this->tarjetas[$numeroSerie]['saldo']) {
            echo "Fondos insuficientes." . PHP_EOL;
            echo "¿Desea depositar dinero? (sí/no): ";
            $respuesta = trim(fgets(STDIN));
            if (strtolower($respuesta) === 'sí' || strtolower($respuesta) === 'si') {
                echo "Ingrese la cantidad a depositar: ";
                $cantidadDeposito = trim(fgets(STDIN));
                $this->depositar($numeroSerie, (float)$cantidadDeposito);
            }
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

$cajero = new CajeroAutomático();

// Agregar tarjetas de ejemplo

$cajero->agregarTarjeta('987654', '123', 100);
$cajero->agregarTarjeta('123456', '123', 1500);
$cajero->agregarTarjeta('123789', '123', 0);

echo "Ingrese el número de serie de la tarjeta: ";
$numeroSerie = trim(fgets(STDIN));
echo "Ingrese la contraseña de la tarjeta: ";
$contraseña = trim(fgets(STDIN));

if ($cajero->autenticarTarjeta($numeroSerie, $contraseña)) {
    do {
        mostrarMenu();
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case 1:
                $cajero->verSaldo($numeroSerie);
                break;
            case 2:
                echo "Ingrese la cantidad a depositar: ";
                $cantidad = trim(fgets(STDIN));
                $cajero->depositar($numeroSerie, (float)$cantidad);
                break;
            case 3:
                echo "Ingrese la cantidad a retirar: ";
                $cantidad = trim(fgets(STDIN));
                $cajero->retirar($numeroSerie, (float)$cantidad);
                break;
            case 4:
                echo "Gracias por usar el cajero automático." . PHP_EOL;
                break;
            default:
                echo "Opción no válida, intente de nuevo." . PHP_EOL;
        }
    } while ($opcion != 4);
} else {
    echo "Autenticación fallida. Número de serie o contraseña incorrectos." . PHP_EOL;
}
?>
