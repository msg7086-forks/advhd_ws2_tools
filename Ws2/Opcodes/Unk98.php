<?php
namespace Ws2\Opcodes;

class Unk98 extends AbstractOpcode
{
    public const OPCODE = '98';
    public const FUNC = 'Unk98';
    // 98 73 6B 79 62 6F 78 00 02 00 02 00 8F C2 F5 3C 8F C2 F5 3C 00 00 00 00 00 00 00 00 00 00 60 40 00 00 00 00 00 00

    public function decompile(\Helper\FastBuffer &$dataSource): self
    {
        [$channel, $channelLen] = $this->reader->readString($dataSource);
        $data1[] = $this->reader->readWord($dataSource);
        $data1[] = $this->reader->readWord($dataSource);
        $data2 = $this->reader->readFloats($dataSource, 5);
        $data3 = $this->reader->readData($dataSource, 6);
        $this->compiledSize += 1 + $channelLen + 30;

        $this->content = static::FUNC . " ({$channel}, " . implode(', ', array_merge($data1, $data2, $data3)) . ")";
        return $this;
    }

    public function preCompile(?string $params = null): self
    {
        $params = $this->reader->unpackParams($params);

        $this->content = $this->reader->convertHexToChar(static::OPCODE) .
            $this->reader->packString(array_shift($param));

        $code = pack('v2f5c6',
                ...$params
            );
        $this->content .= $code;
        return $this;
    }
}
