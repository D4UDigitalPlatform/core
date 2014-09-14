<?php

namespace Itkg\Tests\Core\Command\DatabaseUpdate\Query;

use Itkg\Core\Command\DatabaseUpdate\Query\OutputQueryFactory;
use Itkg\Core\Command\DatabaseUpdate\Query\Formatter;
use Itkg\Core\Command\DatabaseUpdate\Query;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @author Pascal DENIS <pascal.denis@businessdecision.com>
 */
class OutputQueryDisplayTest extends \PHPUnit_Framework_TestCase
{
    public function testDisplay()
    {
        $outputQuery = $this->createOutputQuery();

        $query = <<<EOF
CREATE TABLE MYC_TEST_SCRIPT (
TEST_SCRIPT_ID INT,
TEST_NAME varchar(255)
)
EOF;

        $outputQuery->display(new Query($query));

        $this->assertEquals('CREATE TABLE MYC_TEST_SCRIPT (TEST_SCRIPT_ID INT,TEST_NAME varchar(255));'.PHP_EOL, $outputQuery->getOutput()->output);
    }

    public function testDisplayAll()
    {
        $outputQuery = $this->createOutputQuery();

        $query = <<<EOF
CREATE TABLE MYC_TEST_SCRIPT (
TEST_SCRIPT_ID INT,
TEST_NAME varchar(255)
)
EOF;
        $queries = array(
            new Query($query),
            new Query($query)
        );

        $outputQuery->displayAll($queries);

        $this->assertEquals(
            'CREATE TABLE MYC_TEST_SCRIPT (TEST_SCRIPT_ID INT,TEST_NAME varchar(255));'.PHP_EOL.'CREATE TABLE MYC_TEST_SCRIPT (TEST_SCRIPT_ID INT,TEST_NAME varchar(255));'.PHP_EOL, $outputQuery->getOutput()->output);
    }

    public function testFormatter()
    {
        $outputQuery = $this->createOutputQuery();
        $this->assertEquals($outputQuery, $outputQuery->setFormatter(new Formatter()));
    }

    private function createOutputQuery()
    {
        $factory = new OutputQueryFactory(new Formatter());

        return $factory
            ->create()
            ->setOutput(new Output(ConsoleOutput::VERBOSITY_NORMAL, true, new OutputFormatter()));
    }


}
