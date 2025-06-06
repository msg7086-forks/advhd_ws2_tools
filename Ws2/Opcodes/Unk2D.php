<?php
namespace Ws2\Opcodes;

/**
 */
class Unk2D extends AbstractOpcode
{
    public const OPCODE = '2D';
    public const FUNC = 'Unk2D';

    public function decompile(\Helper\FastBuffer &$dataSource): self
    {
        [$variable, $varLen] = $this->reader->readString($dataSource);
        $config = $this->reader->readData($dataSource, 1);
        $this->compiledSize = 1 + $varLen + 1;

        $this->content = static::FUNC . " ({$variable}, {$config[0]})";
        return $this;
    }

    public function preCompile(?string $params = null): self
    {
        $params = $this->reader->unpackParams($params);

        $this->content = $this->reader->convertHexToChar(static::OPCODE) .
            $this->reader->packString($params[0]) . pack('c', (int)$params[1]);
        return $this;
    }
}
