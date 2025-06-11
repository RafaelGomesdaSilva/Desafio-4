<?php

class FiguraGeometrica {
    private $tipo;
    private $medidas;

    public function __construct($tipo, $medidas) {
        $this->tipo = $tipo;
        $this->medidas = $medidas;
    }

    public function calcularArea() {
        switch ($this->tipo) {
            case 'quadrado':
                $lado = $this->medidas['lado'];
                $area = pow($lado, 2);
                break;

            case 'retangulo':
                $base = $this->medidas['base'];
                $altura = $this->medidas['altura'];
                $area = $base * $altura;
                break;

            case 'circulo':
                $raio = $this->medidas['raio'];
                $area = pi() * pow($raio, 2);
                break;

            default:
                throw new Exception("Tipo de figura inválido.");
        }

        return number_format($area, 2, '.', '');
    }

    public function getTipo() {
        return ucfirst($this->tipo);
    }
}
