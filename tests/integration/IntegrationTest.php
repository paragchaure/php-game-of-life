<?php

use Life\Game;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{

    private const OUTPUT_FILE = 'output.xml';

    protected function tearDown(): void
    {
        parent::tearDown();
        $outputFilePath = $this->getFilePath(self::OUTPUT_FILE);
        if (file_exists($outputFilePath)) {
            unlink($outputFilePath);
        }
    }

    /**
     * @dataProvider getInputAndExpectedOutputFiles
     * @param string $inputFile
     * @param string $expectedOutputFile
     */
    public function testGame(string $inputFile, string $expectedOutputFile): void
    {
        $game = new Game();
        $inputFile = $this->getFilePath($inputFile);
        $outputFile = $this->getFilePath(self::OUTPUT_FILE);

        $game->run($inputFile, $outputFile);

        $output = $this->loadXmlForComparison(self::OUTPUT_FILE);
        $expected = $this->loadXmlForComparison($expectedOutputFile);
        Assert::assertSame($expected, $output, 'Expected XML and output XML should be same');
    }

    public function getInputAndExpectedOutputFiles(): array
    {
        return [
            ['input1.xml', 'expected-output1.xml'],
            ['input2.xml', 'expected-output2.xml'],
            ['input3.xml', 'expected-output2.xml'],
            ['input4.xml', 'expected-output2.xml'],

            ['input5.xml', 'expected-output5.xml'],
            ['input6.xml', 'expected-output6.xml'],
            ['input7.xml', 'expected-output5.xml'],
            ['input8.xml', 'expected-output6.xml'],
            ['input9.xml', 'expected-output5.xml'],
        ];
    }

    private function loadXmlForComparison(string $partialFilePath): string
    {
        $filePath = $this->getFilePath($partialFilePath);
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->load($filePath);
        return $dom->saveXML();
    }

    private function getFilePath(string $partialFilePath): string
    {
        return __DIR__ . '/files/' . $partialFilePath;
    }

}
