<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    /** @var bool  */
    private $finalizado;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {
        if ($this->estaFinalizado()) {
            throw new \DomainException("Leilão não pode receber lances apos estar finalizado");
        }
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
            throw new \DomainException('Usuário não pode propor 2 lances seguidos');
        }
        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());
        if ($totalLancesUsuario >= 5) {
            throw new \DomainException('Usuário não propor mais de 5 lances por leilão');
        }
        $this->lances[] = $lance;
    }

    /**
     * @param Lance $lance
     * @return bool
     */
    public function ehDoUltimoUsuario(Lance $lance): bool
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() == $ultimoLance->getUsuario();
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }
    /**
     * @return Lance
     */
    public function getUltimoLance()
    {
        if (empty($this->getLances())) {
            throw new \DomainException('Leilão vazio!');
        }
        return $this->lances[array_key_last($this->getLances())];
    }
    public function finaliza()
    {
        $this->finalizado = true;
    }

    public function estaFinalizado(): bool
    {
        return $this->finalizado;
    }
    /**
     * @param Usuario $usuario
     * @return Lance|mixed
     */
    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        $totalLancesUsuario = array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }
                return $totalAcumulado;
            },
            0
        );
        return $totalLancesUsuario;
    }
}
