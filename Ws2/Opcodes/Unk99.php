<?php
namespace Ws2\Opcodes;

class Unk99 extends AbstractOpcode
{
    public const OPCODE = '99';
    public const FUNC = 'Unk99';
    // 99 73 6B 79 62 6F 78 00 00 00 00 00 00

    public function decompile(\Helper\FastBuffer &$dataSource): self
    {
        [$channel, $channelLen] = $this->reader->readString($dataSource);
        $data1 = $this->reader->readData($dataSource, 5);
        $this->compiledSize += 1 + $channelLen + 5;

        $this->content = static::FUNC . " ({$channel}, " . implode(', ', $data1) . ")";
        return $this;
    }

    public function preCompile(?string $params = null): self
    {
        $params = $this->reader->unpackParams($params);

        $this->content = $this->reader->convertHexToChar(static::OPCODE) .
            $this->reader->packString(array_shift($param));

        $code = pack('c5',
                ...$params
            );
        $this->content .= $code;
        return $this;
    }
}
