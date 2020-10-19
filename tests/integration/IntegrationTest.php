<?php

use Life\RunGameCommand;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

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
        $commandTester = new CommandTester(new RunGameCommand());

        $commandTester->execute(
            [
                '--input' => $inputFile,
                '--output' => self::OUTPUT_FILE,
            ]
        );

        $output = $this->loadXmlForComparison(self::OUTPUT_FILE);
        $expected = $this->loadXmlForComparison($expectedOutputFile);
        Assert::assertSame($expected, $output, 'Expected XML and output XML should be same');
    }

    public function getInputAndExpectedOutputFiles(): array
    {
        return [
            [__DIR__ . '/files/input1.xml', __DIR__ . '/files/expected-output1.xml'],
            [__DIR__ . '/files/input2.xml', __DIR__ . '/files/expected-output2.xml'],
            [__DIR__ . '/files/input3.xml', __DIR__ . '/files/expected-output2.xml'],
            [__DIR__ . '/files/input4.xml', __DIR__ . '/files/expected-output2.xml'],
            [__DIR__ . '/files/input5.xml', __DIR__ . '/files/expected-output5.xml'],
            [__DIR__ . '/files/input6.xml', __DIR__ . '/files/expected-output6.xml'],
            [__DIR__ . '/files/input7.xml', __DIR__ . '/files/expected-output5.xml'],
            [__DIR__ . '/files/input8.xml', __DIR__ . '/files/expected-output6.xml'],
            [__DIR__ . '/files/input9.xml', __DIR__ . '/files/expected-output5.xml'],
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
