<?php
namespace Ws2\Opcodes;

class Unk9F extends AbstractOpcode
{
    public const OPCODE = '9F';
    public const FUNC = 'Unk9F';

    public function decompile(\Helper\FastBuffer &$dataSource): self
    {
        [$channel, $channelLen] = $this->reader->readString($dataSource);
        $config = $this->reader->readData($dataSource, 1);
        $this->compiledSize = 1 + $channelLen + 1;

        $this->content = static::FUNC . " ({$channel}, {$config[0]})";
        return $this;
    }

    public function preCompile(?string $params = null): self
    {
        $params = $this->reader->unpackParams($params);

        $code = $this->reader->convertHexToChar(static::OPCODE) . $this->reader->packString($params[0]) .
            pack('c',
                [$params[1]]
            );
        $this->content = $code;
        return $this;
    }
}
