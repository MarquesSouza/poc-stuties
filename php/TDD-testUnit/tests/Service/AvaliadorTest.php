<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    protected function setUp():void
    {
        $this->leiloeiro = new Avaliador();
    }
    /**
     *  @dataProvider leilaoEmOrdemAleatoria
     *  @dataProvider leilaoEmOrdemCrescente
     *  @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        $valorEsperado = 2500;

        self::assertEquals($valorEsperado, $maiorValor);
    }
    /**
     *  @dataProvider leilaoEmOrdemAleatoria
     *  @dataProvider leilaoEmOrdemCrescente
     *  @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {
        // Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        $valorEsperado = 1000;

        self::assertEquals($valorEsperado, $menorValor);
    }
    /**
     *  @dataProvider leilaoEmOrdemAleatoria
     *  @dataProvider leilaoEmOrdemCrescente
     *  @dataProvider leilaoEmOrdemDecrescente
     */
    public function testAvaliadorDeveBuscarOsTresMaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maiores = $this->leiloeiro->getMaioresLances();
        static::assertCount(3, $maiores);
        static::assertEquals(2500, $maiores[0]->getValor());
        static::assertEquals(1700, $maiores[1]->getValor());
        static::assertEquals(1500, $maiores[2]->getValor());
    }

    public function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Ferrari');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($ana, 1500));
        $leilao->recebeLance(new Lance($jorge, 1700));
        $leilao->recebeLance(new Lance($maria, 2500));

        return [
            'Leilao em Ordem Crescente'=>[$leilao]
        ];
    }
    public function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Ferrari');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($jorge, 1700));
        $leilao->recebeLance(new Lance($ana, 1500));
        $leilao->recebeLance(new Lance($joao, 1000));

        return [
            'Leilao em Ordem Decrescente'=>[$leilao]
        ];
    }
    public function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Ferrari');

        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($ana, 1500));
        $leilao->recebeLance(new Lance($joao, 1000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($jorge, 1700));

        return [
            'Leilao em Ordem Aleatoria'=>[$leilao]
        ];
    }
}
